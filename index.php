<?php
//Khởi tạo session
session_start();

//Nhúng các file controller 
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

//Kiểm tra xem có tham số route không
$route = isset($_GET['route']) ? $_GET['route'] : '';
switch ($route) {
    case 'category':
        $category = new CategoryController;
        $category->Category();
        break;
    case 'brand':
        $brand = new BrandController;
        $brand->Brand();
            break;
    case 'admin/categories':
        $controller = new CategoryController();
        $controller->listCategories();
        break;
    case 'admin/categories/add':
        $controller = new CategoryController();
        $controller->addCategory();
        break;
    case 'admin/categories/edit':
        $controller = new CategoryController();
        $controller->editCategory();
        break;
    case 'admin/categories/delete':
        $controller = new CategoryController();
        $controller->deleteCategory();
        break;
    case 'cart':
        $cart = new CartController;
        $cart->Cart();
        break;
    case 'add_to_cart':
        $cart = new CartController;
        $cart->AddToCart();
        break;
    case 'remove_from_cart':
        $cart = new CartController;
        $cart->RemoveFromCart();
        break;
    case 'login':
        $controller = new LoginController();
        $controller->login();
        break;
    case 'logout':
        $controller = new LogoutController();
        $controller->logout();
        break;
    case 'admin/products':
        $controller = new AdminController();
        $controller->listProducts();
        break;
    case 'admin/products/add':
        $controller = new AdminController();
        $controller->addProduct();
        break;
    case 'admin/products/edit':
        $controller = new AdminController();
        $controller->editProduct();
        break;
    case 'admin/products/delete':
        $controller = new AdminController();
        $controller->deleteProduct();
        break;
    case 'detail_product':
        $detail = new DetailController;
        $detail->Detail();
        break;
    case 'contact':
        $controller = new ContactController();
        $controller->index();
        break;
    case 'search':
        $controller = new SearchController();
        $controller->search();
        break;
    case 'apply_coupon':
        $controller = new CartController();
        $controller->applyCoupon();
        break;
    case 'clear_cart':
        $controller = new CartController();
        $controller->clearCart();
        break;
    case 'admin/coupons':
        require_once './Model/Coupon.php';
        $couponModel = new Coupon();
        $coupons = $couponModel->getAllCoupons();
        require_once './Views/Admin/Coupons.php';
        break;

    case 'admin/addCoupon':
        $controller = new AdminController();
        $controller->addCoupon();
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
        break;

        case 'register':
            $registerController = new RegisterController();
            $registerController->register();
            break;


    default:
        $home = new HomeController;
        $home->Home();
        break;
}
