<?php

use Internal\RouteMap;

return [
    '/' => RouteMap::get()->controller('example_api_controller')->fun('index'),
    '/test/{log}/{data}' => RouteMap::get()->controller('exmaple_api_controller')->fun('test'),
    '/view/example' => RouteMap::get()->controller('exmaple_controller')->fun('view'),
    '/view/example2' => RouteMap::get()->view('example_view')->with_data(['message' => 'Amazing']),
];
