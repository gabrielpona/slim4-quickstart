<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';


//Loading Dotenv Parameters
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../')->safeLoad();

$isProduction = $_ENV['SLIM_ENVIRONMENT'] == 'production';


$settings =  [
    
    'twig' => [
        'template_path' => __DIR__ . '/../resources/views/',
        'cache' => $isProduction ? __DIR__ . './../cache/twig' : false
    ]    
];



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