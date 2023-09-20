<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Helpers;

/**
 * Description of ExchangeConfig
 *
 * @author dimay
 */
class ExchangeConfig
{
    private $data = [];
    
    public function set($name, $value)
    {
        $this->data[$name] = $value;
        
        return $this;
    }
    
    public function get($name)
    {
        if ($this->has($name))
        {
            return $this->data[$name];
        }
    }
    
    public function has($name) : bool
    {
        return isset($this->data[$name]);
    }
}
