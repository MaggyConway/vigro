<?php
namespace Sntinvest\Market;

use Sntinvest\Market\Interfaces\iFactory;
use Sntinvest\Market\Interfaces\iExchange;

class Market 
{
    private $params;
    private $factory;
    
    public function __construct(iFactory $factory) 
    {
        $this->params = [];
        $this->factory = $factory;
    }
    
    private function getExchange(iExchange $exchange) 
    {
        //Запукает выгрузку 
        
        /**
         * TODO Logger
         */
        $exchange->exchange();
    } 
    
    public function products()
    {
        return $this->getExchange($this->factory->products($this->params));
    }
    
    public function status()
    {
        return $this->getExchange($this->factory->status($this->params));
    }

    public function sku()
    {
        return $this->getExchange($this->factory->sku($this->params));
    }
}
