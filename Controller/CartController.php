<?php
require_once './Model/Coupon.php';
require_once './Model/Cart.php';
require_once './Model/Order.php';
class CartController
{
    public function applyCoupon()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['coupon_code'] ?? '';

            if (empty($code)) {
                $_SESSION['coupon_error'] = 'Vui lòng chọn mã giảm giá';
                header('Location: index.php?route=cart');
                exit();
            }

            $couponModel = new Coupon();
            $coupon = $couponModel->checkCoupon($code);

            if ($coupon) {
                $_SESSION['discount'] = $coupon['Discount_Amount'];
                $_SESSION['applied_coupon'] = $code;
                $_SESSION['coupon_success'] = 'Áp dụng mã giảm giá thành công!';
            } else {
                $_SESSION['coupon_error'] = 'Mã giảm giá không hợp lệ hoặc đã hết hạn';
            }
        }

        header('Location: index.php?route=cart');
        exit();
    }
    public function Cart()
    {

        
         require_once './Model/Cart.php';

        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $cartModel = new Cart();
            $carts = $cartModel->getInfoProductByUser($user_id); 
            $countCartByUser = $cartModel->countByUserId($user_id);
        }

        require_once './Model/Brand.php';
        $brand_model = new Brand();
        $all_brands = $brand_model->getAll();

        include('./Views/Layout/Header.php');
        include('./Views/Cart.php');
        include('./Views/Layout/Footer.php');
    }

    public function AddToCart()
    {
        $product_id = $_GET['id'] ?? 0;
        require_once './Model/Product.php';
        $product_model = new Product();
        $product = $product_model->getProductFromId($product_id);

        $user_id = $_SESSION['user_id'];
        $cardModel = new Cart();
        $cardByUserId = $cardModel->getCartByUserId($user_id);

        $isSet = false;
        echo($product_id.'<br>');
        if(!empty($cardByUserId)){
           foreach ($cardByUserId as $value) {
            echo($value['product_id'].'<br>');

                if($value['product_id'] == $product_id){
                    echo('true');
                    $value['quantity'] += 1;
                    $addToCart = $cardModel->updateQuantityInCart($value['cart_id'],$product_id,$value['quantity']);
                    $isSet = true;
                    break;
                }
           }
        }
        if(!$isSet){
            $quantity = 1;
            $date = date("Y-m-d H:i:s");
            $addToCart = $cardModel->addToCart($user_id,$product_id,$quantity,$date);
        }  

        header('Location: index.php' );
        exit();
    }

    public function addNewOrder() {

         if (isset($_POST)){
            print_r($_POST);
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $totalMoney = $_POST['totalMoney'];
            $paymentMethod = $_POST['paymentMethod'];
            $note = $_POST['note'];
            $date = date("Y-m-d H:i:s");

            $user_id = $_SESSION['user_id'];

            // lấy các bản ghi trong cart
            $cardModel = new Cart();
            $cardByUserId = $cardModel->getInfoProductByUser($user_id);
            echo('<pre>');
            print_r($cardByUserId);
            echo('</pre>');
            $orderModel = new Order();

            //insert vào bảng Order
            $newOrderId = $orderModel->addIntoOrder($user_id,$date,$totalMoney);

            //insert vào bảng OrderDetail và xóa cart
            foreach($cardByUserId as $key => $value){
                $orderModel->addIntoOrderDetail($newOrderId,$value['product_id'],$value['quantity'],$value['price']);
                $cardModel->deleteCartItem($value['product_id'],$user_id);
            }

            //insert vào bảng Payments
            $insertPayment = $orderModel->addIntoPayment($newOrderId,$paymentMethod);
            
            //insert vào bảng shipping
            $insertShipping = $orderModel->addIntoShipping($newOrderId,$address,$phone,$name,$note);

          


            $_SESSION['success'] = 'Đặt hàng thành công';
            header('Location: index.php?route=order');
         }
        
        // // Chuyển về trang chủ
        // header('Location: index.php');
        // exit();
    }


    public function RemoveFromCart()
    {
        $product_id = $_GET['id'] ?? 0;
        $user_id = $_SESSION['user_id'];

        $cartModel = new Cart();

        $isDelete = $cartModel->deleteCartItem($product_id,$user_id);

      

       if( !$isDelete ){
           $_SESSION['error'] = "Xóa thất bại! Vui lòng thử lại sau.";
       }
        header('Location: index.php?route=cart');
        exit();
    }

    public function Order(){
           require_once './Model/Cart.php';

        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $cartModel = new Cart();
            $carts = $cartModel->getInfoProductByUser($user_id); 
            $countCartByUser = $cartModel->countByUserId($user_id);
        }

        require_once './Model/Brand.php';
        $brand_model = new Brand();
        $all_brands = $brand_model->getAll();

        $orderModel = new Order();
        $all_orders = $orderModel->getOrderByUserId($user_id);

        include('./Views/Layout/Header.php');
        include('./Views/Order.php');
        include('./Views/Layout/Footer.php');
    }
}
