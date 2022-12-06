<?php

namespace Internal\Types;

class TypeView
{
    public $method;
    public $file;
    public $data;

    public function __construct(string $method, string $file_name)
    {
        $this->method = $method;
        $this->file = $file_name;
    }

    public function with_data(array $data): TypeView
    {
        $this->data = $data;
        return $this;
    }
}
