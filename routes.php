<?php

$ROUTES = [
    Router::GET('/flutter-ecommerce-demo/products', 'flutter-ecommerce-demo-products.php', 'index'),
    Router::GET('/test/{log}/{data}', 'flutter-ecommerce-demo-products.php', 'test'),
    Router::GET('/view/example', 'flutter-ecommerce-demo-products.php', 'view'),
];