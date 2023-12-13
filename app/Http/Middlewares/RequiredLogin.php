<?php

namespace App\Http\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Container\ContainerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use InvalidArgumentException;
use UnexpectedValueException;

use Slim\App;

use App\Models\User;

class RequiredLogin implements MiddlewareInterface
{

    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function process(Request $request, Handler $handler) : Response
    {
        $response = $this->app->getResponseFactory()->createResponse();
        try {
            if (!$request->hasHeader('Authorization')) {
                return createResponseJson($response, ['message' => 'Login is required'], 403);
            }

            $tokenAuth = str_replace('Bearer ', '', $request->getHeader('Authorization')[0]);
            $key = $this->app->getContainer()->get('settings')['jwt_secret'];

            $decoded = JWT::decode($tokenAuth, new Key($key, 'HS256'));
            if (isset($decoded->data) && isset($decoded->data->email)) {
                $user = User::where('email', $decoded->data->email)->first();
                if ($user) {
                    $request = $request->withAttribute('authUser', $user);
                    $response = $handler->handle($request);
                    return $response;
                } else {
                    throw new Exception('Token not registered');    
                }
            } else {
                throw new Exception('Payload is invalid');
            }

        } catch (
            Exception |
            ExpiredException |
            InvalidArgumentException |
            DomainException |
            SignatureInvalidException |
            BeforeValidException |
            UnexpectedValueException
            $e) {
            return createResponseJson($response, ['message' => $e->getMessage()], 500);
        }
    }
}