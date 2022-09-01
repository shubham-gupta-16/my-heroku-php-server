<?php

require_once './router.php';
require_once '../routes.php';


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Credentials: true');

header('Content-Type: application/json; charset=utf-8');

$uri = $_SERVER['REQUEST_URI'];

if ($r = matchRoute($ROUTES)) {
    if (!is_file('../api/pages/' . $r[0]->file)) return err();
    // echo json_encode($r);
    $arr = include '../api/pages/' . $r[0]->file;
    $data = call_user_func($r[0]->func, ...$r[1]);
    echo json_encode($data);
    //  && is_file('../api/pages/' . $ROUTES[$uri])
} else {
    
}

function err()
{
    echo json_encode([
        'error' => 'File not found'
    ]);
}

function matchRoute($routes = [], $url = null, $method = 'GET')
{
    // I used PATH_INFO instead of REQUEST_URI, because the 
    // application may not be in the root direcory
    // and we dont want stuff like ?var=value
    $reqUrl = $url ?? $_SERVER['REQUEST_URI'];
    $reqMet = $method ?? $_SERVER['REQUEST_METHOD'];

    $reqUrl = rtrim($reqUrl, "/");

    foreach ($routes as $route) {
        // convert urls like '/users/:uid/posts/:pid' to regular expression
        // $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route['url'])) . "$@D";
        $pattern = "@^" . preg_replace('/{[a-zA-Z0-9\_\-]+}/', '([a-zA-Z0-9\_\-]+)', $route->uri) . "$@D";
        // echo $pattern."\n";
        $params = [];
        // check if the current request params the expression
        $match = preg_match($pattern, $reqUrl, $params);
        if ($reqMet == $route->method && $match) {
            // remove the first match
            array_shift($params);

            // call the callback with the matched positions as params
            // return call_user_func_array($route['callback'], $params);
            return [$route, $params];
        }
    }
    return [];
}
