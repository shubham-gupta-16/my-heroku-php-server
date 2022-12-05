<?php

class Router
{
    public $method;
    public $file;
    public $func;

    private function __construct(string $method, string $file, string $func)
    {
        $this->method = $method;
        $this->file = $file;
        $this->func = $func;
    }

    static public function GET(string $file, string $func): Router
    {
        return new Router('GET', $file, $func);
    }
    static public function POST(string $file, string $func): Router
    {
        return new Router('POST', $file, $func);
    }
    static public function PUT(string $file, string $func): Router
    {
        return new Router('PUT', $file, $func);
    }
    static public function PATCH(string $file, string $func): Router
    {
        return new Router('PATCH', $file, $func);
    }
    static public function DELETE(string $file, string $func): Router
    {
        return new Router('DELETE', $file, $func);
    }
}
