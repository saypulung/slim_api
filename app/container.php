<?php

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use function DI\autowire;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    LoggerInterface::class => function (ContainerInterface $container) : LoggerInterface {
        $handlers = (PHP_SAPI == 'cli')
            ? [new StreamHandler('php://stderr')]
            : [new ErrorLogHandler()];
        return new Logger('app', $handlers, [$container->get(UidProcessor::class)]);
    },
    UidProcessor::class => autowire(),
    App::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);

        $dbSettings = $container->get('settings')['db'];
        $cors_origins = $container->get('settings')['cors_origins'];
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($dbSettings, 'default');
        $capsule->bootEloquent();
        $capsule->setAsGlobal();

        if (php_sapi_name() !== 'cli') {

            $app->options('/{routes:.+}', function ($request, $response, $args) {
                return $response;
            });
            
            $app->add(function ($request, $handler) use ($cors_origins) {
                $response = $handler->handle($request);
                return $response
                        ->withHeader('Access-Control-Allow-Origin', $cors_origins)
                        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                        ->withHeader('Access-Control-Allow-Credentials', 'true');
            });

            // Register routes
            (require __DIR__ . '/routes.php')($app);

            // Register middleware
            (require __DIR__ . '/middleware.php')($app);
        }

        return $app;
    },
];