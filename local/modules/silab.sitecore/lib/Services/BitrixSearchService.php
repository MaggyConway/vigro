<?php
namespace Silab\SiteCore\Services;

if (!\Bitrix\Main\Loader::IncludeModule("search"))
    return; 

use Silab\SiteCore\Repositories\ProductRepository;
use Silab\SiteCore\Interfaces\SearchServiceInterface;

final class BitrixSearchService implements SearchServiceInterface
{
    private $repository;

    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function searchProduct(
        string $query,
        array $params = []
        ) 
    {
        $obSearch = new \CSearch;
        
        $obSearch->SetOptions(['ERROR_ON_EMPTY_STEM' => false,]);
        
        $arSort = [
            'CUSTOM_RANK' => 'DESC',
            'TITLE_RANK' => 'DESC',
            'RANK' => 'DESC',
            'DATE_CHANGE' => 'DESC'
        ]; 

        $obSearch->Search(array(
           'QUERY' => $query,
           'SITE_ID' => SITE_ID,
           'MODULE_ID' => 'iblock',
           'PARAM2' => $_ENV['CATALOG_ID']
        ), $arSort);

        if (!$obSearch->selectedRowsCount()) {//и делаем резапрос, если не найдено с морфологией...
           $obSearch->Search(array(
              'QUERY' => $query,
              'SITE_ID' => SITE_ID,
              'MODULE_ID' => 'iblock',
              'PARAM2' => $_ENV['CATALOG_ID']
           ), $arSort, array('STEMMING' => false));//... уже с отключенной морфологией
        }  

        $arItems = [];
        
        while ($arSearch = $obSearch->Fetch()) {
            $arSearch['TITLERANK'] = 0;
            similar_text($arSearch['TITLE'],$query,$arSearch['TITLERANK']);
            $arItems[$arSearch['ITEM_ID']] = $arSearch;
        }
        
        $obSearch->Statistic = new \CSearchStatistic($obSearch->strQueryText, $obSearch->strTagsText);
        $obSearch->Statistic->PhraseStat($obSearch->NavRecordCount, $obSearch->NavPageNomer);
        
        usort($arItems, function ($a, $b){
                if ($a['TITLERANK'] == $b['TITLERANK']) {
                        return 0;
                }
                return ($a['TITLERANK'] > $b['TITLERANK']) ? -1 : 1;
        });

        $items = array_map(function ($item)
        {
            return $item['ITEM_ID'];
        }, $arItems);

        return $items;
    }

    public function searchCategories(
        string $query,
        array $params = []
        ) 
    {
        $rsSect = \CIBlockSection::GetList([], [
            'IBLOCK_ID' => $_ENV['CATALOG_ID'],
            'NAME' => '%'.$query.'%'
        ]);

        $items = [];

        while ($arSect = $rsSect->GetNext())
        {
            $items[] =  [
                "NAME" => $arSect['NAME'],
                "SECTION_PAGE_URL" => $arSect['SECTION_PAGE_URL'],
            ];
        }

        return $items;
    }

    public function getCategoriesByProducts($products)
    {
        $items = [];

        foreach ($products as $product)
        {
            if (!is_null($product['SILAB_SITECORE_ORM_IBLOCK_ELEMENTS_ELEMENT_CATALOGVIGRO_IBLOCK_SECTION_NAME']))
            {
                $items[$product['SILAB_SITECORE_ORM_IBLOCK_ELEMENTS_ELEMENT_CATALOGVIGRO_IBLOCK_SECTION_ID']] =  [
                    "NAME" => $product['SILAB_SITECORE_ORM_IBLOCK_ELEMENTS_ELEMENT_CATALOGVIGRO_IBLOCK_SECTION_NAME'],
                    "SECTION_PAGE_URL" => "/shop/" . $product['SILAB_SITECORE_ORM_IBLOCK_ELEMENTS_ELEMENT_CATALOGVIGRO_IBLOCK_SECTION_CODE'] . "/",
                ];
            }
        }

        return array_values($items);
    }

    /**
     * Search 
     * 
     * @param string $query Запрос
     * @param int $params[size] Количество документов в ответе. По умолчанию 10.
     * @param int $params[from] Смещение результатов
     * @param array $params[sort] Сортировка результата
     * @param array $params[_source] Поля которые попадут в ответ.
     * 
     * @param int $timeout Тайм-аут запроса. По умолчанию его нет.
     * @param int $aggs Агрегация
     * @return array
     */
    public function search(
            string $query,
            array $params = []
            ) 
    {
        
        $itemsProducts = $this->searchProduct($query, $params);
        
        $products = $this->buildCollection($itemsProducts, $params);

        $total =  $this->repository->countById($itemsProducts);

        $pages = intval(ceil($total / $params['size']));

        $categories = $this->searchCategories($query, $params);
        
        if (!is_array($categories) || count($categories) <= 0)
        {
            $categories = $this->getCategoriesByProducts($products);
        }

        return  $this->getResult($products, $pages, $categories);
    }
    
    private function getResult (array $products, int $total, array $categories) 
    {
        return  new class ($products, $total, $categories) 
        {
            public $products;
            public $pages;
            public $categories;
            
            public function __construct($products, $pages, $categories)
            {
                $this->products = $products;
                $this->pages = $pages;
                $this->categories = $categories;
            }
        };
    }

    private function buildCollection (array $items, $params) : array
    {
        $arItems = [];

        $offer = $params['size'] * $params['page'] - $params['size'];

        $wishlist = (new \Silab\SiteCore\Repositories\WishlistRepository)->getList();

        $products = $this->repository->findById($items, [
            '*',
            'CDN_IMAGES_LIST_' => 'CDN_IMAGES_LIST',
            'SANINVEST_ARTICUL_' => 'SANINVEST_ARTICUL',
            'IBLOCK',
            'IBLOCK_SECTION',
            'IBLOCK_SECTION_ID',
        ], false, $params['size'], $offer);

        foreach ($products as $product)
        {
            $product['IMAGE'] = array_shift(ProductRepository::ConvertImagePath($product['CDN_IMAGES_LIST_VALUE'], $product['SANINVEST_ARTICUL_VALUE']));
            $product['DETAIL_PAGE_URL'] = ProductRepository::GetDetailPageUrl($product);
            
            $product['PRICE'] = 0;
            $product['PRICE_FORMAT'] = '';

            $product['WISH'] = in_array($product['ID'], $wishlist);

            $arItems[$product['ID']] = $product;
        }
        
        $arIds = array_keys($arItems);

        $arPrices = $this->repository->getPrice($arIds);

        foreach ($arPrices as $price)   
        { 
            $arItems[$price['PRODUCT_ID']]['PRICE'] = $price['PRICE'];
            $arItems[$price['PRODUCT_ID']]['PRICE_FORMAT'] =  number_format($price['PRICE'], 2, '.', ' ') ?? '';
        }

        return array_values($arItems);
    }
    
}