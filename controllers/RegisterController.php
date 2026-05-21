<?php

require_once __DIR__ . '/../models/AccountsModel.php';
require_once __DIR__ . '/../config/db.php';

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

}

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    require_once '/../views/RegisterView.php';
    exit();
}