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
    
    public function updateProfile(Request $request, Response $response): Response
    {
        $payload = $request->getParsedBody();
        $authUser = $request->getAttribute('authUser');
        $authUser->first_name = $payload['first_name'];
        $authUser->last_name = $payload['last_name'];
        $authUser->metadata = $payload['metadata'];
        if ($authUser->save()) {
            return createResponseJson($response, ['message' => 'Update profile success']);
        } else {
            return createResponseJson($response, ['message' => 'Update profile failed'], 500);
        }
    }
}