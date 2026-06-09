<?php

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}



if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(!isset($_SESSION['user_id']) || (isset($_SESSION['role']) && $_SESSION['role'] === 'user')){
        header("Location: /start");
        exit();
    } 
    require_once __DIR__ . '/../views/AdminUsersView.php';
}

