<?php

namespace Sntinvest\Market\Factory;

use Sntinvest\Market\Interfaces\iFactory;
use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Exchange\Wb\WbProductsExchange;
use Sntinvest\Market\Exchange\Wb\WbStatusExchange;
use Sntinvest\Market\Exchange\Wb\WbSkuExchange;

/**
 * Description of OzonMarketFactory
 *
 * @author dimay
 */
class WbMarketFactory implements iFactory
{
    public function products($params): iExchange 
    {
        return new WbProductsExchange($params);
    }
    
    public function status($params): iExchange 
    {
        return new WbStatusExchange($params);
    }

    public function sku($params): iExchange
    {
        return new WbSkuExchange($params);
    }
}
