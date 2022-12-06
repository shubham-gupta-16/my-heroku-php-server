<?php

use Internal\Response;

function view()
{
    return Response::view('example_view')->with_data(['message' => 'It works']);
}
