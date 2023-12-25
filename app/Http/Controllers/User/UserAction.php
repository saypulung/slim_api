<?php

namespace App\Http\Controllers\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\User;
use Rakit\Validation\Validator;

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

    public function changePassword(Request $request, Response $response): Response
    {
        try {
            $payload = $request->getParsedBody();
            $validator = new Validator();
            $validation = $validator->validate($payload, [
                'new_password'      => 'required|min:8|max:50',
                'old_password'      => 'required|min:8|max:50',
            ]);
            if ($validation->fails()) {
                return createResponseJson($response, ['message' => $validation->errors()->all()], 422);
            }
            $authUser = $request->getAttribute('authUser');
            $old_password = $payload['old_password'];
            $new_password = $payload['new_password'];

            if (password_verify($old_password, $authUser->password)) {
                $authUser->password = password_hash($payload['new_password'], PASSWORD_BCRYPT, ['cost' => 10]);
                if ($authUser->save()) {
                    return createResponseJson($response, ['message' => 'Password changed']);
                }
            } else {
                return createResponseJson(
                    $response,
                    ['message' => 'Please type your current password correctly'],
                    403);
            }
            throw new \Exception('Error occurs during changing password');
        } catch (\Exception $e) {
            return createResponseJson($response, ['message' => $e->getMessage()], 500);
        }
    }
}