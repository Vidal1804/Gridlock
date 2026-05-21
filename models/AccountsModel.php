<?php
class AccountsModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findUserByUsername($username) {
        // Always use prepared statements with bound parameters
        $stmt = $this->pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}