<?php
class AccountsModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // used for the login page to get password_hash
    public function loginFindUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // used for literally everywhere else from a view.
    public function findUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM safe_accounts WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}