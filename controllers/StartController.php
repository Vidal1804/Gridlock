<?php

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $action = $_POST['action'] ?? '';

    switch($action){
        case 'login':
            header("Location: /login");
            exit();
        case 'register':
            header("Location: /register");
            exit();
        default:
            http_response_code(400);
            exit();
    }
}



if($_SERVER['REQUEST_METHOD'] === 'GET'){
    require_once __DIR__ . '/../views/StartView.php';
    exit();
}