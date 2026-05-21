<?php

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_SESSION['user_id'])){
        header("Location: /home");
        exit();
    }

    require_once __DIR__ . '/../views/StartView.php';
    exit();
}