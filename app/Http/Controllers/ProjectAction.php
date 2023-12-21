<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class ProjectAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = [
            'message' => 'Success to access ',
            'args'  => $args
        ];
        return createResponseJson($response, $data);
    }
}