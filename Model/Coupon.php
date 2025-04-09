<?php
class Coupon {
    private $conn;

    public function __construct() {
        require_once('Connect.php');
        global $conn;
        $this->conn = $conn;
    }
    public function checkCoupon($code) {
        $sql = "SELECT * FROM coupon 
                WHERE Code = :code 
                AND Expiration_Date >= CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllValidCoupons() {
        $sql = "SELECT * FROM coupon WHERE Expiration_Date >= CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCoupons() {
        try {
            $sql = "SELECT * FROM coupon ORDER BY Coupon_id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error getting coupons: " . $e->getMessage());
            return [];
        }
    }

    public function addCoupon($code, $discount, $expiry) {
        try {
            $sql = "INSERT INTO coupon (Code, Discount_Amount, Expiration_Date) 
                    VALUES (:code, :discount, :expiry)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':discount', $discount);
            $stmt->bindParam(':expiry', $expiry);
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error adding coupon: " . $e->getMessage());
            return false;  // Thay vì throw Exception
        }
    }

    public function deleteCoupon($id) {
        try {
            $sql = "DELETE FROM coupon WHERE Coupon_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error deleting coupon: " . $e->getMessage());
            return false;  // Thay vì throw Exception
        }
    }

    public function updateCoupon($id, $code, $discount, $expiry) {
        try {
            $sql = "UPDATE coupon 
                    SET Code = :code, 
                        Discount_Amount = :discount, 
                        Expiration_Date = :expiry 
                    WHERE Coupon_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':discount', $discount);
            $stmt->bindParam(':expiry', $expiry);
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error updating coupon: " . $e->getMessage());
            throw new Exception("Không thể cập nhật mã giảm giá");
        }
    }



    public function getCouponById($id) {
        try {
            $sql = "SELECT * FROM coupon WHERE Coupon_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
    }
}