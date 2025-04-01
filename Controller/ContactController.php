<?php
require_once './Model/Brand.php';

class ContactController
{
    public function index()
    {
         require_once './Model/Cart.php';

        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $cartModel = new Cart();
            $countCartByUser = $cartModel->countByUserId($user_id);
        }
        // Khởi tạo Category Model để lấy danh sách danh mục
 

        $brand_model = new Brand();
        $all_brands = $brand_model->getAll();

        // Truyền biến $all_category vào các view
        require_once './Views/Layout/Header.php';
        require_once './Views/Contact.php';
        require_once './Views/Layout/Footer.php';
    }
}
