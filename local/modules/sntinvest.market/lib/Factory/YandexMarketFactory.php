<?php

namespace Sntinvest\Market\Factory;

use Sntinvest\Market\Interfaces\iFactory;
use Sntinvest\Market\Interfaces\iExchange;
use Sntinvest\Market\Exchange\Yandex\YandexProductsExchange;
use Sntinvest\Market\Exchange\Yandex\YandexSkuExchange;
use Sntinvest\Market\Exchange\Yandex\YandexStatusExchange;

/**
 * Description of YandexMarketFactory
 *
 * @author dimay
 */
class YandexMarketFactory implements iFactory
{
    public function products($params): iExchange 
    {
        return new YandexProductsExchange($params);
    }

    public function sku($params): iExchange
    {
        return new YandexSkuExchange($params);
    }

    public function status($params): iExchange
    {
        return new YandexStatusExchange($params);
    }

}
