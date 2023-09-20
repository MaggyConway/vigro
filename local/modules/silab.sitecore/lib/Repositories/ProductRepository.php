<?php

/*
 * This file is part of maxonor project
 * Copyright 2022 dimay.
 */

namespace Silab\SiteCore\Repositories;

use Silab\SiteCore\Orm\Iblock\Elements\ElementCatalogvigroTable;
use Bitrix\Catalog\PriceTable;

if (!\Bitrix\Main\Loader::includeModule('iblock'))
{
    die();
}

if (!\Bitrix\Main\Loader::includeModule('catalog'))
{
    die();
}

/**
 * Description of ProductRepository
 *
 * @author dimay
 */
final class ProductRepository
{    
    private const CDN_IMAGES_PATH = 'https://cdn.sntinvest.ru/media/img';
    
    /**
     * Get list by XmlID
     * @param array|string $xmlID
     * @return 
     * @throws Exception
     */
    public function getList(array $params, bool $isObject = false)
    {
        $builder = ElementCatalogvigroTable::getList($params);
        
        return $isObject ? $builder->fetchcollection() : $builder->fetchAll();
    }
    
    /**
     * Get list by XmlID
     * @param array|string $xmlID
     * @return 
     * @throws Exception
     */
    public function count(array $params)
    {
        $count = ElementCatalogvigroTable::getCount($params);
        
        return $count;
    }
    
    /**
     * Get list by XmlID
     * @param array|string $xmlID
     * @return 
     * @throws Exception
     */
    public function findByXmlId($xmlID, array $select = [], bool $isObject = false)
    {
        if (
                !is_array($xmlID) && count($xmlID) <= 0
                && 
                !is_string($xmlID) && strlen($xmlID) <= 0
            )
        {
            throw new \Exception('no argument');
        }
        
        $filter = [
            "=XML_ID" => $xmlID,
        ];
        
        return $this->getList([
            'select' => $select,
            'filter' => $filter,
        ], $isObject);
    }
    
    public function findById($id, array $select = [], bool $isObject = false, int $limit = 50, int $offer = 0)
    {
        if (
                !is_array($id) && count($id) <= 0
                && 
                !is_string($id) && strlen($id) <= 0
            )
        {
            throw new \Exception('no argument');
        }
        
        $filter = [
            "=ID" => $id,
        ];
        
        return $this->getList([
            'select' => $select,
            'filter' => $filter,
            'limit'   => $limit,
            'offset'  => $offer,
        ], $isObject);
    }

    
    public function countById($id)
    {
        if (
                !is_array($id) && count($id) <= 0
                && 
                !is_string($id) && strlen($id) <= 0
            )
        {
            throw new \Exception('no argument');
        }
        
        $filter = [
            "=ID" => $id,
        ];
        
        return $this->count($filter);
    }

    
    public  function getPrice($id, array $select = ["*"], bool $isObject = false)
    {
        if (
            !is_array($id) && count($id) <= 0
            && 
            !is_string($id) && strlen($id) <= 0
        )
        {
            throw new \Exception('no argument');
        }
        
        $filter = [
            "=PRODUCT_ID" => $id
        ];
        
        $builder = PriceTable::getList([
            'select' => $select,
            'filter' => $filter,
        ]); 

        return $isObject ? $builder->fetchcollection() : $builder->fetchAll();
    }
    
    /**
     * Convert Image Path
     * 
     * @param string $cdnImgesList
     * @param string $articul
     * @return array
     */
    public static function ConvertImagePath(string $cdnImgesList, string $articul) : array
    {
        $arItems = [];
        
        $arList = explode(',', $cdnImgesList);
        
        foreach ($arList as $item)
        {
            $arItems[] = static::CDN_IMAGES_PATH
                            . "/"
                            . substr( $articul, 0, 3 ) 
                            . "/"
                            . $articul
                            . "/" 
                            . $item;
        }
        
        return $arItems;
    }
    
    public static function GetDetailPageUrl($product) 
    {
        //TODO cache or by datas
        $item = \CIBlockElement::GetList([],
                [
                    '=IBLOCK_ID' => $product['IBLOCK_ID'], 
                    '=ID' => $product['ID']
                ], 
                false,
                false,
                [
                    'ID',
                    'DETAIL_PAGE_URL'
                ])->GetNext();
        
        return $item['DETAIL_PAGE_URL'];
    }
}
