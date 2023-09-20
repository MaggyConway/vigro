<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Helpers\Crm;

use Sntinvest\Integration\Helpers\ExchangeConfig;

/**
 * Description of ExchangeConfig
 *
 * @author dimay
 */
final class MutualSettlementsExchangeConfig extends ExchangeConfig
{
    public function __construct() 
    {
        $this->set('queue_name', 'crm_mutualsettlements_queue'); 
        $this->set('exchange', 'mutualsettlements');
        $this->set('type', 'fanout');
        $this->set('receive-count-max', 500);
        $this->set('receive-time-max', 60);
    }
}
