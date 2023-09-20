<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Helpers\Maxonor;

use Sntinvest\Integration\Helpers\ExchangeConfig;
use Sntinvest\Integration\Interfaces\Helpers\ProductExchangeConfigInterface;

/**
 * Description of ExchangeConfig
 *
 * @author dimay
 */
final class ProductExchangeConfig extends ExchangeConfig implements ProductExchangeConfigInterface
{
    public function __construct() 
    {
        $this->set('queue_name', 'mx_product_queue'); 
        $this->set('type', 'topic');
        $this->set('exchange', 'products');
        $this->set('routing_key', "property.brand.Maxonor_PURE_LIFE");
        $this->set('receive-count-max', 500);
        $this->set('receive-time-max', 60);
    }
}
