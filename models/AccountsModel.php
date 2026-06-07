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

    public function findUserByID($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers(){
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerUser($username, $email, $password_hash){
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
        return $stmt->execute(['username' => $username, 'email' => $email, 'password_hash' => $password_hash]);
    }

    public function deleteUser($id){
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function changeUserRole($id, $role){
        $stmt = $this->pdo->prepare("UPDATE users SET role = :role WHERE id = :id");
        $stmt->execute(['role' => $role, 'id' => $id]);
    }
}