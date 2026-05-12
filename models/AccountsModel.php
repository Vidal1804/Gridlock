<?php
class AccountsModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function findUser($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        return $stmt->fetch();
    }
}