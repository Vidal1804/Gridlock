<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/AccountsModel.php";

header('Content-Type: application/json');

if(session_status() === PHP_SESSION_NONE){
    session_start();
}


if(isset($_SESSION['role'])){
    if($_SESSION['role'] === 'user'){
        header("Location: /start");
        exit();
    }
    else {
        $model = new AccountsModel($pdo);
        $users = $model->getAllUsers();
        echo json_encode($users);
    }
}
else{
    header("Location: /start");
    exit();
}
