<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;


class HomeController {      

    public function index($request, $response, $args) {

        $view = Twig::fromRequest($request);
        return $view->render($response, 'pages/public/main.twig', ['message' => 'Hello World']);

    }

}