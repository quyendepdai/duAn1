<?php
require_once './Model/Product.php';
require_once './Model/Category.php';
require_once './Model/Brand.php';

class SearchController
{
    public function search()
    {
        // Lấy danh sách danh mục cho menu
        $category_model = new Category();
        $all_category = $category_model->getAllCategory();

        $brand_model = new Brand();
        $all_brands = $brand_model->getAll();

        // Thực hiện tìm kiếm
        $query = $_GET['query'] ?? '';
        $product_model = new Product();
        $results = $product_model->searchProducts($query);

        require_once './Views/Layout/Header.php';
        require_once './Views/SearchResults.php';
        require_once './Views/Layout/Footer.php';
    }
}
