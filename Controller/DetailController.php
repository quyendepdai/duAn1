<?php
include './Model/Product.php';
include_once './Model/Brand.php';

class DetailController
{
    public function Detail()
    {

        $product = new Product;
        $id = isset($_GET['id']) ? $_GET['id'] : 1;

        $brand_model = new Brand();
        $all_brands = $brand_model->getAllBrand();

        $detail_product = $product->getProductById($id);
        $similar_product = $product->getProductFromBrand($detail_product['brand_id']);

        include('./Views/Layout/Header.php');
        include('./Views/detailProduct.php');
        include('./Views/Layout/Footer.php');
    }
}
