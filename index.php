<?php



//Nhúng các file controller 
require_once './Controller/HomeController.php';


//Kiểm tra xem có tham số route không
$route = isset($_GET['route']) ? $_GET['route'] : '';
switch ($route) {
    case 'home':
        $home = new HomeController;
        $home->Home();
        break;

    default:
        $home = new HomeController;
        $home->Home();
        break;
}
