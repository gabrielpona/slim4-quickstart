<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use DI\Container;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use App\Domain\Read\Repositories\IUserReadRepository;
use App\Domain\Read\Repositories\UserReadRepository;

require __DIR__ . '/../vendor/autoload.php';


//Loading Dotenv Parameters
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../')->safeLoad();

$isProduction = $_ENV['SLIM_ENVIRONMENT'] == 'production';


$settings =  [
    
    'slim' => [
            'displayErrorDetails' => !$isProduction,
            'logErrors' => true,
            'logErrorDetails' => true,
    ],
    'twig' => [
        'template_path' => __DIR__ . '/../resources/views/',
        'cache' => $isProduction ? __DIR__ . '/../cache/twig' : false
    ],
    'doctrine' => [
            'dev_mode' => !$isProduction,
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
                'charset' => 'utf8mb4'
            ]
        ]
];


function createEntityManager(array $settings): EntityManagerInterface
{
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
}

$container = new Container();
$container->set(EntityManagerInterface::class, function() use ($settings) { return createEntityManager($settings); });
$container->set(IUserReadRepository::class, \DI\autowire(UserReadRepository::class));
AppFactory::setContainer($container);

$app = AppFactory::create();


//TODO: Definir base path no ENV. 
//$app->setBasePath('/slim4-quickstart');

//Route Files
$routesPath = '../app/Routes';
(require "$routesPath/web.php")($app);


//Add Twig
$twig = Twig::create($settings['twig']['template_path'], $settings['twig']);
// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));





/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger  
 *
 */
$errorMiddleware = $app->addErrorMiddleware($_ENV['SLIM_ENVIRONMENT'] != "production", true, true);



return $app;
