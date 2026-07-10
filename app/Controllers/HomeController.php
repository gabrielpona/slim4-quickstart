<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use \App\Services\Auth\AuthService;


class HomeController {
    
    private AuthService $authService;


    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function index($request, $response, $args) {

        $auth = $this->authService->attempt();    

        $view = Twig::fromRequest($request);
        return $view->render($response, 'pages/public/main.twig', ['message' => 'Hello World', 'auth' => $auth]);

    }

}