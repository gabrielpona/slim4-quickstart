<?php

use Slim\App;

use App\Controllers\HomeController;


return function (App $app) {


    $app->get('/',[HomeController::class, 'index'])->setName('index');

    $app->get('/sobre', function ($request, $response) {

        $response->getBody()->write('Sobre');

        return $response;
    });
};
