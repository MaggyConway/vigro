<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Events;

use Sntinvest\Integration\Interfaces\{
    UserServiceInterface, 
    EventInterface
};
use Sntinvest\Integration\Container;

/**
 * Description of OnUserAdd
 *
 * @author dimay
 */
class OnUserEvent implements EventInterface
{
    private $fields = [
        'NAME', 
        'EMAIL', 
        'XML_ID', 
        'LOGIN', 
        'PERSONAL_PHONE', 
        'UF_SALE_SPOT_PARENT', 
        'UF_PHYSICAL_ADDRESS'
    ];
    
    private $service;
    
    public function __construct(UserServiceInterface $service) 
    {
        $this->service = $service;
    }
    
    public function handler($param)
    {
        if (!isset($this))
        {
            //new object and call seld method
            return Container::callMethod(
                Container::getClassData(
                    __NAMESPACE__,
                    __METHOD__,
                    $param,
                )
            );
        }
        
        $method = static::$serviceMethod ?? 'from';
        
        $data = $this->formatData($param);
        
        if (is_array($data) && count($data) > 0)
        {
            $this->service->$method([$data]);
        }
    }
    
    protected function formatData($param)
    {
        $data = [];

        foreach ($param as $key=>$value)
        {
            if (count($this->fields) > 0
                    && !in_array($key, $this->fields))
            {
                continue;
            }
            
            $data[$key] = $value;
        }
           
        return $data;
    }
}
