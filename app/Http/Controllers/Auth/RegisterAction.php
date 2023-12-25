<?php

namespace App\Http\Controllers\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\User;

class RegisterAction
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $payload = $request->getParsedBody();
        $email = $payload['email'];
        $checkUser = User::where('email', $email)->exists();
        if ($checkUser) {
            return createResponseJson($response, ['message' => 'Email already taken'], 422);
        }
        try {
            $user = User::create([
                'first_name'    => $payload['first_name'],
                'last_name'     => $payload['last_name'] ?? '',
                'email'         => $email,
                'password'      => password_hash($payload['password'], PASSWORD_BCRYPT, ['cost' => 10]),
                'metadata'      => $payload['metadata'],
                'registered'    => date('Y-m-d H:i:s'),
                'token'         => randomToken(),
                'role_id'       => 2
            ]);
            if ($user) {
                $key = $this->container->get('settings')['jwt_secret'];
                $jwtpayload = [
                    'iss' => $this->container->get('settings')['app_url'],
                    'aud' => $this->container->get('settings')['app_url'],
                    'iat' => time(),
                    'exp' => time() + 3600,
                    'data'  => [
                        'email' => ''
                    ]
                ];

                $jwtpayload['data']['email'] = $user->email;

                $responseJson = [
                    'message'   => 'Registration success, please check your email.',
                    'user'      => $user,
                    'token'     => JWT::encode($jwtpayload, $key, 'HS256')
                ];
                return createResponseJson($response, $responseJson);
            }
        } catch (Exception $e) {
            return createResponseJson($response, ['message' => 'Registration failed'], 500);
        }
        
        return createResponseJson($response, ['message' => 'Something wrong'], 500);
    }

}