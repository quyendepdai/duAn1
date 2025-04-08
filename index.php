<?php
//Khởi tạo session
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

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
require_once './Controller/UserAdminController.php';

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
    case 'order':
        $cart = new CartController;
        $cart->Order();
        break;   
    case 'add_to_cart':
        $cart = new CartController;
        $cart->addToCart();
        break;
    case 'remove_from_cart':
        $cart = new CartController;
        $cart->removeFromCart();
        break;
     case 'add_new_order':
        $cart = new CartController;
        $cart->addNewOrder();
        break;
    case 'login':
        $controller = new LoginController();
        $controller->login();
        break;
    case 'logout':
        $controller = new LogoutController();
        $controller->logout();
        break;
    case 'admin/orders': 
         $controller = new AdminController();
         $controller->getAllOrders();
        break;
    case 'admin/updateOrderStatus': 
         $controller = new AdminController();
         $controller->updateOrderStatus();
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

    case 'admin/delete_coupon':
        $controller = new AdminController();
        $controller->deleteCounpons();
        break;

    case 'admin/update_coupon':
        $controller = new AdminController();
        $controller->updateCounpon();
        break;

    case 'register':
            $registerController = new RegisterController();
            $registerController->register();
            break;
    case 'admin/useradmin':
            $userAdmin = new UserAdminController();
            $userAdmin->getAllUsers();
            break;

        case 'admin/delete_user':
            $userAdmin = new UserAdminController();
            $userAdmin->delete();
            break;
        
        case 'admin/change_role':
            $controller = new UserAdminController();
            $controller->changeRole();
            break;
      
    default:
        $home = new HomeController;
        $home->Home();
        break;
}