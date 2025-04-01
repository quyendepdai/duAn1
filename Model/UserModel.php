<?php
require_once './Model/Connect.php';

class UserModel {
    private $conn;

    public function __construct() {
        global $conn; // Sử dụng biến $conn từ file Database.php
        $this->conn = $conn;
    }

    public function checkLogin($username, $password) {
        include('Connect.php');
        $sql = "SELECT * FROM user WHERE Username = :username AND Password = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkuser($username){
        $sql = "SELECT * FROM user WHERE Username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username',$username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    public function registeruser($username, $password, $email, $role = 'user') {

        $sql = "SELECT MAX(user_id) as max_id FROM user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $next_id = ($result['max_id'] ?? 0) + 1;

        $sql = "INSERT INTO user (user_id,username, password, email, role) VALUES (:id, :username, :password, :email, :role)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $next_id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }
}