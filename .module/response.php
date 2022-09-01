<?php

class Response {
    public $data;
    public $code;
    public $view;

    private function __construct(array|object $data, int $code, ?string $view) {
        $this->data = $data;
        $this->code = $code;
        $this->view = $view;
    }

    static public function JSON(array|object $data, int $code = 200)
    {
        return new Response($data, $code, null);
    }

    static public function VIEW(string $view, array|object $data = null, int $code = 200)
    {
        return new Response($data, $code, $view);
    }
}