<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

return function (array $settings): EntityManagerInterface {
    $doctrineSettings = $settings['doctrine'];
    $cacheDirectory = $doctrineSettings['cache_dir'];
    $proxyDirectory = $doctrineSettings['proxy_dir'];

    foreach ([$cacheDirectory, $proxyDirectory] as $directory) {
        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }
    }

    $cache = new FilesystemAdapter('doctrine', 0, $cacheDirectory);

    $config = ORMSetup::createAttributeMetadataConfig(
        $doctrineSettings['metadata_dirs'],
        $doctrineSettings['dev_mode'],
        'slim4_quickstart',
        $cache
    );
    $config->setProxyDir($proxyDirectory);
    $config->setProxyNamespace('DoctrineProxies');
    $config->setAutoGenerateProxyClasses($doctrineSettings['dev_mode']);

    $connection = DriverManager::getConnection($doctrineSettings['connection'], $config);

    return new EntityManager($connection, $config);
};
