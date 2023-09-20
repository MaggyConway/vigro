<?php

/*
 * This file is part of local.sntinvest.local project
 * Copyright 2022 dimay.
 */

namespace Sntinvest\Integration\Exchanges;

use Sntinvest\Integration\Interfaces\ExchangeInterface;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

use Sntinvest\Integration\Helpers\ExchangeConfig;

use Monolog\Logger;
     
/**
 * Description of RebbitMqExchange
 *
 * @author dimay
 */
class RebbitMqExchange implements ExchangeInterface
{    
    /**
     * Rebbit exchange default
     */
    public const exchange = 'logs'; 
    
    /**
     * Rebbit type default
     */
    public const type = ''; 

    /**
     * @var PhpAmqpLib\Connection\AMQPStreamConnection
     */
    private $connection;
    
    /**
     * @var PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;
    
    /**
     * @var Sntinvest\Integration\Helpers\ExchangeConfig
     */
    private $config;
    
    /**
     * @var Monolog\Logger
     */
    private $logger;
    
    public function __construct(AMQPStreamConnection $connection, Logger $logger) 
    { 
        $this->connection = $connection;
        $this->channel = $this->connection->channel();
        
        $this->logger = $logger;
    }
    
    public function __destruct() 
    {
        $this->channel->close();
        
        $this->connection->close();
    }
    
    public function config(ExchangeConfig $config)
    {
        $this->config = $config;
        
        $exchange = $config->has('exchange') ? $config->get('exchange') : static::exchange;
        $type = $config->has('type') ? $config->get('type') : static::type;
        $passive = $config->has('passive') ? $config->get('passive') : false;
        $durable = $config->has('durable') ? $config->get('durable') : true;
        $auto_delete = $config->has('auto_delete') ? $config->get('auto_delete') : false;
        $internal = $config->has('internal') ? $config->get('auto_delete') : false;
        $nowait = $config->has('nowait') ? $config->get('nowait') : false;
        $arguments = $config->has('arguments') ? $config->get('arguments') : new AMQPTable(array('x-delayed-type' => AMQPExchangeType::FANOUT));
        $ticket = $config->has('ticket') ? $config->get('ticket') : null;
           
        /**
         * Declares exchange
         *
         * @param string $exchange
         * @param string $type
         * @param bool $passive
         * @param bool $durable
         * @param bool $auto_delete
         * @param bool $internal
         * @param bool $nowait
         * @return mixed|null
         */
        $this->channel->exchange_declare(
            $exchange,
            $type, 
            $passive, 
            $durable, 
            $auto_delete, 
            $internal, 
            $nowait, 
            $arguments,
            $ticket
        );

    }
    
    public function send($data, array $params = [])
    {
        $exchange = $this->config->has('exchange') ? $this->config->get('exchange') : static::exchange;
        
        foreach ($this->addMessage($data, $params) as $massage)
        {
//            $this->logger->info($exchange);
        }
    }
    
    public function receive($callback)
    {
        $queue_name = $this->config->has('queue_name') ? $this->config->get('queue_name') : null;
        
        if (is_null($queue_name)) 
        {
            list($queue_name, ,) = $this->channel->queue_declare('', false, false, false, false, false, new AMQPTable(array(
                'x-dead-letter-exchange' => 'delayed'
            )));
        } 
        else 
        {
            $this->channel->queue_declare($queue_name, false, false, false, false, false, new AMQPTable(array(
                'x-dead-letter-exchange' => 'delayed'
            )));
        }
        
        $exchange = $this->config->has('exchange') ? $this->config->get('exchange') : static::exchange;
        
        $routing_key = $this->config->has('routing_key') ? $this->config->get('routing_key') : null;

        $this->channel->queue_bind($queue_name, $exchange, $routing_key);
        
        $index = 0;

        $start = microtime(true);
        
        while ($message = $this->channel->basic_get($queue_name))
        {
            try 
            {
                if (is_callable($callback))
                {
                    $callback($message);
                }
            } 
            catch (Exception $exc) 
            {
                $this->logger->error("$exchange:".$exc->getMessage());
            }
            
            if ($this->config->has('receive-count-max')
                    && $index >= $this->config->get('receive-count-max'))
            {
                break;
            }
            
            $time = intval(microtime(true) - $start);
            
            if ($this->config->has('receive-time-max')
                    && $time >= $this->config->get('receive-time-max'))
            {
                break;
            }
            
            $index++;
        }
    }
    
    protected function addMessage ($massages, array $params = []) 
    {
        $exchange = $this->config->has('exchange') ? $this->config->get('exchange') : $params['exchange'] ?? static::exchange;

        $routing_key = $this->config->has('routing_key') ? $this->config->get('routing_key') : $params['routing_key'] ?? null;

        foreach ($massages as $massage)
        {
            $headers = new AMQPTable();
            $msg = new AMQPMessage($massage);
            $msg->set('application_headers', $headers);
            $this->channel->basic_publish($msg, $exchange, $routing_key);
            
            yield $massage;
        }
    }
}
