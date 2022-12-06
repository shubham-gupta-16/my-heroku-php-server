<?php

use Internal\Response;
use PHPMailer\PHPMailer\PHPMailer;

function index()
{
    $phpmailer = new PHPMailer();
    return "Hello Laralite API";
}

function test($log, $data)
{
    return Response::json([$log, $data]);
}
