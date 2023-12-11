<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);

        $dbSettings = $container->get('settings')['db'];
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($dbSettings, 'default');
        $capsule->bootEloquent();
        $capsule->setAsGlobal();

        // Register routes
        (require __DIR__ . '/routes.php')($app);

        // Register middleware
        (require __DIR__ . '/middleware.php')($app);

        return $app;
    },
];