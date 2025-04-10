<?php
require_once './Model/Brand.php';
require_once './Model/Product.php';

class BrandController
{
    private $brandModel;

    public function __construct()
    {
        $this->brandModel = new Brand();
    }
   
    public function Brand()
    {
         require_once './Model/Cart.php';

        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $cartModel = new Cart();
            $countCartByUser = $cartModel->countByUserId($user_id);
        }

        $brandModel = new Brand();
        $all_brands = $brandModel->getAll();

        $id = $_GET['brand_id'] ?? 0;

        $brand_current = $brandModel->getById($id);
        

        if (!$brand_current) {
            $brand_current = ['Name' => 'Danh mục không tồn tại'];
            $all_products = [];
        } else {
            $product_model = new Product();
            $all_products = $product_model->getProductFromBrand($id);
        }

        include('./Views/Layout/Header.php');
        include('./Views/Brand.php');
        include('./Views/Layout/Footer.php');
    }

   
}
