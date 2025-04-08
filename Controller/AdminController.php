<?php
require_once './Model/Product.php';
require_once './Model/Category.php';
require_once './Model/Brand.php';
require_once './Model/Order.php';

class AdminController
{
    private $productModel;
    private $categoryModel;
    private $brand;

    public function __construct()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=order');
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
        if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] == 0) {
            $target_dir = "asset/images/";
            $product_img = basename($_FILES["product_img"]["name"]);
            $target_file = $target_dir . $product_img;
            move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file);
        }

        $result = $this->productModel->addProduct($name, $price, $description, $product_img, $category_id, $brand_id);
        
        if ($result) {
            $_SESSION['success'] = "Thêm sản phẩm thành công!";
            header('Location: index.php?route=admin/products');
            exit();
        } else {
            $_SESSION['error'] = "Thêm sản phẩm thất bại. Vui lòng thử lại!";
            header('Location: index.php?route=admin/products/add');
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

        $result = $this->productModel->updateProduct($id, $name, $price, $description, $product_img, $category_id, $brand_id);

        if ($result) {
            $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
            header('Location: index.php?route=admin/products');
            exit();
        } else {
            $_SESSION['error'] = "Cập nhật sản phẩm thất bại. Vui lòng thử lại!";
            header("Location: index.php?route=admin/products/edit&id=$id");
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
        if ($id) {
            $result = $this->productModel->deleteProduct($id);
            
            if ($result) {
                $_SESSION['success'] = "Xóa sản phẩm thành công!";
            } else {
                $_SESSION['error'] = "Xóa sản phẩm thất bại. Vui lòng thử lại!";
            }
    
            header('Location: index.php?route=admin/products');
            exit();
        exit();
    }
}
public function addCoupon()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once './Model/Coupon.php';
        $couponModel = new Coupon();

        $code = trim($_POST['code'] ?? '');
        $discount = floatval($_POST['discount'] ?? 0);
        $expiry = trim($_POST['expiry'] ?? '');
        $errors = [];
        if ($discount <= 0 || $discount > 100) {
            $errors[] = 'Mã giảm giá phải nằm trong khoảng từ 0 đến 100';
        }

        if (empty($expiry) || !strtotime($expiry)) {
            $errors[] = 'Ngày hết hạn mã giảm giá không hợp lệ!';
        } elseif (strtotime($expiry) < time()) {
            $errors[] = 'Mã giảm giá không thể đã qua!';
        }
        if (!empty($errors)) {
            $errorString = urlencode(implode(', ', $errors));
            header("Location: index.php?route=admin/coupons&error=$errorString");
            exit();
        }

        if ($couponModel->addCoupon($code, $discount, $expiry)) {
            header('Location: index.php?route=admin/coupons&success=1');
        } else {
            header('Location: index.php?route=admin/coupons&error=Failed to add coupon.');
        }
        exit();
    }
}
public function updateCounpon(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once './Model/Coupon.php';
        $couponModel = new Coupon();
        $id = $_POST['id'];
        $code = $_POST['code'];
        $discount = $_POST['discount'];
        $expiry = $_POST['expiry'];
        if ($couponModel->updateCoupon($id, $code, $discount, $expiry)) {
            header('Location: index.php?route=admin/coupons');
        }
    }
}
public function deleteCounpons(){
    require_once './Model/Coupon.php';
        $couponModel = new Coupon();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        try {
            if ($id > 0 && $couponModel->deleteCoupon($id)) {
                $_SESSION['success'] = "Xóa mã giảm giá thành công!";
            } else {
                $_SESSION['error'] = "Xóa mã giảm giá thất bại!";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Có lỗi xảy ra: " . $e->getMessage();
        }

        header('Location: index.php?route=admin/coupons');
        exit();
}

    public function getAllOrders(){
        $orderModel = new Order();
        
        $allOrders = $orderModel->getAllOrderModel();

        require_once './Views/Admin/orders.php';
    }
     public function updateOrderStatus(){
        $orderModel = new Order();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $statusUpdate = '';
            if(isset($_POST['cancel'])){
                $statusUpdate = $_POST['cancel'];
            }

            if(isset($_POST['statusUpdate'])){
                $statusUpdate = $_POST['statusUpdate'];
            }
            $order_id = $_POST['orderId'];
 
          $result =   $orderModel->updateOrderStatus($order_id, $statusUpdate);
          if($result){
            header('Location: index.php?route=admin/orders');
             $_SESSION['success'] = 'Cập nhật trạng thái đơn hàng thành công';
          }
          
        }

        require_once './Views/Admin/orders.php';
    }
}