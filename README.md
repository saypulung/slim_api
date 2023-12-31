# Slim API project
Using Eloquent and Phinx migration tools for Slim Framework 4

# Introduction
I develop this source code as my boilerplate for developing lightweight of REST API on PHP. I will use this codebase to start developing product on the backend side. With this codebase, I just provide endpoint API for basic user registration and authentication. I choose Slim Framework 4 as foundation because in my mind its simple, easy to develop and easy to deploy.

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

`composer run-script migrate`

`composer run-script init-admin`

`composer run-script start-dev`

Access your API by URL [localhost:5001](http://localhost:5001)

Optionally, you can setup to your web server by pointing document root into directory `public`

# Using Postman
- Import Slim API Postman collection in this root of project
- Create your environment
- Test using login or register, then the other API will inherit JWT token
- Default user and password from `init admin`, username : `admin` password : `admin1234!`

# Thanks to Developer of These Installed Packages
- [Slim Framework](https://github.com/slimphp/Slim)
- [Nyholm PSR7](https://github.com/Nyholm/psr7)
- [Nyholm PSR7 Server](https://github.com/Nyholm/psr7-server)
- [Phinx](https://github.com/cakephp/phinx)
- [Illuminate Database](https://github.com/illuminate/database)
- [Vlucas Dotenv](https://github.com/vlucas/phpdotenv)
- [Monolog](https://github.com/Seldaek/monolog)
- [Firebase JWT](https://github.com/firebase/php-jwt)
- [PHP DI](https://github.com/PHP-DI/PHP-DI)
- [Ramsey UUID](https://github.com/ramsey/uuid)
- [Rakit Validation](https://github.com/rakit/validation)
