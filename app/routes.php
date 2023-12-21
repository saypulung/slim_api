<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Load middlewares
use App\Http\Middlewares\RequiredLogin;
use App\Http\Middlewares\RequiredAdmin;
use App\Http\Middlewares\RequiredPermissionEndpoint;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\HomeAction;
use App\Http\Controllers\ProjectAction;

// Auth Controller
use App\Http\Controllers\Auth\LoginAction;
use App\Http\Controllers\Auth\RegisterAction;

// User Controller
use App\Http\Controllers\User\UserAction;

return function (App $app) {
    $app->get('/', HomeAction::class);
    $app->group('/auth', function (RouteCollectorProxy $group) use($app) {
        $group->post('/login', LoginAction::class)->setName('login');
        $group->post('/register', RegisterAction::class)
            ->setName('register')
            ->add(new RegisterRequest($app));
    });
    $app->group('/users', function (RouteCollectorProxy $group) use($app) {
        $group->get('/me', UserAction::class . ':me')
            ->setName('user.me')
            ->add(new RequiredPermissionEndpoint($app));
        $group->post('/profile', UserAction::class . ':updateProfile')->setName('user.updateProfile');
    })->add(new RequiredLogin($app));

    // used for example permission implementations
    $app->group('/projects', function (RouteCollectorProxy $group) use($app) {
        $group->get('/', ProjectAction::class)
            ->setName('project.all')
            ->add(new RequiredPermissionEndpoint($app));
        $group->get('/detail/:id', ProjectAction::class)
            ->setName('project.detail')
            ->add(new RequiredPermissionEndpoint($app));
        $group->post('/', ProjectAction::class)
            ->setName('project.create')
            ->add(new RequiredPermissionEndpoint($app));
        $group->put('/:id', ProjectAction::class)
            ->setName('project.update')
            ->add(new RequiredPermissionEndpoint($app));
        $group->delete('/:id', ProjectAction::class)
            ->setName('project.delete')
            ->add(new RequiredPermissionEndpoint($app));
    })->add(new RequiredLogin($app));
};
