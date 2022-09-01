<?php

require_once '../routes.php';


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Credentials: true');

header('Content-Type: application/json; charset=utf-8');

$uri = $_SERVER['REQUEST_URI'];



if (isset($ROUTES[$uri]) && is_file('../api/pages/' . $ROUTES[$uri])) {
    $arr = include '../api/pages/' . $ROUTES[$uri];
    echo json_encode($arr);
} else {
    echo json_encode([
        'error' => 'File not found'
    ]);
}
