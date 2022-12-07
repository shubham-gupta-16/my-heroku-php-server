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
    err(404);
}

function runpage($route, array $data = [])
{
    // echo "..\\controllers\\" . $route->file . '.php';
    // echo get_class($route);
    switch (get_class($route)) {
        case 'Internal\Types\TypeView':
            _validate_method($route->method, false);
            if (!is_file("..\\views\\" . $route->file . '.php')) return err(500);
            $DATA = (object) $route->data;
            include '..\\views\\' . $route->file . '.php';
            _output($response->status, $response->headers, null);
            break;
        case 'Internal\Types\TypeJson':
            _validate_method($route->method, true);
            _output($response->status, $response->headers, $response->data);
            break;
        case 'Internal\Types\TypeController':
            if (!is_file("..\\controllers\\" . $route->file . '.php')) return err(500);
            include '..\\controllers\\' . $route->file . '.php';
            $response = call_user_func($route->fun, ...$data);
            if (gettype($response) == 'object' && get_class($response) == 'Internal\Types\TypeView') {
                _validate_method($route->method, false);
                $DATA = (object) $response->data;
                include '..\\views\\' . $response->file . '.php';
                _output($response->status, $response->headers, null);
            } elseif (gettype($response) == 'object' && get_class($response) == 'Internal\Types\TypeJson') {
                _validate_method($route->method, true);
                _output($response->status, $response->headers, $response->data);
            } else {
                _validate_method($route->method, true);
                _output(200, null, $response);
            }
            break;
        default:
            return err(500);
    }
}

function _output(int $status_code, ?array $headers, $data)
{
    http_response_code($status_code);
    if ($data != null) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    if ($headers != null) {
        foreach ($headers as $header) {
            header($header);
        }
    }
    die;
}

function _validate_method(string $method, bool $isJson){
    if ($_SERVER['REQUEST_METHOD'] !== $method) {
        return err(400, $isJson ? 'Bad Request' : null);
    }
}

function err(int $status_code, ?string $message = null, ?array $data = null)
{
    http_response_code($status_code);
    if ($message != null){
        header('Content-Type: application/json; charset=utf-8');
        $_errorJson = [
            'error' => $message
        ];
        if ($data != null)
        $_errorJson['data'] = $data;
        echo json_encode($_errorJson);
    }
    die;
}

function matchRoute($routes = [], $url = null)
{
    $reqUrl = $url ?? $_SERVER['REDIRECT_URL'];

    $reqUrl = rtrim($reqUrl, "/");

    foreach ($routes as $uri => $route) {
        if (strpos($uri, '{') === false)
            continue;
        $pattern = "@^" . preg_replace('/{[a-zA-Z0-9\_\-.]+}/', '([a-zA-Z0-9\_\-.]+)', $uri) . "$@D";
        $params = [];
        if (preg_match($pattern, $reqUrl, $params)) {
            array_shift($params);
            return [$route, $params];
        }
    }
    return [];
}
