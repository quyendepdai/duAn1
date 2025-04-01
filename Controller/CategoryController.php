<?php
require_once './Model/Category.php';
require_once './Model/Product.php';
require_once './Model/Brand.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    // Phương thức cho trang danh mục thông thường
    public function Category()
    {   
         require_once './Model/Cart.php';

        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $cartModel = new Cart();
            $countCartByUser = $cartModel->countByUserId($user_id);
        }

        $category_model = new Category();
        $all_category = $category_model->getAllCategory();

        $brand_model = new Brand();
        $all_brands = $brand_model->getAll();

        $id = $_GET['category_id'] ?? 0;
        $cat_current = $category_model->getById($id);

        if (!$cat_current) {
            $cat_current = ['Name' => 'Danh mục không tồn tại'];
            $all_products = [];
        } else {
            $product_model = new Product();
            $all_products = $product_model->getProductFromCategory($id);
        }

        include('./Views/Layout/Header.php');
        include('./Views/Category.php');
        include('./Views/Layout/Footer.php');
    }

    // Phương thức cho trang quản lý danh mục
    public function listCategories()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=login');
            exit();
        }
        $categories = $this->categoryModel->getAllCategory();
        require_once './Views/Admin/category_list.php';
    }

    public function addCategory()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            if ($this->categoryModel->addCategory($name)) {
                header('Location: index.php?route=admin/categories');
                exit();
            }
        }
        require_once './Views/Admin/add_category.php';
    }

    public function editCategory()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=login');
            exit();
        }

        $id = $_GET['id'] ?? 0;
        $category = $this->categoryModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            if ($this->categoryModel->updateCategory($id, $name)) {
                header('Location: index.php?route=admin/categories');
                exit();
            }
        }
        require_once './Views/Admin/edit_category.php';
    }

    public function deleteCategory()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?route=login');
            exit();
        }

        $id = $_GET['id'] ?? 0;
        if ($this->categoryModel->deleteCategory($id)) {
            $_SESSION['success'] = "Xóa danh mục thành công";
        } else {
            $_SESSION['error'] = "Không thể xóa danh mục vì có sản phẩm thuộc danh mục này";
        }
        header('Location: index.php?route=admin/categories');
        exit();
    }
}
