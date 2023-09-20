<?php

use Psr\Container\ContainerInterface;

use Sntinvest\Integration\Interfaces\Helpers\{
    ProductExchangeConfigInterface,
    SectionExchangeConfigInterface,
};

use Sntinvest\Integration\Helpers\Vigro\ProductExchangeConfig;
use Sntinvest\Integration\Helpers\Sntinvest\SectionExchangeConfig;

return [
    ProductExchangeConfigInterface::class => function (ContainerInterface $c) {
        return new ProductExchangeConfig();
    },
    SectionExchangeConfigInterface::class => function (ContainerInterface $c) {
        return new SectionExchangeConfig();
    },
];