<?php

namespace Sntinvest\Market\Exchange\Ozon;

use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Interfaces\iApi;
use Sntinvest\Market\Api\OzonApi;
use Sntinvest\Market\Orm\OzonProductsTable;
use Bitrix\Main\Entity\DataManager;
use Sntinvest\CRest\Logger;

/**
 * Description of OzonProductsExchange
 *
 * @author dimay
 */
class OzonStatusExchange implements iExchange
{
    private $api;
    private $params;

    public function __construct($params)
    {
        $this->api = $this->getApi();
        $this->params = $params;
    }
    
    public function getApi(): iApi 
    {
        return new OzonApi();
    }

    
    public function exchange()
    {
        /**
         * TODO exchange
         * 
         * get data on OZON 
         * 
         * set data in Bitrix
         */
        try {

        #Получение товаров которые в продаже
        $productsStatus = $this->api->getProductsList(1, 1000, ['visibility' => 'IN_SALE']);

        $arData['offer_id'] = [];
        foreach($productsStatus['result']['items'] as $item) {
            $arData['offer_id'][] = $item['offer_id'];
        }

        #Массив с товарами, которые в продаже
        $arOfferId = $arData['offer_id'];

        $listData = OzonProductsTable::getList(array(
            "select" => array("ID", "UF_OFFER_ID"),
            "filter" => array()
        ));

        $setQuantity = array(
            'UF_STOCKS_PRESENT' => '1',
        );

        #Очистка поля UF_STOCKS_PRESENT на 0
        $connection = \Bitrix\Main\Application::getConnection();
        $queryString = "UPDATE ozon_products SET UF_STOCKS_PRESENT = 0";
        $connection->query($queryString);

        #Если товар в продаже - проставляем 1
        while ($arItem = $listData->Fetch()) {
            if (in_array($arItem['UF_OFFER_ID'], $arOfferId)) {
                $result = OzonProductsTable::update($arItem["ID"], $setQuantity);
                if (!$result->isSuccess())
                    throw new \Exception($result->getErrorMessages());
            }
        }

        } catch (\Exception $exception) {

            dd($exception);
        }

    }
}
