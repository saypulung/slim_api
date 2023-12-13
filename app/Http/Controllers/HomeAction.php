<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class HomeAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $data = [
            'message' => 'Welcome to Slim API'
        ];
        return createResponseJson($response, $data);
    }
}