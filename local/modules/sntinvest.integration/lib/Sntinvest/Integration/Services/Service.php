<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Services;

use Sntinvest\Integration\Interfaces\ServiceInterface;
use Sntinvest\Integration\Container;
use Sntinvest\Integration\Exceptions\InvalidMethodException;

use Monolog\Logger;
/**
 *
 * @author dimay
 */
abstract class Service implements ServiceInterface
{
    protected $logger;
    
    public function __construct() 
    {
        $this->logger = Container::getInstance()->get(Logger::class);
    }
    
    public function to()
    {
        throw new InvalidMethodException('The selected method is not working');
    }
    
    public function from($param)
    {
        throw new InvalidMethodException('The selected method is not working');
    }
}
