<?php
require_once('./Model/UserModel.php');
class RegisterController{
    public $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $email = $_POST['email'];

            if(empty($username) || empty($password) || empty($confirm_password) || empty($email)){
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
                header('Location: index.php?route=register');
                exit();
            }
            if($password !== $confirm_password){
                $_SESSION['error'] = "PassWord không trùng khớp với nhau xin vui lòng thử lại!";
                header('location: index.php?route=register');
                exit();
            }
            if($this->userModel->checkUser($username)){
                $_SESSION['error'] = "Tên đăng nhập đã tồn tại! Vui lòng chỉnh lại!";
                header('Location: index.php?route=register');
                exit();
            }
            $internis = $this->userModel->registerUser($username,$password,$email);
            if($internis){
                $_SESSION['error'] = "Đăng Ký thành công!bạn có thể đăng nhập!";
                header('Location: index.php?route=login');
                exit();
            }
            else{
                $_SESSION['error'] = "Đăng Ký thất bại vui lòng đăng nhập lại!";
                header('Location: index.php?route=register');
                exit();
            }
        }
        require_once('./Views/Auth/register.php');
    }
}
?>