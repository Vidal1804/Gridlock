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
        require_once __DIR__ . '/controllers/LoginController.php';
        break;

    case '/logout':
        require_once __DIR__ . '/controllers/LogoutController.php';
        break;
    
    case '/register':
        require_once __DIR__ . '/controllers/RegisterController.php';
        break;

    case '/start':
        require_once __DIR__ . '/controllers/StartController.php';
        break;

    case '/dashboard':
        require_once __DIR__ . '/controllers/DashboardController.php';
        break;
        
    case '/api/accidents':
        require_once __DIR__ . '/controllers/AccidentsController.php';
        break;    

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;
}