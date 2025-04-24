<?php
    $url = $_SERVER['REQUEST_URI'];

    $routes = [
        '/' => 'dashboard.php',
        '/login' => 'login.php',
    ];

    if (isset($routes[$url])) {
        include $routes[$url];
    } else {
        include '404.php';
    }
?>