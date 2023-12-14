<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Load middlewares
use App\Http\Middlewares\RequiredLogin;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\HomeAction;

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
    $app->group('/users', function (RouteCollectorProxy $group) {
        $group->get('/me', UserAction::class . ':me')->setName('user.me');
        $group->get('/profile', UserAction::class . ':getProfile')->setName('user.getProfile');
        $group->post('/profile', UserAction::class . ':updateProfile')->setName('user.updateProfile');
    })->add(new RequiredLogin($app));
};
