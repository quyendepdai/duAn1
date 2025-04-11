<?php
require_once './Model/UserModel.php';

class LoginController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->checkLogin($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['User_id'];
                $_SESSION['username'] = $user['Username'];
                $_SESSION['role'] = $user['Role'];

                if ($user['Role'] === 'admin') {
                    header("Location: index.php?route=admin/products");
                    exit();
                }
                 else {
                    header("Location: index.php?route=home");
                    exit();
                }
            }
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Bạn chưa nhập tên tài khoản hoặc password';
                header("Location: index.php?route=login");
                exit();
            } else {
                $_SESSION['error'] = "Tên đăng nhập hoặc mật khẩu không đúng";
            }
        }
        require_once './Views/Auth/Login.php';
    }
}
