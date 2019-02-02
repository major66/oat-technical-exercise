<?php

use Oat\UserApi\Action\User\GetUserAction;
use Oat\UserApi\Action\User\GetUserListAction;
use Slim\App;

$app->group('/v1/users', function (App $app) {
    $app->get('', GetUserListAction::class);
    $app->get('/{id}', GetUserAction::class);
});