<?php
use Psr\Container\ContainerInterface;

use Sntinvest\Integration\Interfaces\{
    UserRepositoryInterface,
    Repository\ProductRepositoryInterface,
};

use Sntinvest\Integration\Repositories\MutualSettlements\{
    MutualSettlementsRepository, 
    ApplicationRepository, 
    OrderRepository,
    PaymentRepository,
    ShipmentRepository,
    GoodRepository,
};

use Sntinvest\Integration\Repositories\Product\{
    ProductRepository,
    ProductVigroRepository,
};

use Sntinvest\Integration\Repositories\User\CompanyRepository;

return [
    UserRepositoryInterface::class => DI\factory(function() {
        return new CompanyRepository();
    }),
    MutualSettlementsRepository::class => DI\factory(function() {
        return new MutualSettlementsRepository();
    }),
    ApplicationRepository::class => DI\factory(function() {
        return new ApplicationRepository();
    }),
    OrderRepository::class => DI\factory(function(ContainerInterface $c) {
        return new OrderRepository(
                $c->get(ProductRepository::class),
            );
    }),
    PaymentRepository::class => DI\factory(function(ContainerInterface $c) {
        return new PaymentRepository(
                $c->get(OrderRepository::class),
            );
    }),
    ShipmentRepository::class => DI\factory(function(ContainerInterface $c) {
        return new ShipmentRepository(
                $c->get(OrderRepository::class),
            );
    }),
    GoodRepository::class => DI\factory(function(ContainerInterface $c) {
        return new GoodRepository(
                $c->get(OrderRepository::class),
            );
    }),
    /**
     * Repository products
     */
    ProductRepositoryInterface::class => DI\factory(function(ContainerInterface $c) {
        return new ProductVigroRepository();
    }),
];