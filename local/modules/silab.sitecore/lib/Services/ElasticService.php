<?php
namespace Silab\SiteCore\Services;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Silab\SiteCore\Repositories\ProductRepository;
use Silab\SiteCore\Interfaces\SearchServiceInterface;

final class ElasticService implements SearchServiceInterface
{
    private $repository;

    public function __construct()
    {
        $this->repository = new ProductRepository();
    }
    private function getClient() : Client
    {
        $client = ClientBuilder::create()
                ->setSSLVerification(false)
                ->setHosts(explode(',', $_ENV['ELASTICSEARCH_HOSTS']))
                ->setBasicAuthentication(
                    $_ENV['ELASTICSEARCH_USER'], 
                    $_ENV['ELASTICSEARCH_PASSWORD']
                )
                ->build();

        return $client;
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
        
        $size = $params['size'] ?? 10;
        $from = $params['from'] ?? 0;
        $sort = $params['sort'] ?? [];
        $_source = $params['_source'] ?? [];
        
        $response = $this->getClient()->search([
            'index' => 'catalog',
            'body' => [
                'size' => $size,
                'from' => $from,
                'sort' => $sort,
                '_source' => $_source,
                'query' => [
                    // Ищем как есть
                    'bool' => [
                        'must' => [
                            [
                                'bool' => [
                                    // Или
                                    'should' => [
                                        // ищем по названию, если идёт совпадение по части слова
                                        [
                                            'query_string' => [
                                                "query" => "*$query*",
                                                "fields" => [ "name" ],
                                            ],
                                        ],
                                        // ищем по короткому описанию, по полной фразе (с одним возможным смещением)
                                        [
                                            'match_phrase' => [
                                                'preview' => [
                                                    "query" => $query,
                                                    "slop" => 1
                                                ],
                                            ],
                                        ],
                                        // ищем по деатльному описанию, по полной фразе (с одним возможным смещением)
                                        [
                                            'match_phrase' => [
                                                'detail' => [
                                                    "query" => $query,
                                                    "slop" => 1
                                                ],
                                            ],
                                        ],
                                        // ищем по полному совпадению внутренего артикула
                                        [
                                            'term' => [
                                                'sntinvest_articul' => $query,
                                            ],
                                        ],
                                        // ищем по полному совпадению артикула производителя
                                        [
                                            'term' => [
                                                'fac_articul' => $query,
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ],
                        "filter" => [
                            [
                                "term" => [
                                    "brand" => "Maxonor"
                                ],
                            ]
                        ],
                    ],
                ],
            ],
        ]);

        $items = array_map(function ($item) {
            return $item['_source']['xml_id'];
        }, $response['hits']['hits']);
            
        return $this->getResult($this->buildCollection($items), $response['hits']['total']['value']);
    }
    
    
    private function getResult (array $items, int $total) 
    {
        return  new class ($items, $total) 
        {
            public $items;
            public $total;
            
            public function __construct($items, $total)
            {
                $this->items = $items;
                $this->total = $total;
            }
        };
    }

    private function buildCollection (array $items) : array
    {
        $arItems = [];
        $arItems = [];
        
        $products = $this->repository->findByXmlId($items, [
            '*',
            'CDN_IMAGES_LIST_' => 'CDN_IMAGES_LIST',
            'SANINVEST_ARTICUL_' => 'SANINVEST_ARTICUL',
            'IBLOCK',
            'IBLOCK_SECTION',
        ]);

        foreach ($products as $product)
        {
            $product['IMAGE'] = array_shift(ProductRepository::ConvertImagePath($product['CDN_IMAGES_LIST_VALUE'], $product['SANINVEST_ARTICUL_VALUE']));
            $product['DETAIL_PAGE_URL'] = ProductRepository::GetDetailPageUrl($product);
            
            $product['PRICE'] = 0;
            $product['PRICE_FORMAT'] = '';

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