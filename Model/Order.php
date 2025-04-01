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
                WHERE o.user_id = $user_id";
        return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm thêm đơn hàng với thông tin khách hàng
    public function addIntoOrderDetailWithCustomer($order_id, $product_id, $quantity, $price, $name, $phone, $address, $note)
    {
        include('Connect.php');
        $sql = "INSERT INTO order_detail (Order_id, Product_ID, Quantity, Price, customer_name, phone, address, note)
                VALUES (:order_id, :product_id, :quantity, :price, :customer_name, :phone, :address, :note)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':order_id' => $order_id,
            ':product_id' => $product_id,
            ':quantity' => $quantity,
            ':price' => $price,
            ':customer_name' => $name,
            ':phone' => $phone,
            ':address' => $address,
            ':note' => $note
        ]);
    }


    // hàm lấy danh sách đơn hàng
    public function getAllOrders()
    {
        include('Connect.php');
        $sql = "SELECT o.Order_id AS order_id, s.customer_name, s.phone, s.shipping_address AS address, s.note, o.Status AS status
                FROM `order` o
                JOIN `shipping` s ON o.Order_id = s.order_id
                ORDER BY o.Order_id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    
        //Hàm lấy chi tiết đơn hàng:
        public function getOrderDetail($order_id)
    {
        include('Connect.php');
        $sql = "SELECT od.*, p.name AS product_name, p.product_img
                FROM order_detail od
                JOIN product p ON od.product_id = p.product_id
                WHERE od.order_id = :order_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
        //Hàm lấy thông tin đơn hàng theo ID:
        public function getOrderById($order_id)
    {
        include('Connect.php');
        $sql = "SELECT * FROM `order_detail` WHERE order_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $order_id);
        $stmt->execute();
        return $stmt->fetch();
    }
        //Hàm cập nhật trạng thái:
        public function updateStatus($order_id, $status)
    {
        include('Connect.php');
        $sql = "UPDATE `order` SET Status = :status WHERE Order_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':id' => $order_id
        ]);
        return true;
}
        //Hàm xóa đơn hàng:
        public function deleteOrder($order_id)
{
    include('Connect.php');

    // 1. Xóa payments trước
    $sql1 = "DELETE FROM payments WHERE order_id = :id";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bindParam(':id', $order_id);
    $stmt1->execute();

    // 2. Xóa shipping
    $sql2 = "DELETE FROM shipping WHERE order_id = :id";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindParam(':id', $order_id);
    $stmt2->execute();

    // 3. Xóa order_detail
    $sql3 = "DELETE FROM order_detail WHERE order_id = :id";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bindParam(':id', $order_id);
    $stmt3->execute();

    // 4. Cuối cùng, xóa order
    $sql4 = "DELETE FROM `order` WHERE Order_id = :id";
    $stmt4 = $conn->prepare($sql4);
    $stmt4->bindParam(':id', $order_id);
    return $stmt4->execute();
}

        

        
}