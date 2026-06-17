<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


class HomeController {      

    public function index($request, $response, $args) {

        $response->getBody()->write('Home');
        return $response;
    }

}