<?php
use Psr\Container\ContainerInterface;

use Sntinvest\Integration\Exchanges\{
    RebbitMqExchange,
};

use Sntinvest\Integration\Interfaces\ExchangeInterface;
use Sntinvest\Integration\Helpers\UserExchangeConfig;
use Sntinvest\Integration\Helpers\MutualSettlementsExchangeConfig;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Monolog\Logger;

return [
    ExchangeInterface::class => DI\factory(function(ContainerInterface $c) {
        return new RebbitMqExchange(
            $c->get(AMQPStreamConnection::class),
            $c->get(Logger::class)
        );
    }),
    UserExchangeConfig::class => DI\factory(function() {
        return new UserExchangeConfig;
    }),
    MutualSettlementsExchangeConfig::class => DI\factory(function() {
        return new MutualSettlementsExchangeConfig;
    }),
];