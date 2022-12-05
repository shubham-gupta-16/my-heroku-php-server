<?php

function index()
{
    return "Hello Laralite API";    
}

function test($log, $data)
{
    return Response::JSON([$log, $data]);   
}