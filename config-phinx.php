<?php
require_once __DIR__ . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable(__DIR__))->load();

$dbdriver = isset($_ENV['DB_CONNECTION']) ? $_ENV['DB_CONNECTION'] : 'mysql';
define('DB_ADAPTER', $dbdriver);

$dbhost = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'localhost';
define('DB_HOST', $dbhost);

$dbname = isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : 'slim';
define('DB_NAME', $dbname);

$dbuser = isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'root';
define('DB_USER', $dbuser);

$dbpass = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '';
define('DB_PASS', $dbpass);

$dbport = isset($_ENV['DB_PORT']) ? $_ENV['DB_PORT'] : '3306';
define('DB_PORT', $dbport);

$dbcharset = isset($_ENV['DB_CHARSET']) ? $_ENV['DB_CHARSET'] : 'utf8';
define('DB_CHARSET', $dbcharset);

$dbcollation = isset($_ENV['DB_COLLATION']) ? $_ENV['DB_COLLATION'] : 'utf8_unicode_ci';
define('DB_COLLATION', $dbcollation);

return [
    'paths' => [
      'migrations' => 'database/migrations'
    ],
    'migration_base_class' => '\Migrations\Migration',
    'environments' => [
      'default_database' => 'dev',
      'dev' => [
        'adapter' => DB_ADAPTER,
        'host' => DB_HOST,
        'name' => DB_NAME,
        'user' => DB_USER,
        'pass' => DB_PASS,
        'port' => DB_PORT,
      ]
    ]
  ];