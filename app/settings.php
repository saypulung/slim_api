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
    if (is_array($data)) {
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    } else {
        return $response->getBody()->write($data);
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
    ]
];

return $settings;