<?php

namespace Internal;

use Internal\Types\TypeController;
use Internal\Types\TypeView;

class RouteMap {

    public $method;

    private function __construct(string $method)
    {
        $this->method = $method;
    }

    public function controller(string $file_name): TypeController
    {
        return new TypeController($this->method, $file_name);
    }

    public function view(string $file_name) : TypeView
    {
        return new TypeView($this->method, $file_name);
    }

    static public function get(): RouteMap
    {
        return new RouteMap('GET');
    }
    static public function post(): RouteMap
    {
        return new RouteMap('POST');
    }
    static public function put(): RouteMap
    {
        return new RouteMap('PUT');
    }
    static public function patch(): RouteMap
    {
        return new RouteMap('PATCH');
    }
    static public function delete(): RouteMap
    {
        return new RouteMap('DELETE');
    }
}