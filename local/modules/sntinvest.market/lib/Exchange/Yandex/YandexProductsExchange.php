<?php

namespace Sntinvest\Market\Exchange\Yandex;

use Bitrix\Main\Config\Option;
use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Interfaces\iApi;
use Sntinvest\Market\Api\YandexApi;
use Sntinvest\Market\Orm\YandexProductsTable;
use Bitrix\Main\Entity\DataManager;

/**
 * Description of YandexProductsExchange
 *
 * @author dimay
 */
class YandexProductsExchange implements iExchange
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
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        
        try 
        {    
            $output->writeln("clear table " . YandexProductsTable::getTableName());
            
            $connection = \Bitrix\Main\Application::getConnection();
            $connection->truncateTable(YandexProductsTable::getTableName());
            
            $output->writeln("get active relationship ... ");
            
            $productsList = $this->api->getActiveRelationship($_ENV['SNTINVEST_MARKET_YANDEX_ID_COMPANY']);

            $output->writeln("cont: " . count($productsList['items']));
            
            $output->writeln("add items");

            // starts and displays the progress bar
            $progressBar = new \Symfony\Component\Console\Helper\ProgressBar($output, count($productsList['items']));
            $progressBar->start();
            
            foreach($productsList['items'] as $product) 
            {
                $data = [
                    "UF_NAME" => $product['offer']['name'],
                    "UF_SHOP_SKU" => $product['offer']['shopSku'],
                    "UF_CATEGORY_ID" => $product['mapping']['categoryId'],
                    "UF_MARKET_SKU" => $product['mapping']['marketSku'],
                ];
                
                $result = YandexProductsTable::add($data);
                
                if (!$result->isSuccess())
                    throw new \Exception($result->getErrorMessages());
                
                $progressBar->advance();
            }
            
            $progressBar->finish();
            
            $output->writeln("finish add items");
            
        } 
        catch (\Exception $exception)
        {
            $output->writeln("Error message: " . $exception->getMessage());
        }

    }
}
