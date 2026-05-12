<?php
require_once '../config/db.php';
require_once '../models/AccountsModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if (!empty($name) && !empty($pass)) {
        $model = new AccountsModel($pdo);
        $user = $model->findUser($name, $pass);

        if ($user) {
            setcookie("name", $name, time() + 86400, "/");
            header("Location: ../views/home.php");
            exit();
        } else {
            header("Location: ../views/AccountsView.php?error=Incorrect login");
            exit();
        }
    } else {
        header("Location: ../views/AccountsView.php?error=Please fill all fields");
        exit();
    }
}