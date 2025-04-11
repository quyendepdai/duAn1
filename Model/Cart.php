<?php
class Cart
{
    // Phương thức cho CategoryController
    public function getCartByUserId($user_id)
    {
        include('Connect.php');
        $sql = 'SELECT * FROM cart where user_id = '.$user_id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfoProductByUser($user_id){
         include('Connect.php');
        $sql = "SELECT c.*, p.name , p.price, p.product_img
        FROM cart as c
        JOIN product as p ON c.product_id = p.product_id
        WHERE c.user_id = $user_id";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateQuantityInCart($cart_id,$product_id,$quantity){
        include ('Connect.php');
        $sql = "UPDATE cart
                SET quantity = $quantity
                WHERE cart_id = $cart_id AND product_id = $product_id";
        return $conn->exec($sql);
    }
    public function addToCart($user_id,$product_id,$quantity,$date){
        include('Connect.php');
        $sql = "INSERT INTO cart (user_id,product_id,quantity,added_at) VALUES($user_id,$product_id,$quantity,'$date')";
        return $conn->exec($sql);
    }

    public function countByUserId($use_id){
        include('Connect.php');
        $sql = "SELECT COUNT(*) FROM cart WHERE user_id = $use_id";
        $result = $conn->query($sql);
        $count = $result->fetchColumn();
        
        return $count;
    }

    public function deleteCartItem($product_id,$user_id){
        include('Connect.php');
        $sql = "DELETE FROM cart WHERE product_id = $product_id and user_id = $user_id";
        return $conn->exec($sql);
    }

}