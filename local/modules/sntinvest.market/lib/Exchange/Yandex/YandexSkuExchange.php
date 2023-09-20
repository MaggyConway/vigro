<?php

namespace Sntinvest\Market\Exchange\Yandex;

use Bitrix\Main\Config\Option;
use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Interfaces\iApi;
use Sntinvest\Market\Api\YandexApi;
use Sntinvest\Market\Orm\YandexProductsTable;
use Bitrix\Main\Entity\DataManager;

/**
 * Description of OzonProductsExchange
 *
 * @author dimay
 */
class yandexSkuExchange implements iExchange
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
        return new YandexApi();
    }

    
    public function exchange()
    {

//        $logger = Logger::getInstance()
//            ->setFile('YandexSkuExchange_' . date("Y_m_d"))
//            ->removeFile('YandexSkuExchange')
//            ->setDebug(Logger::DEBUG_FILE);

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        
        try
        {
            $output->writeln("get list");
            
            $tableData = YandexProductsTable::getList(array(
                "select" => array("ID", "UF_NAME", "UF_SHOP_SKU", "UF_CATEGORY_ID"),
                "filter" => array()
            ));

            $arData = [];
            
            while ($arItem = $tableData->Fetch()) 
            {
                $arData["offers"][$arItem["UF_SHOP_SKU"]] = [
                      "name" => $arItem["UF_NAME"],
                      "shopSku" => $arItem["UF_SHOP_SKU"],
                      "category" => $arItem["UF_CATEGORY_ID"],
                ];
                $arTableProductsDict[$arItem["UF_SHOP_SKU"]] = $arItem["ID"];
            }

            $arData = array_chunk($arData["offers"], 500);

            foreach ($arData as $key => $items) {
                $arProducts[$key]["offers"] = $items;
            }

            // starts and displays the progress bar
            $progressBar = new \Symfony\Component\Console\Helper\ProgressBar($output, count($arProducts));
            $progressBar->start();
            
            foreach ($arProducts as $items)
            {
                #Выполняем запрос, получаем информацию по товарам (model-id)
                $productsList = $this->api->getRecommendedRelationship($_ENV['SNTINVEST_MARKET_YANDEX_ID_COMPANY'], $items);

                foreach ( $productsList as $arYandexValues )
                {
                    if ( $arTableProductsDict[$arYandexValues["shopSku"]] )
                    {
                        $result = YandexProductsTable::update($arTableProductsDict[$arYandexValues["shopSku"]], ["UF_MODEL_ID" => $arYandexValues["marketModelId"]]);
                        if (!$result->isSuccess())
                            throw new \Exception($result->getErrorMessages());

                    }
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
