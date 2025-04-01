<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Nhúng các controller
require_once './Controller/HomeController.php';
require_once './Controller/CategoryController.php';
require_once './Controller/CartController.php';
require_once './Controller/LoginController.php';
require_once './Controller/LogoutController.php';
require_once './Controller/AdminController.php';
require_once './Controller/ContactController.php';
require_once './Controller/SearchController.php';
require_once './Controller/BrandController.php';
require_once './Controller/DetailController.php';
require_once './Controller/registerController.php';

$route = $_GET['route'] ?? '';

switch ($route) {
    // Trang người dùng
    case 'category':
        (new CategoryController)->Category();
        break;
    case 'brand':
        (new BrandController)->Brand();
        break;
    case 'cart':
        (new CartController)->Cart();
        break;
    case 'order':
        (new CartController)->Order();
        break;
    case 'add_to_cart':
        (new CartController)->AddToCart();
        break;
    case 'remove_from_cart':
        (new CartController)->RemoveFromCart();
        break;
    case 'add_new_order':
        (new CartController)->addNewOrder();
        break;
    case 'apply_coupon':
        (new CartController)->applyCoupon();
        break;
    case 'detail_product':
        (new DetailController)->Detail();
        break;
    case 'contact':
        (new ContactController)->index();
        break;
    case 'search':
        (new SearchController)->search();
        break;
    case 'login':
        (new LoginController)->login();
        break;
    case 'logout':
        (new LogoutController)->logout();
        break;
    case 'register':
        (new RegisterController)->register();
        break;

    // Quản lý sản phẩm (admin)
    case 'admin/products':
        (new AdminController)->listProducts();
        break;
    case 'admin/products/add':
        (new AdminController)->addProduct();
        break;
    case 'admin/products/edit':
        (new AdminController)->editProduct();
        break;
    case 'admin/products/delete':
        (new AdminController)->deleteProduct();
        break;

    // Quản lý danh mục
    case 'admin/categories':
        (new CategoryController)->listCategories();
        break;
    case 'admin/categories/add':
        (new CategoryController)->addCategory();
        break;
    case 'admin/categories/edit':
        (new CategoryController)->editCategory();
        break;
    case 'admin/categories/delete':
        (new CategoryController)->deleteCategory();
        break;

    // Quản lý mã giảm giá
    case 'admin/coupons':
        require_once './Model/Coupon.php';
        $couponModel = new Coupon();
        $coupons = $couponModel->getAllCoupons();
        require_once './Views/Admin/Coupons.php';
        break;

    case 'admin/addCoupon':
        (new AdminController)->addCoupon();
        break;

    case 'admin/update_coupon':
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
        break;

    case 'admin/delete_coupon':
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

    // Quản lý đơn hàng
    case 'admin/orders':
        $controller = new AdminController();
        $controller->orderList(); 
        break;
    
    case 'admin/orderDetail':
        (new AdminController)->orderDetail();
        break;
    case 'admin/updateOrderStatus':
        (new AdminController)->updateOrderStatus();
        break;
    case 'admin/deleteOrder':
        (new AdminController())->deleteOrder();
        break;
    

    // Trang mặc định
    default:
        (new HomeController)->Home();
        break;
}
