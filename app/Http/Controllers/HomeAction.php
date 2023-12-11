<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Post;

final class HomeAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $data = [
            'test',
            'test2',
        ];
        return createResponseJson($response, $data);
    }
}