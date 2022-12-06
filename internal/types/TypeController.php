<?php

namespace Internal\Types;

class TypeController
{
    public $method;
    public $file;
    public $fun;

    private function __construct(string $method, string $file_name)
    {
        $this->method = $method;
        $this->file = $file_name;
    }

    public function fun(string $function_name)
    {
        $this->fun = $function_name;
    }
}
