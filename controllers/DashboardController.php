<?php

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    require_once __DIR__ . '/../views/DashboardView.php';
}