<?php
require_once './Model/Product.php';
require_once './Model/Category.php';
require_once './Model/Brand.php';

class AdminController
{
    private $productModel;
    private $categoryModel;
    private $brand;

    public function __construct()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=login');
            exit();
        }
        $this->categoryModel = new Category();
        $this->brand = new Brand(); // Initialize the brand property
        $this->productModel = new Product();
        $this->brand = new Brand();
    }

    public function listProducts()
    {
        // Lấy giá trị lọc
        $letter = $_GET['letter'] ?? '';
        $price_range = $_GET['price_range'] ?? '';
    
        // Phân trang
        $limit = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
    
        // Lấy danh sách sản phẩm theo bộ lọc và phân trang
        $products = $this->productModel->filterProducts($letter, $price_range, $limit, $offset);
    
        // Đếm tổng sản phẩm sau lọc để tính số trang
        $total_products = $this->productModel->countFilteredProducts($letter, $price_range);
        $total_pages = ceil($total_products / $limit);
    
        require_once './Views/Admin/dashboard.php';
    }
    

    public function addProduct()
    {
        $all_category = $this->categoryModel->getAll();
        $all_brand = $this->brand->getAll();


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $brand_id = $_POST['brand_id'];

            $product_img = '';
            if (isset($_FILES['product_img'])) {
                $target_dir = "asset/images/";
                $product_img = basename($_FILES["product_img"]["name"]);
                $target_file = $target_dir . $product_img;
                move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file);
            }

            if ($this->productModel->addProduct($name, $price, $description, $product_img, $category_id, $brand_id)) {
                header('Location: index.php?route=admin/products');
                exit();
            }
        }
        require_once './Views/Admin/add_product.php';
    }

    public function editProduct()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=admin/products');
            exit();
        }

        $all_category = $this->categoryModel->getAll();
        $all_brand = $this->brand->getAll();
        $product = $this->productModel->getProductFromId($id); // Sửa lại thành getProductFromId()

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $brand_id = $_POST['brand_id'];

            $product_img = $product['product_img'];
            if (isset($_FILES['product_img']) && $_FILES['product_img']['size'] > 0) {
                $target_dir = "asset/images/";
                $product_img = basename($_FILES["product_img"]["name"]);
                $target_file = $target_dir . $product_img;
                move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file);
            }

            if ($this->productModel->updateProduct($id, $name, $price, $description, $product_img, $category_id)) {
                header('Location: index.php?route=admin/products');
                exit();
            }
        }
        require_once './Views/Admin/edit_product.php';
    }

    public function deleteProduct()
    {
        $id = $_GET['id'] ?? null;
        if ($id && $this->productModel->deleteProduct($id)) {
            header('Location: index.php?route=admin/products');
        }
        exit();
    }
    public function addCoupon()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once './Model/Coupon.php';
            $couponModel = new Coupon();

            $code = $_POST['code'];
            $discount = $_POST['discount'];
            $expiry = $_POST['expiry'];

            if ($couponModel->addCoupon($code, $discount, $expiry)) {
                header('Location: index.php?route=admin/coupons&success=1');
            } else {
                header('Location: index.php?route=admin/coupons&error=1');
            }
            exit();
        }
    }
}
