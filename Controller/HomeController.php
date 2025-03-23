<?php
class HomeController
{
    public function home()
    {
        require_once './Model/Product.php';
        require_once './Model/Category.php';
        $category_model = new Category();
        $all_category = $category_model->getAllCategory();
        $product_model = new Product();
        $all_products = $product_model->getAllProduct();
        // print_r($all_category);
        include('./Views/Layout/Header.php');
        include('./Views/Home.php');
        include('./Views/Layout/Footer.php');
    }
}
