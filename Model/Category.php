<?php
class Category
{
    // Phương thức cho CategoryController
    public function getAllCategory()
    {
        include('Connect.php');
        $sql = 'SELECT * FROM category';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        include('Connect.php');
        $sql = 'SELECT * FROM category WHERE category_id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Phương thức cho AdminController
    public function getAll()
    {
        include('Connect.php');
        $sql = 'SELECT * FROM category';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id)
    {
        include('Connect.php');
        $sql = 'SELECT * FROM category WHERE category_id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCategory($name)
    {
        include('Connect.php');
        try {
            // Lấy ID lớn nhất hiện tại
            $sql = "SELECT MAX(category_id) as max_id FROM category";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $next_id = ($result['max_id'] ?? 0) + 1;

            // Thêm danh mục mới với ID được tính toán
            $sql = 'INSERT INTO category (category_id, Name) VALUES (:id, :name)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $next_id);
            $stmt->bindParam(':name', $name);
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error adding category: " . $e->getMessage());
            return false;
        }
    }

    public function updateCategory($id, $name)
    {
        include('Connect.php');
        $sql = 'UPDATE category SET Name = :name WHERE category_id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    public function deleteCategory($id)
    {
        include('Connect.php');
        try {
            // Kiểm tra xem danh mục có sản phẩm không
            $sql = 'SELECT COUNT(*) FROM product WHERE category_id = :id';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                // Nếu có sản phẩm, không cho phép xóa
                return false;
            }

            // Nếu không có sản phẩm thì xóa danh mục
            $sql = 'DELETE FROM category WHERE category_id = :id';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error deleting category: " . $e->getMessage());
            return false;
        }
    }
}