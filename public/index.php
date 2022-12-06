<?php

// use Internal\Response;


require_once '../vendor/autoload.php';

// new TypeJson('', []);


$ROUTES = include '../settings/routes.php';


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Credentials: true');


$uri = $_SERVER['REQUEST_URI'];
// todo fixme
// $uri = str_replace('/public', '', $uri);
if (isset($ROUTES[$uri])) {
    $route = $ROUTES[$uri];
    runpage($route);
} else if ($r = matchRoute($ROUTES)) {
    runpage($r[0], $r[1]);
} else {
    err();
}

function runpage($route, array $data = [])
{
    // echo "..\\controllers\\" . $route->file . '.php';
    // echo get_class($route);
    switch (get_class($route)) {
        case 'Internal\Types\TypeView':
            if (!is_file("..\\views\\" . $route->file . '.php')) return err();
            $DATA = (object) $route->data;
            include '..\\views\\' . $route->file . '.php';
            break;
        case 'Internal\Types\TypeController':
            if (!is_file("..\\controllers\\" . $route->file . '.php')) return err();
            include '..\\controllers\\' . $route->file . '.php';
            $response = call_user_func($route->fun, ...$data);
            if (gettype($response) == 'object' && get_class($response) == 'Internal\Types\TypeView') {
                $DATA = (object) $response->data;
                include '..\\views\\' . $response->file . '.php';
            } elseif (gettype($response) == 'object' && get_class($response) == 'Internal\Types\TypeJson') {
                _json($response->data);
            } else {
                _json($response);
            }
            break;
        default:
            return err();
    }
}

function _json($data)
{
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
    $reqUrl = $url ?? $_SERVER['REDIRECT_URL'];
    $reqMet = $method ?? $_SERVER['REQUEST_METHOD'];

    $reqUrl = rtrim($reqUrl, "/");

    foreach ($routes as $uri => $route) {
        if (strpos($uri, '{') === false)
            continue;
        $pattern = "@^" . preg_replace('/{[a-zA-Z0-9\_\-.]+}/', '([a-zA-Z0-9\_\-.]+)', $uri) . "$@D";
        $params = [];
        $match = preg_match($pattern, $reqUrl, $params);
        if ($reqMet == $route->method && $match) {
            array_shift($params);
            return [$route, $params];
        }
    }
    return [];
}
