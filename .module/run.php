<?php

require_once './router.php';
require_once '../routes.php';
require_once './response.php';


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Credentials: true');


$uri = $_SERVER['REQUEST_URI'];

// print_r($_SERVER);
if (isset($ROUTES[$uri])){
    $route = $ROUTES[$uri];
    // echo $uri;
    // echo $route->file;
    runpage($route);
}
else if ($r = matchRoute($ROUTES)) {
    runpage($r[0], $r[1]);
    // echo json_encode($data);
    //  && is_file('../controllers/' . $ROUTES[$uri])
} else {
    // Route Not Found
    err();
}

function runpage(Router $route, array $data = []){
    if (!is_file('../controllers/' . $route->file . '.php')) return err();
    include '../controllers/' . $route->file . '.php';
    if ($route->func == null) return;
    $response = call_user_func($route->func, ...$data);
    if (gettype($response) == 'object' && get_class($response) == 'Response') {
        
        if ($response->view != null) {
            $DATA = $response->data;
            include '../views/' . $response->view;
        } else {
            json($response->data);
        }
    } else {
        json($response);
    }
}

function json($data){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    die;
}

function err()
{
    header('Content-Type: application/json; charset=utf-8');
    header("HTTP/1.1 404 Not Found");
    echo json_encode([
        'error' => 'File not found'
    ]);
    die;
}

function matchRoute($routes = [], $url = null, $method = 'GET')
{
    // I used PATH_INFO instead of REQUEST_URI, because the 
    // application may not be in the root direcory
    // and we dont want stuff like ?var=value
    $reqUrl = $url ?? $_SERVER['REDIRECT_URL'];
    $reqMet = $method ?? $_SERVER['REQUEST_METHOD'];

    $reqUrl = rtrim($reqUrl, "/");

    foreach ($routes as $uri => $route) {
        // convert urls like '/users/:uid/posts/:pid' to regular expression
        // $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route['url'])) . "$@D";
        $pattern = "@^" . preg_replace('/{[a-zA-Z0-9\_\-.]+}/', '([a-zA-Z0-9\_\-.]+)', $uri) . "$@D";
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
