<?php

require_once __DIR__ . '/../models/AccountsModel.php';
require_once __DIR__ . '/../config/db.php';

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    $pass = $_POST['password'] ?? '';

    if(!empty($name) && !empty($pass)) {
        $model = new AccountsModel($pdo);
        $user = $model->findUserByUsername($name);

        if($user && password_verify($pass, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: /home");
            exit();
        } else {
            header("Location: /login?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: /login?error=missing_fields");
        exit();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_SESSION['user_id'])){
        header("Location: /home");
        exit();
    }

    require_once __DIR__ . '/../views/AccountsView.php';
    exit();
}