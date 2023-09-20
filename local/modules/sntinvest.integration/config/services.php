<?php

use Psr\Container\ContainerInterface;

use Sntinvest\Integration\Interfaces\{
    UserServiceInterface,
    UserRepositoryInterface,
    ExchangeInterface,
    Repository\ProductRepositoryInterface,
};
use Sntinvest\Integration\Repositories\MutualSettlements\MutualSettlementsRepository;

use Sntinvest\Integration\Services\{
    UserService,
    MutualSettlementsService,
    ProductService,
    SectionService,
};

return [
    UserServiceInterface::class => function (ContainerInterface $c) {
        return new UserService(
                $c->get(ExchangeInterface::class),
                $c->get(UserRepositoryInterface::class)
            );
    },
    MutualSettlementsService::class => function (ContainerInterface $c) {
        return new MutualSettlementsService(
                $c->get(ExchangeInterface::class),
                $c->get(MutualSettlementsRepository::class)
            );
    },
    ProductService::class => function (ContainerInterface $c) {
        return new ProductService(
                $c->get(ExchangeInterface::class), 
                $c->get(ProductRepositoryInterface::class)
            );
    },
    SectionService::class => function (ContainerInterface $c) {
        return new SectionService(
                $c->get(ExchangeInterface::class), 
            );
    },
];