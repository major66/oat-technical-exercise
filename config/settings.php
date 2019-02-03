<?php

return [
    'settings.displayErrorDetails' => true, // set to false in production
    'settings.addContentLengthHeader' => false, // Allow the web server to send the content-length header
    'dataSource.defaultType' => 'json',
    'dataSource.json.path' => __DIR__ . '/../dataSource/Json/testtakers.json',
    'dataSource.csv.path' => __DIR__ . '/../dataSource/Csv/testtakers.csv',
];
