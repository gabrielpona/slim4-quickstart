<?php

use App\Domain\Read\Repositories\IUserReadRepository;
use App\Domain\Read\Repositories\UserReadRepository;
use DI\Container;
use Doctrine\ORM\EntityManagerInterface;

use function DI\autowire;

return function (array $settings): Container {
    $container = new Container();
    $createEntityManager = require __DIR__ . '/doctrine.php';

    $container->set(EntityManagerInterface::class, fn () => $createEntityManager($settings));
    $container->set(IUserReadRepository::class, autowire(UserReadRepository::class));

    return $container;
};
