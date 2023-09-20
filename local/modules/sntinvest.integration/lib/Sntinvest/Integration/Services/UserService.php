<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */
namespace Sntinvest\Integration\Services;

use Sntinvest\Integration\Interfaces\{
    UserServiceInterface, 
    ExchangeInterface,
    UserRepositoryInterface,
};

use Sntinvest\Integration\Helpers\UserExchangeConfig;
use Sntinvest\Integration\Services\Service;
use Sntinvest\Integration\Container;
use Bitrix\Main\Web\Json;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Sntinvest\Integration\Exceptions\InvalidEntryException;

/**
 * Description of UserService
 *
 * @author dimay
 */
class UserService extends Service implements UserServiceInterface
{
    private $exchange;
    private $repository;
    
    public function __construct(ExchangeInterface $exchange, UserRepositoryInterface $repository) 
    {
        $this->exchange = $exchange;
        
        $config = Container::getInstance()->get(UserExchangeConfig::class);
        
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
        
            $this->logger->info('send user: ' . $item['XML_ID'] . round(microtime(true) - $start, 4) . 's.');
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

        if (isset($data['XML_ID'])
                && !empty($data['XML_ID']))
        {
            $entry = $this->repository->findOrCreated($data['XML_ID']);

            $this->repository->set($entry, $data);

            $result = $entry->save();
            
            if (!is_null($output))
            {
                $output->writeln(sprintf('Save element ID: %s, result: %s', $entry->getId(), $result->isSuccess()));
            }
            
            $this->logger->info("receive user: " . $data['XML_ID'] . round(microtime(true) - $start, 4) . 's.');
            
            $msg->ack();
        }
        else
        {
            throw new InvalidEntryException('Empty entry XML_ID');
        }
    }
}
