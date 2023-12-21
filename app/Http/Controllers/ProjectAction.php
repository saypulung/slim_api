<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class ProjectAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $data = [
            'message' => 'Success to access '
        ];
        return createResponseJson($response, $data);
    }
}