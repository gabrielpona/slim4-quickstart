<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';


//Loading Dotenv Parameters
Dotenv\Dotenv::createImmutable(__DIR__. '/../')->safeLoad();

$settings = require __DIR__ . '/../config/settings.php';
$createContainer = require __DIR__ . '/../config/container.php';
$container = $createContainer($settings);

AppFactory::setContainer($container);

$app = AppFactory::create();


//TODO: Definir base path no ENV. 
//$app->setBasePath('/slim4-quickstart');

//Route Files
$routesPath = __DIR__ . '/../app/Routes';
(require $routesPath . '/web.php')($app);


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
$errorMiddleware = $app->addErrorMiddleware(
    $settings['slim']['displayErrorDetails'],
    $settings['slim']['logErrors'],
    $settings['slim']['logErrorDetails']
);



return $app;
