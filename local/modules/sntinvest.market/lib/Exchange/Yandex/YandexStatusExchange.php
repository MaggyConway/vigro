<?php

namespace Sntinvest\Market\Exchange\Yandex;

use Bitrix\Main\Config\Option;
use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Interfaces\iApi;
use Sntinvest\Market\Api\YandexApi;
use Sntinvest\Market\Orm\OzonProductsTable;
use Sntinvest\Market\Orm\YandexProductsTable;
use Bitrix\Main\Entity\DataManager;

/**
 * Description of YandexProductsExchange
 *
 * @author dimay
 */
class YandexStatusExchange implements iExchange
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
        /**
         * TODO exchange
         * 
         * get data on YANDEX
         * 
         * set data in Bitrix
         */

//        $logger = Logger::getInstance()
//            ->setFile(' YandexStatusExchange_' . date("Y_m_d"))
//            ->removeFile('YandexStatusExchange')
//            ->setDebug(Logger::DEBUG_FILE);

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        
        try 
        {

            #Очистка поля UF_COUNT на 0
            $connection = \Bitrix\Main\Application::getConnection();
            $queryString = "UPDATE yandex_products SET UF_COUNT = 0";
            $connection->query($queryString);

            #Подключаем таблицу с товарами из Яндекса
            $tableData = YandexProductsTable::getList(array(
                "select" => array("ID", "UF_SHOP_SKU"),
                "filter" => array()
            ));

            $shopSku = [];
            #Создаем массив $shopSku, который будет состоять из артикулов товара,
            #чтоб потом сделать запрос по этим артикулам (limit 500)
            while ($arItem = $tableData->Fetch()) {
                $shopSku[$arItem["ID"]] = (string)$arItem["UF_SHOP_SKU"];
                $arData[$arItem["UF_SHOP_SKU"]] = $arItem;
            }

            #Нужно разбить массив по 500 штук
            $shopSku = array_chunk($shopSku, 500);
            foreach ($shopSku as $key => $items) {
                $arShopSku[$key]["shopSkus"] = $items;
            }

            #Прописываем значение 1 тем товарам, которые есть в наличии
            $setQuantity = array(
                'UF_COUNT' => '1',
            );

            // starts and displays the progress bar
            $progressBar = new \Symfony\Component\Console\Helper\ProgressBar($output, count($arShopSku));
            $progressBar->start();
            
            #Формируем массив в соответствии с требованиями API
            foreach ($arShopSku as $items) {

                #Выполняем запрос, получаем информацию по товарам (остаткам)
                $stocksList = $this->api->getStatsBySkus($_ENV['SNTINVEST_MARKET_YANDEX_ID_COMPANY'], $items);

                $result_array = array_intersect_assoc($arData, $stocksList);

                if (is_array($result_array) and !empty($result_array)) {
                    foreach ($result_array as $resultKey => $arResultValue) {
                        $result = YandexProductsTable::update($arResultValue["ID"], $setQuantity);
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
