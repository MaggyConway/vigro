<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Interfaces;

use Sntinvest\Integration\Helpers\ExchangeConfig;

/**
 *
 * @author dimay
 */
interface ExchangeInterface
{
    public function config(ExchangeConfig $config);
    
    public function send($data);
    
    public function receive($callback);
}
