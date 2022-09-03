<?php

class Router
{
    public $uri;
    public $method;
    public $file;
    public $func;

    private function __construct(string $method, string $uri, string $file, string $func)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->file = $file;
        $this->func = $func;
    }

    static public function GET(string $uri, string $file, string $func): Router
    {
        return new Router('GET', $uri, $file, $func);
    }
    static public function POST(string $uri, string $file, string $func): Router
    {
        return new Router('POST', $uri, $file, $func);
    }
    static public function PUT(string $uri, string $file, string $func): Router
    {
        return new Router('PUT', $uri, $file, $func);
    }
    static public function PATCH(string $uri, string $file, string $func): Router
    {
        return new Router('PATCH', $uri, $file, $func);
    }
    static public function DELETE(string $uri, string $file, string $func): Router
    {
        return new Router('DELETE', $uri, $file, $func);
    }
}
