<?php

namespace Controllers;

use Utils\Request;
use Utils\Response;

class DefaultController
{

    public function index(Request $request)
    {
        return Response::defaultResponse()->setHeaders([
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization'
        ])->setStatusCode(200);
    }
}
