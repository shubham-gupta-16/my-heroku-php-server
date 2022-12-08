<?php

use Internal\Response;

function index()
{
    return Response::json("Hello Laralite API")->status(201)
        ->headers(['Custom-Header: Hello World']);
}

function test($log, $data)
{
    return [$log, $data];
}
