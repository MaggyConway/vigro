<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Helpers\Sntinvest;

use Sntinvest\Integration\Helpers\ExchangeConfig;
use Sntinvest\Integration\Interfaces\Helpers\ProductExchangeConfigInterface;

/**
 * Description of ExchangeConfig
 *
 * @author dimay
 */
final class SectionExchangeConfig extends ExchangeConfig implements ProductExchangeConfigInterface
{
    public function __construct() 
    {
        $this->set('type', 'topic');
        $this->set('exchange', 'section');
    }
}
