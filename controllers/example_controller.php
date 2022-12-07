<?php

use Internal\Response;

function view()
{
    return Response::view('example_view')->with(['message' => 'It works'])->status(202);
}
