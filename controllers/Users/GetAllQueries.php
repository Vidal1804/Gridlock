<?php
require_once __DIR__ . "/../../config/db.php";
require_once __DIR__ . "/../../models/AccountsModel.php";

header('Content-Type: application/json');

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['user_id'])){

    $model = new AccountsModel($pdo);
    $queries = $model->getAllUserQueries($_SESSION['user_id']);
    echo json_encode($queries);
}
else{
    header("Location: /start");
    exit();
}
