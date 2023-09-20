<?php

namespace Sntinvest\Market\Api;

use Bitrix\Main\Config\Option;
use Sntinvest\Market\Interfaces\iApi;
use Yandex\Marketplace\Partner\Clients\Client;
use Yandex\Marketplace\Partner\Clients\PriceClient;
use Yandex\Marketplace\Partner\Clients\RelationshipClient;
use Yandex\Marketplace\Partner\Clients\StatsClient;
use Yandex\Marketplace\Partner\Clients\OrderProcessingClient;
use Sntinvest\Market\Logger;

class YandexApi implements iApi {

    private $yandexItems = [];

    protected function getClient($name) {
        $client = null;
        
        switch ($name) {

            case 'price':
                $client = new PriceClient($_ENV['SNTINVEST_MARKET_YANDEX_CLIENT_ID'], $_ENV['SNTINVEST_MARKET_YANDEX_TOKEN']);
                break;

            case 'relationship':
                $client = new RelationshipClient($_ENV['SNTINVEST_MARKET_YANDEX_CLIENT_ID'], $_ENV['SNTINVEST_MARKET_YANDEX_TOKEN']);
                break;

            case 'stats':
                $client = new StatsClient($_ENV['SNTINVEST_MARKET_YANDEX_CLIENT_ID'], $_ENV['SNTINVEST_MARKET_YANDEX_TOKEN']);
                break;

            case 'order':
                $client = new OrderProcessingClient($_ENV['SNTINVEST_MARKET_YANDEX_CLIENT_ID'], $_ENV['SNTINVEST_MARKET_YANDEX_TOKEN']);
                break;

        }

        return $client;
    }


    public function getStatsByOrders($campaignId, array $params = [], array $query = [], $dbgKey = null) {
        $arResult = array();

        try {
//            $client = $this->getClient('order');
//
//            $response = $client->getOrders($campaignId, $params, $query, $dbgKey);
//
//            $result = $response->getResult();
//
//            $arList = $result->getOrders()->getRawList();
//
//            foreach ($arList as $arItem)
//            {
//                $arResult[$arItem['marketSku']] = $arItem;
//            }

            $result = array(
                'status' => 'OK',
                'result' => array(
                    'orders' => array(
                        0 => array(
                            'id' => 1,
                            'creationDate' => '2021-04-05',
                            'statusUpdateDate' => '2021-04-05Т10:30:00',
                            'status' => 'DELIVERED',
                            'paymentType' => 'POSTPAID',
                            'deliveryRegion' => array(
                                'id' => 213,
                                'name' => 'Москва',
                            ),
                            'items' => array(
                                0 =>
                                array(
                                    'offerName' => 'E10301 Смеситель однорычажный для раковины белый',
                                    'marketSku' => 100500900,
                                    'shopSku' => '136541',
                                    'count' => 2,
                                    'prices' => array(
                                        0 => array(
                                            'type' => 'BUYER',
                                            'costPerItem' => 150.2,
                                            'total' => 300.4,
                                        ),
                                    ),
                                    'warehouse' => array(
                                        'id' => 171,
                                        'name' => 'Яндекс.Маркет (Томилино)',
                                    ),
                                    'details' => array(
                                        0 => array(
                                            'itemStatus' => 'REJECTED',
                                            'itemCount' => 2,
                                            'updateDate' => '2020-02-09',
                                        ),
                                    ),
                                ),
                            ),
                            'initialItems' => array(
                                0 => array(
                                    'offerName' => 'E10301 Смеситель однорычажный для раковины белый',
                                    'marketSku' => 100500900,
                                    'shopSku' => '136541',
                                    'count' => 3,
                                ),
                            ),
                            'payments' => array(
                                0 => array(
                                    'id' => '46234',
                                    'date' => '2021-04-05',
                                    'type' => 'PAYMENT',
                                    'source' => 'BUYER',
                                    'total' => 300.4,
                                    'paymentOrder' => array(
                                        'id' => 99273,
                                        'date' => '2021-04-05',
                                    ),
                                ),
                            ),
                            'commissions' => array(
                                0 => array(
                                    'type' => 'AGENCY',
                                    'actual' => 100.5,
                                    'predicted' => 100.5,
                                ),
                            ),
                        ),
                    ),
                    'paging' => array(
                        'nextPageToken' => 'XkiOjUzO',
                    ),
                ),
            );

            return $result['result']['orders'];

        } catch (Exception $ex) {
            Logger::getInstance()->writeLog($ex->getMessage());
        }

        return $arResult;
    }

