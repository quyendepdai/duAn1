<?php
class HomeController
{
    public function home()
    {
        require_once './Model/Product.php';
        require_once './Model/Category.php';
        require_once './Model/Brand.php';

        require_once './Model/Cart.php';

        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $cartModel = new Cart();
            $countCartByUser = $cartModel->countByUserId($user_id);
        }
        

       

        $category_model = new Category();
        $all_category = $category_model->getAllCategory();

        $brand_model = new Brand();
        $all_brands = $brand_model->getAll();

        $product_model = new Product();

        $limit = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Gọi dữ liệu sản phẩm có phân trang
        $all_products = $product_model->getProductsByPage($limit, $offset);
        $total_products = $product_model->getTotalProductCount();
        $total_pages = ceil($total_products / $limit);




        // print_r($all_category);
        include('./Views/Layout/Header.php');
        include('./Views/Home.php');
        include('./Views/Layout/Footer.php');
    }
}
