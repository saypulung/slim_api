<?php

use Slim\App;
use App\Http\Controllers\HomeAction;

return function (App $app) {
    $app->get('/', HomeAction::class);
};
