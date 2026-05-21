<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$requestUri = $_SERVER['REQUEST_URI'];
$cleanPath = parse_url($requestUri, PHP_URL_PATH);

if ($cleanPath !== '/' && substr($cleanPath, -1) === '/') {
    $cleanPath = rtrim($cleanPath, '/');
}

switch ($cleanPath) {
    case '':
    case '/':
    case '/home':
        require_once __DIR__ . '/controllers/HomeController.php';
        break;

    case '/login':
        require_once __DIR__ . '/controllers/AccountsController.php';
        break;

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;
}