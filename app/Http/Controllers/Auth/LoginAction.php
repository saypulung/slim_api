<?php

namespace App\Http\Controllers\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\User;

class LoginAction
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $credentials = $request->getParsedBody();
        if (isset($credentials['email']) && isset($credentials['password']))
        {
            $user = User::where('email', $credentials['email'])->with('role')->first();
            if ($user && password_verify($credentials['password'], $user->password)) {

                $key = $this->container->get('settings')['jwt_secret'];
                $payload = [
                    'iss' => $this->container->get('settings')['app_url'],
                    'aud' => $this->container->get('settings')['app_url'],
                    'iat' => time(),
                    'exp' => time() + 3600,
                    'data'  => [
                        'email' => ''
                    ]
                ];

                $payload['data']['email'] = $user->email;
                $responseJson = [
                    'message'   => 'Success login',
                    'user'      => $user,
                    'token'     => JWT::encode($payload, $key, 'HS256')
                ];
                return createResponseJson($response, $responseJson);
            }
        }
        
        return createResponseJson($response, ['message' => 'Login failed'], 403);
    }
}