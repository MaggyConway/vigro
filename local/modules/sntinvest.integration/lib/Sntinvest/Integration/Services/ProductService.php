<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */
namespace Sntinvest\Integration\Services;

use Sntinvest\Integration\Interfaces\{
    ExchangeInterface,
};

use Sntinvest\Integration\Interfaces\Helpers\ProductExchangeConfigInterface;
use Sntinvest\Integration\Services\Service;
use Sntinvest\Integration\Container;
use Bitrix\Main\Web\Json;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Sntinvest\Integration\Exceptions\InvalidEntryException;

use Sntinvest\Integration\Interfaces\Repositories\ProductRepositoryInterface;

/**
 * Description of UserService
 *
 * @author dimay
 */
class ProductService extends Service
{
    private $exchange;
    private $repository;
    
    public function __construct(ExchangeInterface $exchange, ProductRepositoryInterface $repository) 
    {
        $this->exchange = $exchange;
        
        $config = Container::getInstance()->get(ProductExchangeConfigInterface::class);
        
        $this->exchange->config($config);
        
        $this->repository = $repository;
        
        parent::__construct();
    }
    
    public function from($data)
    {      
        $start = microtime(true);

        foreach ($data as $item)
        {
            $props = [
                'routing_key' => 'property.brand.' . $item['PROPERTY_VALUES']['BRAND']['VALUE']['XML_ID'],
            ];
    
            $converData = [ 
                Json::encode($item) 
            ];
        
            $this->logger->info(sprintf('send product: %s, routing_key: %s, s: %ss.', $item['XML_ID'], $props['routing_key'], round(microtime(true) - $start, 4)));

            $this->exchange->send($converData, $props);
        }
    }
    
    public function to()
    {        
        $service = $this;
        
        $this->exchange->receive(function ($msg) use ($service) {
            $service->toActionCallback($msg);
        });
    }
    
    public function consoleTo(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(" [*] Waiting for logs. To exit press CTRL+C");
        
        $service = $this;

        $this->exchange->receive(function ($msg) use ($service, $input, $output) {
            $service->toActionCallback($msg, $input, $output);
        });
    }
    
    public function toActionCallback ($msg, InputInterface $input = null, OutputInterface $output = null) 
    {
        $start = microtime(true);
          
        $data = Json::decode($msg->body);

        if (isset($data['XML_ID'])
                && !empty($data['XML_ID']))
        {
            $entry = $this->repository->findOrCreated($data);

            $this->repository->set($entry, $data);

            //save orm d7 unavailable
            $result = $entry->saveByData();

            if (!is_null($output))
            {
                $output->writeln(sprintf('Save element ID: %s, result: %s', $entry->getId(), $result));
            }           
            
            $this->logger->info("receive product: " . $data['XML_ID'] . round(microtime(true) - $start, 4) . 's.');
            
            $msg->ack();
        }
        else
        {
            throw new InvalidEntryException('Empty entry XML_ID');
        }
    }
}
