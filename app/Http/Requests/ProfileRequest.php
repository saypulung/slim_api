<?php

namespace App\Http\Requests;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;

use Slim\App;
use Rakit\Validation\Validator;

class ProfileRequest implements MiddlewareInterface, CustomRequest
{
    private $app;
    private $errors = [];

    public function __construct(App $app) {
        $this->app = $app;
    }

    public function process(Request $request, Handler $handler) : Response
    {
        $response = $this->app->getResponseFactory()->createResponse();
        if (!$this->authorize()) {
            return createResponseJson($response, ['message' => 'Access forbidden'], 403);
        }
        
        if (!$this->validate($request)) {
            return createResponseJson(
                $response, 
                [
                    'message' => 'Invalid parameters',
                    'errors' => $this->errors
                ],
                422);
        }
        return $handler->handle($request);
    }

    public function authorize()
    {
        return true;
    }

    public function validate(Request $request)
    {
        $payload = $request->getParsedBody();
        $validator = new Validator;
        $validation = $validator->validate($payload, [
            'first_name'            => 'required|min:3|max:50',
            'last_name'             => 'min:3|max:50',
            'metadata'              => 'array',
        ]);
        if ($validation->fails()) {
            $this->errors = $validation->errors()->all();
            return false;
        }
        return true;
    }
}