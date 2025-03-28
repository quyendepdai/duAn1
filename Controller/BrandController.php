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
   

    // Phương thức cho trang danh mục thông thường
    public function Brand()
    {
        $brandModel = new Brand();
        $all_brands = $brandModel->getAllBrand();



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
