<?php
class AccountsModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // used for the login page to get password_hash
    public function loginFindUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT id, username, password_hash, role FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // used for literally everywhere else from a view.
    public function findUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM safe_accounts WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers(){
        $stmt = $this->pdo->prepare("SELECT * FROM safe_accounts");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerUser($username, $email, $password_hash){
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
        return $stmt->execute(['username' => $username, 'email' => $email, 'password_hash' => $password_hash]);
    }
}