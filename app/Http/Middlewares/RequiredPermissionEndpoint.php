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
use Slim\Routing\RouteContext;

use App\Models\User;
use App\Models\Role;

class RequiredPermissionEndpoint implements MiddlewareInterface
{

    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function process(Request $request, Handler $handler) : Response
    {
        try {
            $routeContext = RouteContext::fromRequest($request);
            $route = $routeContext->getRoute();
            $authUser = $request->getAttribute('authUser');
            if (!$authUser) {
                throw new \Exception('Login property not provided');
            }
            $hasPermission = Role::find(1)->permissions()->where('permissions.name', $route->getName())->exists();
            if (!$hasPermission) {
                throw new \Exception('You do not have permission');
            }
            $response = $handler->handle($request);
            return $response;
        } catch (\Exception $e) {
            $response = $this->app->getResponseFactory()->createResponse();
            return createResponseJson(
                $response, 
                [
                    'message' => 'This resource is require route permission',
                    'error' => $e->getMessage()
                ], 403);
        }
    }
}