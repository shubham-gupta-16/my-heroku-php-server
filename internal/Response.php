<?php

namespace Internal;

use Internal\Types\TypeJson;
use Internal\Types\TypeView;

class Response {

    static public function json(array|object $data): TypeJson
    {
        return new TypeJson('', $data);
    }

    static public function VIEW(string $file_name): TypeView
    {
        return new TypeView('', $file_name);
    }
}