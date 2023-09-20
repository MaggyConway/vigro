<?php

namespace Sntinvest\Market\Exchange\Wb;

use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Interfaces\iApi;
use Sntinvest\Market\Api\WbApi;
use Sntinvest\Market\Orm\WbProductsTable;
use Bitrix\Main\Type\DateTime;

/**
 * Description of OzonProductsExchange
 *
 * @author dimay
 */
class WbProductsExchange implements iExchange
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
        return new WbApi();
    }
    
    protected function getItems() 
    {
        $result = $this->api->cardList();
        
        $arCards = $result['result']['cards'];
        
        $arItems = [];
        
        if (is_array($arCards) && count($arCards) > 0)
        {
            foreach ($arCards as $item)
            {
                if (is_array($item['nomenclatures']) && count($item['nomenclatures']) > 0)
                {
                    foreach ($item['nomenclatures'] as $product)
                    {
                        $arItems[$product['vendorCode']] = [
                            "UF_VENDOR_ID" => $product['vendorCode'],
                            "UF_NMID" => $product['nmId'],
                            "UF_UPDATE" => new DateTime(),
                        ];
                    }
                }
            }
        }
        else
        {
            //$this->logger->writeLog('get items: ' . ' ' . var_export($result, 1));
        }
        
        return $arItems;
    }
    
    protected function getItemsDb(array $arVendorID = []) 
    {
        $arItems = [];
        
        $rsItemsDb = WbProductsTable::getList([
            'filter' => [
                "=UF_VENDOR_ID" => $arVendorID
            ]
        ]);
        
        while ($item = $rsItemsDb->fetch())
        {
            $arItems[$item['UF_VENDOR_ID']] = $item['ID'];
        }
        
        return $arItems;
    }

    public function exchange()
    {
        $arItems = $this->getItems();
        
        if (is_array($arItems) && count($arItems) > 0)
        {
            $arItemsDb = $this->getItemsDb(array_keys($arItems));
                 
            foreach ($arItems as $vandorId=>$item)
            {
                if (isset($arItemsDb[$vandorId]) && intval($arItemsDb[$vandorId]) > 0)
                {
                    $idDb = $arItemsDb[$vandorId];

                    $res = WbProductsTable::update($idDb, $item);

                    if (!$res->isSuccess())
                    {
                        //$this->logger->writeLog('update: ' . ' ' . $res->getErrorMessages());
                    }
                }
                else
                {
                    $item['UF_CREATED'] = new DateTime();

                    $res = WbProductsTable::add($item);

                    if (!$res->isSuccess())
                    {
                        //$this->logger->writeLog('add: ' . ' ' . $res->getErrorMessages());
                    }
                }
            }
        }
     
    }
}
