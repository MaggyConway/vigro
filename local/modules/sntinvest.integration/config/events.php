<?php

use Psr\Container\ContainerInterface;

use Sntinvest\Integration\Events\{
    OnUserEvent,
    OnProductEvent,
    OnSectionEvent,
};

use Sntinvest\Integration\Services\{
    ProductService,
    SectionService,
};

use Sntinvest\Integration\Interfaces\{
    UserServiceInterface
};

return [
    'OnUserEvent' => function (ContainerInterface $c) {
        return new OnUserEvent($c->get(UserServiceInterface::class));
    },
    'OnProductEvent' => function (ContainerInterface $c) {
        return new OnProductEvent($c->get(ProductService::class));
    },
    'OnSectionEvent' => function (ContainerInterface $c) {
        return new OnSectionEvent($c->get(SectionService::class));
    },
];