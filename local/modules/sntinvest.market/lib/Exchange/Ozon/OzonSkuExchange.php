<?php

namespace Sntinvest\Market\Exchange\Ozon;

use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Interfaces\iApi;
use Sntinvest\Market\Api\OzonApi;
use Sntinvest\Market\Orm\OzonProductsTable;
use Bitrix\Main\Entity\DataManager;

/**
 * Description of OzonProductsExchange
 *
 * @author dimay
 */
class OzonSkuExchange implements iExchange
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
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        
        try {

            #Старт: Запись sku и stocks_present в таблицу
            $rsData = OzonProductsTable::getList(array(
                "select" => array("*"),
                "filter" => array()
            ));
            
            $arItemIds = [];
            
            while ($arItem = $rsData->Fetch()) {
                $arItemIds['offer_id'][] = $arItem['UF_OFFER_ID'];
                $arItems[$arItem['UF_PRODUCTS_ID']] = $arItem['ID'];
            }

            $arItemIds['offer_id'] = array_chunk($arItemIds['offer_id'], 1000);

            $output->writeln("get products sku");

            $productsInfo = $this->api->getProductsSku($arItemIds);

            $arData = [];
            foreach($productsInfo as $item) {
                $data = [
                    "UF_SKU" => ( is_array($item['sources']) && $item['sources'][0]['sku']  ? $item['sources'][0]['sku'] : 0),
                    //"UF_STOCKS_PRESENT" => ( is_array($item['stocks']) && $item['stocks']['present'] ? $item['stocks']['present'] : 0),
                ];
                $arData[$item['id']]= $data;
            }

            // starts and displays the progress bar
            $progressBar = new \Symfony\Component\Console\Helper\ProgressBar($output, count($arItems));
            $progressBar->start();
            
            foreach($arItems as $productId => $id) {
                if(isset($arData[$productId]) && !empty($arData[$productId])) {
                    $result = OzonProductsTable::update($id, $arData[$productId]);

                    if (!$result->isSuccess())
                        throw new \Exception($result->getErrorMessages());
                }
           
                $progressBar->advance();
            }
            
            $progressBar->finish();
            
            $output->writeln("finish");

        } 
        catch (\Exception $exception)
        {
            $output->writeln("Error message: " . $exception->getMessage());
        }


    }
}
