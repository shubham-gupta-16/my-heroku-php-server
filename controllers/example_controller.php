<?php

function view()
{
    return Response::VIEW('example_view', ['message'=>'It works']);
}
