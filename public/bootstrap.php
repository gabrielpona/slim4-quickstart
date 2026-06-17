<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();


//Loading Dotenv Parameters
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../')->safeLoad();


//TODO: Definir base path no ENV. 
//$app->setBasePath('/slim4-quickstart');

//Route Files
$routesPath = '../app/Routes';
(require "$routesPath/web.php")($app);


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