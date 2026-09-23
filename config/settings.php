<?php

$isProduction = ($_ENV['SLIM_ENVIRONMENT'] ?? 'development') === 'production';

return [
    'slim' => [
        'displayErrorDetails' => ! $isProduction,
        'logErrors' => true,
        'logErrorDetails' => true,
    ],
    'twig' => [
        'template_path' => __DIR__ . '/../resources/views/',
        'cache' => $isProduction ? __DIR__ . '/../cache/twig' : false,
    ],
    'doctrine' => [
        'dev_mode' => ! $isProduction,
        'cache_dir' => __DIR__ . '/../cache/doctrine',
        'proxy_dir' => __DIR__ . '/../cache/doctrine/proxies',
        'metadata_dirs' => [__DIR__ . '/../app/Domain'],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
            'dbname' => $_ENV['DB_NAME'] ?? 'slim_quickstart',
            'user' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASS'] ?? '',
            'charset' => 'utf8mb4',
        ],
    ],
];
