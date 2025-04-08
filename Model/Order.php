<?php
class Order
{
    // Phương thức cho CategoryController
    public function addIntoOrder($user_id,$date,$totalMoney)
    {
        include('Connect.php');
         // Lấy ID lớn nhất hiện tại
        $sql = "SELECT MAX(order_id) as max_id FROM `order`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $next_id = ($result['max_id'] ?? 0) + 1;


        $sql = "INSERT INTO `order`(order_id,user_id,date,total_order) 
        VALUES ($next_id,$user_id,'$date',$totalMoney)";
        $result = $conn->exec($sql);
        if($result) return $next_id;
    }
    public function addIntoOrderDetail($order_id,$product_id,$quantity,$price)
    {
        include('Connect.php');
        $sql = "INSERT INTO `order_detail`(order_id,product_id,quantity,price) Values ($order_id,$product_id,$quantity,$price)";
          
        return $conn->exec($sql);
    }

    public function addIntoPayment($order_id,$paymentMethod){
        include('Connect.php');
        $sql = "INSERT INTO `payments`(order_id,payment_method) Values ($order_id,'$paymentMethod')";
        return $conn->exec($sql);
    }

     public function addIntoShipping($order_id,$address,$phone,$name,$note = null){
        include('Connect.php');
        $sql = "INSERT INTO `shipping`(order_id,shipping_address,phone,	customer_name,note)
            Values ($order_id,'$address','$phone','$name','$note')";
          return $conn->exec($sql);
    }
    
    public function getOrderByUserId($user_id){
         include('Connect.php');
        $sql = "SELECT o.order_id, o.Total_order, o.date, o.status, od.id, od.quantity, p.product_img, p.name, p.price FROM `order` o 
                JOIN `order_detail` od ON o.order_id = od.order_id 
                JOIN `product` p ON od.product_id = p.product_id 
                WHERE o.user_id = $user_id AND o.status != 'Cancelled'
                ORDER BY o.order_id DESC";
        return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrderModel(){
        include('Connect.php');
        $sql = "SELECT o.order_id, o.user_id, o.date, o.total_order, o.status, s.customer_name, s.phone, s.shipping_address, s.shipping_status
                 FROM `order` o JOIN `shipping` s ON o.order_id = s.order_id
                 WHERE o.status != 'Cancelled'
                 ORDER BY o.date DESC;";
         return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateOrderStatus($order_id,$newStatus){
        include('Connect.php');
        $sql = "UPDATE `order`
                SET status = '$newStatus'
                WHERE order_id = $order_id";
         return $conn->exec($sql);
    }
}