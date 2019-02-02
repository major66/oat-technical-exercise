<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'debug' => true, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true,
        'outputBuffering' => 'append',
    ],
    'dataSource' => [
        'defaultType' => 'json',
        'path' => [
            'json.path' => __DIR__ . '/../dataSource/Json/testtakers.json',
            'csv.path' => __DIR__ . '/../dataSource/Csv/testtakers.csv',
        ]
    ],
];
