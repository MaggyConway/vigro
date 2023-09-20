<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */
namespace Sntinvest\Integration\Services;

use Sntinvest\Integration\Interfaces\{
    ExchangeInterface,
};

use Sntinvest\Integration\Interfaces\Helpers\SectionExchangeConfigInterface;
use Sntinvest\Integration\Services\Service;
use Sntinvest\Integration\Container;
use Bitrix\Main\Web\Json;

use Bitrix\Main\Context;
/**
 * Description of UserService
 *
 * @author dimay
 */
class SectionService extends Service
{
    private $exchange;
    
    public function __construct(ExchangeInterface $exchange) 
    {
        $this->exchange = $exchange;
        
        $config = Container::getInstance()->get(SectionExchangeConfigInterface::class);
        
        $this->exchange->config($config);
                
        $this->server = Context::getCurrent()->getServer();

        parent::__construct();
    }
    
    public function from($data)
    {      
        $start = microtime(true);
        
        foreach ($data as $item)
        {
            $props = [
                'routing_key' => 'site.' . (!empty($this->server->getServerName())
                                                ? $this->server->getServerName()
                                                : $this->server->getHttpHost()),
            ];
    
            $converData = [ 
                Json::encode($item) 
            ];
        
            $this->logger->info(sprintf('send section: %s, routing_key: %s, s: %ss.', $item['XML_ID'], $props['routing_key'], round(microtime(true) - $start, 4)));

            $this->exchange->send($converData, $props);
        }
    }
}
