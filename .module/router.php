<?php

class Router
{

    public $uri;
    public $method;
    public $file;
    public $func;


    private function __construct(string $method, string $uri, string $file, ?string $func = null)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->file = $file;
        if ($func != null) {
            $this->func = $func;
        }
    }

    static public function GET(string $uri, string $file, ?string $func = null): Router
    {
        return new Router('GET', $uri, $file, $func);
    }
    static public function POST(string $uri, string $file, ?string $func = null): Router
    {
        return new Router('POST', $uri, $file, $func);
    }
    static public function PUT(string $uri, string $file, ?string $func = null): Router
    {
        return new Router('PUT', $uri, $file, $func);
    }
    static public function PATCH(string $uri, string $file, ?string $func = null): Router
    {
        return new Router('PATCH', $uri, $file, $func);
    }
    static public function DELETE(string $uri, string $file, ?string $func = null): Router
    {
        return new Router('DELETE', $uri, $file, $func);
    }
}
