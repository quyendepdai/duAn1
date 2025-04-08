<?php
require_once './Model/UserModel.php';

class UserAdminController {

    // Lấy danh sách người dùng
    public function getAllUsers() {
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();
        require './Views/Admin/user_list.php';
    }

    // Thay đổi vai trò qua select box
    public function changeRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $role = isset($_POST['role']) ? $_POST['role'] : '';
    
            // Kiểm tra kỹ hơn: không dùng in_array với ràng buộc chặt nữa
            if ($id > 0 && !empty($role)) {
                $userModel = new UserModel();
                if ($userModel->updateRole($id, $role)) {
                    $_SESSION['success'] = "Cập nhật vai trò thành công!";
                } else {
                    $_SESSION['error'] = "Cập nhật vai trò thất bại!";
                }
            } else {
                $_SESSION['error'] = "Dữ liệu không hợp lệ!";
            }
    
            header('Location: index.php?route=admin/useradmin');
            exit();
        }
    }
    
    


    // Xóa người dùng
    public function delete() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $userModel = new UserModel();
            if ($userModel->deleteUser($id)) {
                $_SESSION['success'] = "Xóa người dùng thành công!";
            } else {
                $_SESSION['error'] = "Xóa người dùng thất bại!";
            }
        } else {
            $_SESSION['error'] = "ID người dùng không hợp lệ!";
        }

        header('Location: index.php?route=admin/useradmin');
        exit();
    }
}
