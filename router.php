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

    case '/map':
        require_once __DIR__ . '/controllers/DashboardController.php';
        break;
        
    case '/api/accidents':
        require_once __DIR__ . '/controllers/AccidentsController.php';
        break;

    case '/api/accidents/stats':
        require_once __DIR__ . '/controllers/AccidentsStatsController.php';
        break;
        
    case '/api/users':
        require_once __DIR__ . '/controllers/GetAllAccounts.php';
        break;
        
    case '/admin':
        require_once __DIR__ . '/controllers/AdminController.php';
        break;

    case '/attributes':
        require_once __DIR__ . '/views/Attributions.php';
        break;

    case '/list':
        require_once __DIR__ . '/controllers/ListController.php';
        break;

    case '/profile':
        require_once __DIR__ . '/controllers/ProfileController.php';
        break;
    case '/api/users/changerole':
        require_once __DIR__ . '/controllers/Users/ChangeRole.php';
        break;

    case '/api/users/deleteuser':
        require_once __DIR__ . '/controllers/Users/DeleteUser.php';
        break;
    
    case '/api/users/savequery':
        require_once __DIR__ . '/controllers/Users/SaveQuery.php';
        break;

    case '/api/queries':
        require_once __DIR__ . '/controllers/Users/GetAllQueries.php';
        break;

    case '/api/users/deletequery':
        require_once __DIR__ . '/controllers/Users/DeleteQuery.php';
        break;

    default:
        http_response_code(404);
        require_once __DIR__ . '/views/NotFound.php';
        break;
}