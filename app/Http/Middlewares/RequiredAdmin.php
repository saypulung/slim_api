<?php
namespace App\Http\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Container\ContainerInterface;

use Slim\App;

class RequiredAdmin implements MiddlewareInterface
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }
    
    public function process(Request $request, Handler $handler) : Response
    {
        try {
            $authUser = $request->getAttribute('authUser');
            if (!$authUser) {
                throw new \Exception('Login property not provided');
            }
            if ($authUser->role_id == 1) {
                return $handler->handle($request);
            } else {
                throw new \Exception('Require admin');
            }
        } catch (\Exception $e)
        {
            $response = $this->app->getResponseFactory()->createResponse();
            return createResponseJson(
                $response, 
                [
                    'message' => 'This resource is require Admin',
                    'error' => $e->getMessage()
                ], 403);
        }
    }
}