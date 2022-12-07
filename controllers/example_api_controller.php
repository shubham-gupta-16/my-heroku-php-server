<?php

use Internal\Response;
use PHPMailer\PHPMailer\PHPMailer;

function index()
{
    $phpmailer = new PHPMailer();
    return Response::json("Hello Laralite API")->status(201)
        ->headers(['Custom-Header: Hello World']);
}

function test($log, $data)
{
    return [$log, $data];
}
