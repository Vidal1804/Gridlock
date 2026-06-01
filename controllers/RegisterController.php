<?php

require_once __DIR__ . '/../models/AccountsModel.php';
require_once __DIR__ . '/../config/db.php';

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '';
    $pass = $_POST['password'] ?? '';
    $confirm_pass = $_POST['confirm_pass'] ?? '';

    if(!empty($name) && !empty($email) && !empty($pass) && !empty($confirm_pass)){
        $model = new AccountsModel($pdo);
        $user = $model->findUserByUsername($name);
        if(!$user){
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            $hashedConfirm = password_hash($confirm_pass, PASSWORD_DEFAULT);
            if($hashedPass != $hashedConfirm){
                header("Location: /register?error=passwords_dont_match");
                exit();
            }
            if($model->registerUser($name, $email, $hashedPass)){
                header("Location: /login");
                exit();
            }
            else {
                header("Location: /register?error=registration_failed");
                exit();
            }
            
        }
        else{
            header("Location: /register?error=user_already_exists");
            exit();
        }     
    }
    else{
        header("Location: /register?error=incomplete_data");
        exit();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    require_once __DIR__ . '/../views/RegisterView.php';
    exit();
}