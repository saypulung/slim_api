<?php

namespace App\Http\Controllers\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\User;

class UserAction
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function me(Request $request, Response $response): Response
    {
        return createResponseJson($response, $request->getAttribute('authUser')->toArray());
    }
}