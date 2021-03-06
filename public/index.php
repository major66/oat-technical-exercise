<?php

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

$app = new class() extends App {
    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions(
            __DIR__ . '/../config/settings.php',
            __DIR__ . '/../config/definitions.php'
        );
    }
};

// Register middleware
require __DIR__ . '/../config/middleware.php';

// Register routes
require __DIR__ . '/../config/routes.php';

// Run app
$app->run();
