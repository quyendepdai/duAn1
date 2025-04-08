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

    public function checkUser($username){
        $sql = "SELECT * FROM user WHERE Username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username',$username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    public function registerUser($username, $password, $email, $role = 'user') {

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


    public function getAllUsers() {
        $sql = "SELECT * FROM user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUserById($id) {
        $sql = "SELECT * FROM user WHERE User_id  = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function deleteUser($id) {
        // Xóa cart liên quan trước
        $stmt1 = $this->conn->prepare("DELETE FROM cart WHERE user_id = :id");
        $stmt1->execute(['id' => $id]);
    
        // Rồi mới xóa user
        $stmt2 = $this->conn->prepare("DELETE FROM user WHERE User_id = :id");
        return $stmt2->execute(['id' => $id]);
    }

    public function updateRole($id, $role) {
        $sql = "UPDATE user SET role = :role WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':role' => $role,
            ':id' => $id
        ]);
    }
    
    
   
}
