<?php

$ROUTES = [
    '/my_libraries/my-heroku-php-server/' => Router::GET('example_api_controller', 'index'),
    '/test/{log}/{data}' => Router::GET('exmaple_api_controller', 'test'),
    '/view/example' => Router::GET('exmaple_controller', 'view'),
];