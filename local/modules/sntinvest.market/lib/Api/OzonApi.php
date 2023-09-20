<?php

namespace Sntinvest\Market\Api;
use Bitrix\Main\Config\Option;
use Sntinvest\Market\Interfaces\iApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class OzonApi implements iApi 
{
    private $client;
    
    public const OZON_API_URL = 'https://api-seller.ozon.ru';
    
   private $default_date = '-3 day';

    public function __construct() {
        $this->client = new Client([
            'headers' => [
                'Client-Id' => $_ENV['SNTINVEST_MARKET_OZON_CLIENT_ID'],
                'Api-Key' => $_ENV['SNTINVEST_MARKET_OZON_APT_KEY'],
                'Content-Type' => 'application/json'
            ],
        ]);
    }
    
    protected function sendRequest(string $method, string $url, array $params = array()) : array
    {
        try 
        {
            $respoce = $this->client->request($method, self::OZON_API_URL . $url, [
                    'json' => $params,
            ])->getBody();
        }
        catch (ClientException $ex) 
        {
            $respoce = $ex->getResponse()->getBody()->getContents();
        }
        finally 
        {
            $result = json_decode($respoce, 1);    
        }
        
        return $result;
    }

    /**
     * Получаем весь список товаров (PRODUCT_ID, OFFER_ID) или обновление остатков (если установлен фильтр)
     * https://docs.ozon.ru/api/seller/#operation/ProductAPI_GetProductList
     * @param int $page
     * @param int $page_size
     */
    public function getProductsList(int $page, int $page_size, $filter = false)
    {
        $arItems = array();

        $arParams = [
            'limit' => $page_size,
        ];

        if($filter){
            $arParams['filter'] = [
                'visibility' => 'IN_SALE'
            ];
        }

        $result = $this->sendRequest('POST', '/v2/product/list', $arParams);
        
        if (count($result['result']['items']) < intval($result['result']['total']))
        {
            $arItems = array_merge($arItems, $result['result']['items']);

            $total = intval($result['result']['total']);

            $pages = ceil($total / $page_size);

            for($i=($page+1); $i <= $pages; $i++)
            {
                $arParams = [
                    'last_id' => $result['result']['last_id'],
                    'limit' => $page_size,
                ];

                if($filter){
                    $arParams['filter'] = [
                        'visibility' => 'IN_SALE'
                    ];
                }

                $resultNext = $this->sendRequest('POST', '/v2/product/list', $arParams);

                if (is_array($resultNext['result']['items']) && count($resultNext['result']['items']) > 0)
                {
                    $arItems = array_merge($arItems, $resultNext['result']['items']);
                }

            }

            $result['result']['items'] = $arItems;

        }
        return $result;
    }

    /**
     * Получаем ссылку на товар (SKU)
     * https://docs.ozon.ru/api/seller/#operation/ProductAPI_GetProductList
     * @param int $page
     * @param int $page_size
     */
    public function getProductsSku($params)
    {
        $result = [];
        foreach($params['offer_id'] as $key => $value)
        {
            $prepareRequest = [
                'offer_id' => $params['offer_id'][$key]
            ];

            $prepareResult = $this->sendRequest('POST', '/v2/product/info/list', $prepareRequest);

            $result = array_merge($result, $prepareResult['result']['items']);

        }

        return $result;

    }


    /**
      * https://cb-api.ozonru.me/apiref/ru/#t-title_get_product_info_prices
      * 
      * @param int $page
      * @param int $page_size
      */   
    public function productInfoPrices(int $page = 1, int $page_size = 100)
    {
        $arItems = array();
        
        $result = $this->sendRequest('POST', '/v1/product/info/prices', [
            'page' => $page,
            'page_size' => $page_size,
        ]);
        
        if (count($result['result']['items']) < intval($result['result']['total']))
        {
            $arItems = array_merge($arItems, $result['result']['items']);
            
            $total = intval($result['result']['total']);
            
            $pages = ceil($total / $page_size);
            
            for($i=($page+1); $i <= $pages; $i++)
            {
                $resultNext = $this->sendRequest('POST', '/v1/product/info/prices', [
                    'page' => $i,
                    'page_size' => $page_size,
                ]);
                
                if (is_array($resultNext['result']['items']) && count($resultNext['result']['items']) > 0)
                {
                    $arItems = array_merge($arItems, $resultNext['result']['items']);
                }
                
                sleep(2);
            }
        
            $result['result']['items'] = $arItems;
        }
        
        return $result;
    }
    
    /**
     * https://docs.ozon.ru/api/seller#/v2/posting/fbo/get
     * 
     * @param \DateTime $since
     * @param \DateTime $to
     * @param string $dir
     * @param int $limit
     * @param int $offset
     */
    public function postingFboList(
            \DateTime $since = null,
            \DateTime $to = null,
            string $dir = "asc",
            array $filter = null,
            int $limit = 100, 
            int $offset = 0,
            bool $translit = true,
            bool $analytics_data = true,
            bool $financial_data = true
    ) {
        if (is_null($since))
        {
            $since = new \DateTime($this->default_date);
            $since->setTime(0, 0, 0, 0);
        }
        
        if (is_null($to))
        {
            $to = new \DateTime();
            $to->setTime(23, 59, 59, 59);
        }
        
        if (!is_array($filter)
                || count($filter) <= 0)
        {
            $filter = array();
        }
        
        $filter["since"] = $since->format('Y-m-d\TH:i:s.v\Z');
        $filter["to"] = $to->format('Y-m-d\TH:i:s.v\Z');
        
        $result = $this->sendRequest('POST', '/v2/posting/fbo/list', [
            "dir" => $dir,
            "filter" => $filter,
            "limit" => $limit,
            "offset" => $offset,
            "translit" => $translit,
            "with" => array(
                "analytics_data" => $analytics_data,
                "financial_data" => $financial_data,
            ),
        ]);
        
        $offset += $limit;
        
        if (count($result['result']) > 0)
        {
            $nextResult = $this->postingFboList(
                    $since, 
                    $to, 
                    $dir, 
                    $filter,
                    $limit, 
                    $offset,
                    $translit, 
                    $analytics_data,
                    $financial_data
                );
            
            if (count($nextResult['result']) > 0)
            {
                $result['result'] = array_merge($result['result'], $nextResult['result']);
            }
        }
        
        return $result;
    }
    
    /**
     * https://docs.ozon.ru/api/seller#/v3/finance/transaction/totals
     * 
     * @param \DateTime $since
     * @param \DateTime $to
     * @param string $dir
     * @param int $limit
     * @param int $offset
     */
    public function v3FinanceTransactionList(
            \DateTime $from = null,
            \DateTime $to = null,
            string $type = "all",
            string $posting_number = null,
            int $page = 1, 
            int $page_size = 100
    ) {
        if (is_null($from))
        {
            $from = new \DateTime($this->default_date);
            $from->setTime(0, 0, 0, 0);
        }
        
        if (is_null($to))
        {
            $to = new \DateTime();
            $to->setTime(23, 59, 59, 59);
        }
        
        $filter = array(
            'date' => array()
        );
        
        $filter["date"]["from"] = $from->format('Y-m-d\TH:i:s.v\Z');
        $filter["date"]["to"] = $to->format('Y-m-d\TH:i:s.v\Z');
        
        $filter['posting_number'] = $posting_number;
        
        if (is_null($posting_number))
        {
            $filter['transaction_type'] = $type;
        }
        
        $result = $this->sendRequest('POST', '/v3/finance/transaction/list', [
            'filter' => $filter,
            "page" => $page,
            "page_size" => $page_size,
        ]);
        
        return $result;
    }
    
    /**
     * https://docs.ozon.ru/api/seller#/v2/posting/fbs/list
     * 
     * @param \DateTime $since
     * @param \DateTime $to
     * @param string $dir
     * @param int $limit
     * @param int $offset
     */
    public function postingFbsList(
            \DateTime $since = null,
            \DateTime $to = null,
            string $dir = "asc",
            array $filter = null,
            int $limit = 100, 
            int $offset = 0,
            bool $translit = true,
            bool $analytics_data = true,
            bool $financial_data = true
    ) {
        if (is_null($since))
        {
            $since = new \DateTime('-3 day');
            $since->setTime(0, 0, 0, 0);
        }
        
        if (is_null($to))
        {
            $to = new \DateTime();
            $to->setTime(23, 59, 59, 59);
        }
        
        if (!is_array($filter)
                || count($filter) <= 0)
        {
            $filter = array();
        }
        
        $filter["since"] = $since->format('Y-m-d\TH:i:s.v\Z');
        $filter["to"] = $to->format('Y-m-d\TH:i:s.v\Z');
//        
//        $result = $this->sendRequest('POST', '/v3/posting/fbs/list', [
//            "dir" => $dir,
//            "filter" => $filter,
//            "limit" => $limit,
//            "offset" => $offset,
//            "translit" => $translit,
//            "with" => array(
//                "analytics_data" => $analytics_data,
//                "financial_data" => $financial_data,
//            ),
//        ]);
        
        return array(
            "result" => array(
                [
                    "analytics_data" => array(
                        "city" => "Красногорск",
                        "delivery_type" => "Courier",
                        "is_premium" => false,
                        "payment_type_group_name" => "Карты оплаты",
                        "region" => "МОСКОВСКАЯ ОБЛАСТЬ",
                        "warehouse_id" => 19262731541000,
                        "warehouse_name" => "ХОРУГВИНО_КГТ",

                    ),
                    "barcodes" => array(
                        "lower_barcode" => "",
                        "upper_barcode" => "",
                    ),
                    "cancel_reason_id" => 0,
                    "created_at" => "2021-03-29T18:57:51.847Z",
                    "financial_data" => array(
                        "products" => array(
                            [
                                "actions" => array(
                                    "Системная виртуальная скидка селлера",
                                    "Маркетплейс промо № 6"
                                ),
                                "commission_amount" => 433.68,
                                "commission_percent" => 8,
                                "old_price" => 6951,
                                "payout" => 4987.32,
                                "picking" => null,
                                "price" => 5421,
                                "product_id" => 214865605,
                                "total_discount_percent" => 1530,
                                "total_discount_value" => 22.01,
                            ]
                        ),
                    ),
                    "in_process_at" => "2021-03-29T18:58:32.197Z",
                    "order_id" => 257903296,
                    "order_number" => "19127784-0033",
                    "posting_number" => "19127784-0033-2",
                    "products" => array(
                        [
                            "mandatory_mark" => array(),
                            "name" => "Смеситель для кухни Maxonor MN4352-7",
                            "offer_id" => "149932",
                            "price" => "5421.00",
                            "quantity" => 1,
                            "sku" => 214865605,
                        ],
                    ),
                    "shipment_date" => "2021-03-29T18:58:32.197Z",
                    "status" => "delivered",
                ],
            ),
        );
    }
    
    
    public function v3PostingFbsList(
            \DateTime $since = null,
            \DateTime $to = null,
            string $dir = "asc",
            array $filter = null,
            int $limit = 100,
            int $offset = 0,
            bool $translit = true,
            bool $analytics_data = true,
            bool $financial_data = true
    ) {
        if (is_null($since)) {
            $since = new \DateTime('-3 day');
            $since->setTime(0, 0, 0, 0);
        }

        if (is_null($to)) {
            $to = new \DateTime();
            $to->setTime(23, 59, 59, 59);
        }

        if (!is_array($filter) || count($filter) <= 0) {
            $filter = array();
        }

        $filter["since"] = $since->format('Y-m-d\TH:i:s.v\Z');
        $filter["to"] = $to->format('Y-m-d\TH:i:s.v\Z');
        
//        $result = $this->sendRequest('POST', '/v3/posting/fbs/list', [
//            "dir" => $dir,
//            "filter" => $filter,
//            "limit" => $limit,
//            "offset" => $offset,
//            "translit" => $translit,
//            "with" => array(
//                "analytics_data" => $analytics_data,
//                "financial_data" => $financial_data,
//            ),
//        ]);
//        
//        return $result;
        
        return array(
            'result' => array(
                'has_next' => true,
                'postings' => array(
                    0 => array(
                        'addressee' => array(
                            'name' => 'Дмитрий',
                            'phone' => '+7(999)999-99-99',
                        ),
                        'analytics_data' => array(
                            'city' => 'Красногорск',
                            'delivery_date_begin' => "2021-03-20T18:58:32.197Z",
                            'delivery_date_end' => "2021-03-29T18:58:32.197Z",
                            'delivery_type' => 'Courier',
                            'is_premium' => true,
                            'payment_type_group_name' => 'Карты оплаты',
                            'region' => 'МОСКОВСКАЯ ОБЛАСТЬ',
                            'tpl_provider' => 'Яндекс.Такси',
                            'tpl_provider_id' => 99999,
                            'warehouse' => 'ХОРУГВИНО_КГТ',
                            'warehouse_id' => 19262731541000,
                        ),
                        'barcodes' => array(
                            'lower_barcode' => '',
                            'upper_barcode' => '',
                        ),
                        //TODO
                        'cancellation' => array(
                            'affect_cancellation_rating' => true,
                            'cancel_reason' => 'string',
                            'cancel_reason_id' => 0,
                            'cancellation_initiator' => 'string',
                            'cancellation_type' => 'string',
                            'cancelled_after_ship' => true,
                        ),
                        'customer' => array(
                            'address' => array(
                                'address_tail' => 'Московская 1. под. 3, кв 105',
                                'city' => 'КРАСНОДАР',
                                'comment' => 'Заказ в подарок',
                                'country' => 'РОССИЯ',
                                'district' => 'ЮФО',
                                'region' => 'КРАСНОДАРСКИЙ КРАЙ',
                                'zip_code' => '350000',
                            ),
                            'customer_email' => 'dmitriysuvorv@gmail.com',
                            'customer_id' => 123321231,
                            'name' => 'Дмитрий',
                            'phone' => '+7(999)999-99-99',
                        ),
                        'delivering_date' => '2020-12-09T19:12:35.295Z',
                        'delivery_method' => array(
                            'id' => 123123,
                            'name' => 'Курьером',
                            'tpl_provider' => 'Яндекс.Такси',
                            'tpl_provider_id' => 99999,
                            'warehouse' => 'ХОРУГВИНО_КГТ',
                            'warehouse_id' => 19262731541000,
                        ),
                        'financial_data' => array(
                            'products' => array(
                                0 => array(
                                    'actions' =>  array(
                                        "Системная виртуальная скидка селлера",
                                        "Маркетплейс промо № 6"
                                    ),
                                    'client_price' => 'string',
                                    'commission_amount' => 433.68,
                                    'commission_percent' => 8,
                                    'old_price' => 6951,
                                    'payout' => 4987.32,
                                    'picking' => null,
                                    'price' => 5421,
                                    'product_id' => 214865605,
                                    'quantity' => 1,
                                    'total_discount_percent' => 1530,
                                    'total_discount_value' => 22.01,
                                ),
                            ),
                        ),
                        'in_process_at' => "2021-03-29T18:58:32.197Z",
                        'order_id' => 257903296,
                        'order_number' => '19127784-0033',
                        'posting_number' => '19127784-0033-2',
                        'products' => array( 
                            0 => array(
                                'mandatory_mark' => array(),
                                'name' => 'Смеситель для кухни Maxonor MN4352-7',
                                'offer_id' => '149932',
                                'price' => '5421.00',
                                'quantity' => 1,
                                'sku' => 214865605,
                            ),
                        ),
                        'shipment_date' => '2021-03-29T18:58:32.197Z',
                        'status' => 'delivered',
                        'tpl_integration_type' => 'non_integrated',
                        'tracking_number' => '3444214124-РРА-213',
                    ),
                ),
            ),
        );
    }

}
