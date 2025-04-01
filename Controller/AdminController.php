<?php
require_once './Model/Product.php';
require_once './Model/Category.php';
require_once './Model/Brand.php';
require_once './Model/Order.php'; // gọi tới model quản lý đơn hàng

class AdminController
{
    private $productModel;
    private $categoryModel;
    private $brand;
    private $orderModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=order');
            exit();
        }
        $this->categoryModel = new Category();
        $this->brand = new Brand();
        $this->productModel = new Product();
        $this->orderModel = new Order(); // Khởi tạo model đơn hàng
    }

    public function listProducts()
    {
        $letter = $_GET['letter'] ?? '';
        $price_range = $_GET['price_range'] ?? '';

        $limit = 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $products = $this->productModel->filterProducts($letter, $price_range, $limit, $offset);
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
                $product_img = time() . '_' . basename($_FILES["product_img"]["name"]);
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
        $product = $this->productModel->getProductFromId($id);

        if (!$product) {
            header('Location: index.php?route=admin/products');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $brand_id = $_POST['brand_id'];

            $product_img = $product['product_img'];
            if (isset($_FILES['product_img']) && $_FILES['product_img']['size'] > 0) {
                $target_dir = "asset/images/";
                $product_img = time() . '_' . basename($_FILES["product_img"]["name"]);
                $target_file = $target_dir . $product_img;
                move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file);
            }

            if ($this->productModel->updateProduct($id, $name, $price, $description, $product_img, $category_id, $brand_id)) {
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

    //  QUẢN LÝ ĐƠN HÀNG
    public function orderList()
    {
        $this->orderModel = new Order();
        $orders = $this->orderModel->getAllOrders();
    
        require_once './Views/Admin/order_list.php'; 
    }
    

    public function orderDetail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?route=admin/orders");
            exit();
        }

        $order = $this->orderModel->getOrderById($id);
        $details = $this->orderModel->getOrderDetail($id);
        require './Views/Admin/order_detail.php';
    }

    public function updateOrderStatus()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $order_id = $_POST['order_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($order_id !== null && $status !== null) {
            $this->orderModel = new Order();
            $this->orderModel->updateStatus($order_id, $status);
            $_SESSION['success'] = "Cập nhật trạng thái đơn hàng thành công.";
        } else {
            $_SESSION['error'] = "Thiếu dữ liệu cập nhật.";
        }

        header("Location: index.php?route=admin/orders");
        exit();
    }
}

    public function deleteOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'] ?? null;
    
            if ($order_id) {
                $this->orderModel = new Order(); // Khởi tạo model đơn hàng
                // Kiểm tra xem đơn hàng có tồn tại không
                $result = $this->orderModel->deleteOrder($order_id);
                if ($result) {
                    $_SESSION['success'] = "Xóa đơn hàng thành công!";
                } else {
                    $_SESSION['error'] = "Xóa thất bại!";
                }
            } else {
                $_SESSION['error'] = "Thiếu ID đơn hàng!";
            }
    
            header("Location: index.php?route=admin/orders");
            exit();
        }
    }
    

}
