<?php
require_once './Model/Product.php';
require_once './Model/Brand.php';

class DetailController
{
    public function Detail()
    {
         require_once './Model/Cart.php';

        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $cartModel = new Cart();
            $countCartByUser = $cartModel->countByUserId($user_id);
        }

        $product = new Product;
        $id = isset($_GET['id']) ? $_GET['id'] : 1;

        $brand_model = new Brand();
        $all_brands = $brand_model->getAll();

        $detail_product = $product->getProductById($id);
        $similar_product = $product->getProductFromBrand($detail_product['brand_id']);

        include('./Views/Layout/Header.php');
        include('./Views/detailProduct.php');
        include('./Views/Layout/Footer.php');
    }
}
