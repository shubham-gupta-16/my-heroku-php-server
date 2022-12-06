<?php

namespace Internal\Types;

class TypeJson
{
    public $method;
    public $data;

    public function __construct(string $method, array|object $data)
    {
        $this->method = $method;
        $this->data = $data;
    }
}
