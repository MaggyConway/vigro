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
class OzonProductsExchange implements iExchange
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
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        
        try 
        {
            $output->writeln("clear table " . OzonProductsTable::getTableName());
            
            $connection = \Bitrix\Main\Application::getConnection();
            $connection->truncateTable(OzonProductsTable::getTableName());
            
            $output->writeln("get products list ... ");
            
            $productsList = $this->api->getProductsList(1, 1000);
            
            // starts and displays the progress bar
            $progressBar = new \Symfony\Component\Console\Helper\ProgressBar($output, count($productsList['result']['items']));
            $progressBar->start();
            
            #Старт: Запись offer_id и product_id в таблицу
            foreach($productsList['result']['items'] as $item) {
                $data = [
                    "UF_OFFER_ID" => $item['offer_id'],
                    "UF_PRODUCTS_ID" => $item['product_id'],
                ];
                $result = OzonProductsTable::add($data);

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
