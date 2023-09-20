<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Services;

use Sntinvest\Integration\Interfaces\{
    ServiceInterface, 
    ExchangeInterface,
};

use Sntinvest\Integration\Services\Service;
use Sntinvest\Integration\Container;
use Bitrix\Main\Web\Json;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Sntinvest\Integration\Helpers\MutualSettlementsExchangeConfig;

use Sntinvest\Integration\Repositories\MutualSettlements\{
   MutualSettlementsRepository,
};

use Sntinvest\Integration\Exceptions\InvalidEntryException;

/**
 * Description of MutualSettlements
 *
 * @author dimay
 */
class MutualSettlementsService extends Service implements ServiceInterface 
{
    private $exchange;
    
    private $repository;
    
    public function __construct(ExchangeInterface $exchange, MutualSettlementsRepository $repository) 
    {
        $this->exchange = $exchange;
        
        $config = Container::getInstance()->get(MutualSettlementsExchangeConfig::class);
        
        $this->exchange->config($config);
        
        $this->repository = $repository;
        
        parent::__construct();
    }
    
    public function from($data)
    {        
        $start = microtime(true);
        
        $converData = [];
        
        foreach ($data as $item)
        {
            $converData[] = Json::encode($item);

            $type = array_shift(array_keys($item));

            $this->logger->info("send $type: " . $item[$type]['XML_ID'] . round(microtime(true) - $start, 4) . 's.');
        }
        
        $this->exchange->send($converData);
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
        
        foreach ($this->saveElement($data) as $entry) 
        {
            if (!is_null($output))
            {
                $output->writeln(sprintf('Save %s element ID: %s', 'order', $entry->getId()));
            }
            
            $this->logger->info("receive order: " . $entry->getId() . round(microtime(true) - $start, 4) . 's.');
        }

//        $msg->ack();
    }
    
    public function saveElement($items)
    {
        foreach ($items as $data)
        {
            if (isset($data['XML_ID'])
                && !empty($data['XML_ID']))
            {
                $entry = $this->repository->findOrCreated($data['XML_ID']);

                $this->repository->set($entry, $data);

                $result = $entry->save();

                if (!$result->isSuccess())
                {
                    throw new InvalidEntryException('Entity not save: ' . implode(',', $result->getErrors()));
                }

                yield $entry;
            }
            else
            {
                throw new InvalidEntryException('Empty entry XML_ID');
            }
        }
    }
}
