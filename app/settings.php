<?php

use Psr\Http\Message\ResponseInterface as Response;

(Dotenv\Dotenv::createImmutable(__DIR__ . '/..'))->load();

function ngetenv(string $key, string $default)
{
    $env = isset($_ENV[$key]) ? $_ENV[$key] : $default;
    return $env;
}

function createResponseJson(Response $response, $data, $statusCode = 200)
{
    try {
        if ($data == NULL)
        {
            $data = [];
        }

        if (is_array($data)) {
            $response->getBody()->write(json_encode($data));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($statusCode);
        } else {
            $response->getBody()->write(json_encode(['message' => 'Content not supported']));
            return $response->withStatus(500);
        }
    } catch (Exception $e)
    {
        $response->getBody()->write(json_encode([
            'message'   => $e->getMessage()
        ]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    }
}

if (ngetenv('APP_ENV', 'development') == 'production') {
    error_reporting(0);
    ini_set('display_errors', '0');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

// Settings
$settings = [
    'db'    => [
        'driver'    => ngetenv('DB_CONNECTION', 'mysql'),
        'host'      => ngetenv('DB_HOST', 'localhost'),
        'database'  => ngetenv('DB_DATABASE', 'slim'),
        'username'  => ngetenv('DB_USERNAME', 'root'),
        'password'  => ngetenv('DB_PASSWORD', ''),
        'port'      => ngetenv('DB_PORT', '3306'),
        'charset'   => ngetenv('DB_CHARSET', 'utf8'),
        'collation' => ngetenv('DB_COLLATION', 'utf8_unicode_ci'),
        'prefix'    => ngetenv('DB_PREFIX', ''),
    ],
    'cors_origins'  => ngetenv('CORS_ALLOWED_ORIGINS', 'null'),
    'jwt_secret'    => ngetenv('JWT_SECRET', ''),
    'app_name'      => ngetenv('APP_NAME', 'slim_api'),
    'app_url'       => ngetenv('APP_URL', 'http://localhost:5001'),
    'app_debug'     => ngetenv('APP_DEBUG', 'false'),
    'log_level'     => ngetenv('APP_LOG_LEVEL', 'debug'),

];

return $settings;