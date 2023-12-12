# Slim API project
Using Eloquent and Phinx migration tools for Slim Framework 4

# Server Requirement
This project is using Slim Framework 4, you can read to this [Slim Documentation](https://www.slimframework.com/docs/v4/start/installation.html)

Recommendation:
1. PHP 8.1 or newer
2. Composer 2
3. MariaDB 10.10 or newer
4. PDO Extension

# How to run

Make sure that port 5001 is available on your system

Run `composer install`

Copy .env.example into .env

Customize your .env based on your database configuration or other

`php vendor/bin/phinx migrate -c config-phinx.php`

`composer run-script init-admin`

`composer run-script start-dev`

Access your API by URL [localhost:5001](http://localhost:5001)

Optionally, you can setup to your web server by pointing document root into directory public

# Used Packages
- [Slim Framework](https://github.com/slimphp/Slim)
- [Phinx](https://github.com/cakephp/phinx)
- [Illuminate Database](https://github.com/illuminate/database)
- [Vlucas Dotenv](https://github.com/vlucas/phpdotenv)
- [Monolog](https://github.com/Seldaek/monolog)
- [Firebase JWT](https://github.com/firebase/php-jwt)
- [PHP DI](https://github.com/PHP-DI/PHP-DI)
