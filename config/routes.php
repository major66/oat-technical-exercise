<?php

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/v1/users/{userId}', function (Request $request, Response $response): ResponseInterface {
    $response = $response->withStatus(200);
    return $response;
});