    public function getOrders($campaignId, array $params = [], $dbgKey = null) {
        $arResult = array();

        try {
//            $client = $this->getClient('order');
//            $response = $client->getOrders($campaignId, $params);
//            $result = $response->getResult();
//            $arList = $result->getOrders()->getRawList();
//
//            foreach ($arList as $arItem)
//            {
//                $arResult[$arItem['marketSku']] = $arItem;
//            }


            $arResult = array(
                [
                    'creationDate' => '15-03-2021 12:32:22',
                    'cancelRequested' => false,
                    'currency' => 'RUR',
                    'fake' => false,
                    'id' => 999999,
                    'itemsTotal' => 3211.12,
                    'paymentType' => 'PREPAID',
                    'status' => 'OK',
                    'substatus' => 'SHIPPED',
                    'taxSystem' => 'OSN',
                    'total' => 3211.12,
                    'subsidyTotal' => 111.12,
                    'delivery' => array(
                        'deliveryPartnerType' => 'YANDEX_MARKET',
                        'id' => 999999,
                        'serviceName' => 'Яндекс.Маркет',
                        'type' => 'DELIVERY',
                        'region' => array(
                            'id' => 999999,
                            'name' => 'РОССИЯ',
                            'type' => 'COUNTRY',
                            'parent' => array(
                                'id' => 999999,
                                'name' => 'КРАСНОДРСКИЙ КРАЙ',
                                'type' => 'REGION',
                                'parent' => array(
                                    'id' => 999999,
                                    'name' => 'КРАСНОДАР',
                                    'type' => 'CITY',
                                ),
                            ),
                        ),
                    ),
                    'shipments' => array(
                        array(
                            'id' => 999999,
                            'shipmentDate' => '15-03-2021 12:32:22',
                            'boxes' => array(
                                array(
                                    'id' => 999999,
                                    'depth' => 321,
                                    'height' => 321,
                                    'weight' => 321,
                                    'width' => 321,
                                    'items' => array(
                                        array(
                                            'id' => 999999,
                                            'count' => 1,
                                        ),
                                    ),
                                )
                            ),
                        ),
                    ),
                    'items' => array(
                        array(
                            'id' => 999999,
                            'offerId' => '136541',
                            'count' => 1,
                            'price' => 1223.23,
                            'vat' => 'NO_VAT',
                            'feedId' => 999999,
                            'subsidy' => 122,
                            'instances' => array(),
                            'promos' => array(),
                            'details' => array(),
                        ),
                    ),
                    'notes' => 'Заказ в подарок',
                ]
            );
        } catch (Exception $ex) {
            Logger::getInstance()->writeLog($ex->getMessage());
        }

        return $arResult;
    }

    public function getStatsBySkus($campaignId, $params = array()) {
        $arResult = array();

        try {

            $client = $this->getClient('stats');

            $response = $client->getStatsBySkus($campaignId, $params);

            $result = $response->getResult();

            $arList = $result->getAll();

            foreach ($arList as $arItem) {
                if (!empty( $arItem->getWarehouses() )){
                    $arResult[$arItem->getShopSku()] = $arItem->getWarehouses()->getRawList();
                }
            }

        } catch (Exception $ex) {
             Logger::getInstance()->writeLog($ex->getMessage());
        }

        return $arResult;
    }

    public function getOffersPrices($campaignId, $params = array()) {
        $arResult = array();

        try {
            $client = $this->getClient('price');

            $response = $client->getOffersPrices($campaignId, $params);

            $result = $response->getResult();

            $arList = $result->getOfferMappingEntries()->getRawList();

            foreach ($arList as $arItem) {
                $arResult[$arItem['marketSku']] = $arItem;
            }
        } catch (Exception $ex) {
            Logger::getInstance()->writeLog($ex->getMessage());
        }

        return $arResult;
    }

    public function getRecommendedPrices($campaignId, $params = array()) {
        $arResult = array();

        $client = $this->getClient('price');

        $response = $client->getRecommendedPrices($campaignId, $params);

        $result = $response->getResult();

        $arList = $result->getOffers()->getRawList();

        foreach ($arList as $arItem) {
            $arResult[$arItem['marketSku']] = $arItem;
        }

        return $arResult;
    }

    public function getActiveRelationship($campaignId, $params = array()) {

        try {

            $client = $this->getClient('relationship');

            $response = $client->getActiveRelationship($campaignId, $params);

            $result = $response->getResult();

            $arList = $result->getOfferMappingEntries()->getRawList();

            $arResult['nextPage'] = $result->getNextPageToken();

            foreach ($arList as $arItem) {
                $this->yandexItems['items'][$arItem['offer']['shopSku']] = $arItem;
            }

            if($arResult['nextPage']){
                $this->getActiveRelationship($campaignId, ['page_token' => $arResult['nextPage']]);
            }

        } catch (Exception $ex) {
            Logger::getInstance()->writeLog($ex->getMessage());
        }

        return $this->yandexItems;
    }

    public function getRecommendedRelationship($campaignId, $params = array()) {

        try {

            $client = $this->getClient('relationship');

            $response = $client->getRecommendedRelationship($campaignId, $params);

            $result = $response->getResult()->getOffers()->getRawList();

            return $result;

        } catch (Exception $ex) {
            Logger::getInstance()->writeLog($ex->getMessage());
        }

        return $result;
    }

}
