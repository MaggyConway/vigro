<?php

namespace Sntinvest\Market\Factory;

use Sntinvest\Market\Interfaces\iFactory;
use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Exchange\Ozon\OzonProductsExchange;
use Sntinvest\Market\Exchange\Ozon\OzonStatusExchange;
use Sntinvest\Market\Exchange\Ozon\OzonSkuExchange;

/**
 * Description of OzonMarketFactory
 *
 * @author dimay
 */
class OzonMarketFactory implements iFactory
{
    public function products($params): iExchange 
    {
        return new OzonProductsExchange($params);
    }
    
    public function status($params): iExchange 
    {
        return new OzonStatusExchange($params);
    }

    public function sku($params): iExchange
    {
        return new OzonSkuExchange($params);
    }
}
