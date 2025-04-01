<?php
class Product
{
    
    public function getAllProduct($page = 1, $limit = 8)
{
    include('Connect.php');
    $offset = ($page - 1) * $limit;

    // Ép kiểu an toàn
    $limit = (int)$limit;
    $offset = (int)$offset;

    // Gán trực tiếp vào chuỗi SQL
    $sql = "SELECT 
                product.product_id , 
                product.name, 
                product.price,
                product.description,
                product.product_img,
                brands.brand_name AS brand_name, 
                category.name AS category_name
            FROM product
            JOIN brands ON product.brand_id = brands.brand_id
            JOIN category ON product.category_id = category.category_id
            ORDER BY product.product_id DESC
            LIMIT $limit OFFSET $offset";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

    public function getProductFromId($id) {
        include('Connect.php');
        try {
            $sql = "SELECT p.*, c.Name as CategoryName 
                    FROM product p 
                    LEFT JOIN category c ON p.Category_ID = c.Category_ID 
                    WHERE p.Product_ID = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Debug
            error_log("Product data for ID $id: " . print_r($result, true));
            
            return $result;
        } catch(PDOException $e) {
            error_log("Error fetching product: " . $e->getMessage());
            return false;
        }
    }

public function getProductFromCategory($category_id)
{
    include('Connect.php');
    $sql = 'SELECT * FROM product WHERE category_id = :category_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

public function getProductFromBrand($brand_id)
{
    include('Connect.php');
    $sql = 'SELECT product.*, brands.brand_name FROM product
            LEFT JOIN brands ON product.brand_id = brands.brand_id 
            WHERE product.brand_id = :brand_id LIMIT 8' ;
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

public function addProduct($name, $price, $description, $product_img, $category_id,$brand_id)
{
    include('Connect.php');
    try {
        // Lấy ID lớn nhất hiện tại
        $sql = "SELECT MAX(Product_ID) as max_id FROM product";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $next_id = ($result['max_id'] ?? 0) + 1;

        // Thêm sản phẩm mới với ID được tính toán
        $sql = 'INSERT INTO product (Product_ID, Name, Price, Description, product_img, category_id,brand_id) 
                VALUES (:id, :name, :price, :description, :product_img, :category_id,:brand_id)';
        $stmt = $conn->prepare($sql);
        
        // Bind các tham số
        $stmt->bindParam(':id', $next_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':product_img', $product_img);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':brand_id', $brand_id);
        
        return $stmt->execute();
    } catch(PDOException $e) {
        error_log("Error adding product: " . $e->getMessage());
        return false;
    }
}

public function updateProduct($id, $name, $price, $description, $product_img, $category_id, $brand_id)
{
    include('Connect.php');
    $sql = 'UPDATE product SET 
                Name = :name, 
                Price = :price, 
                Description = :description, 
                product_img = :product_img, 
                category_id = :category_id,
                brand_id = :brand_id
            WHERE Product_ID = :id';
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':product_img', $product_img);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':brand_id', $brand_id); 
    return $stmt->execute();
}


    public function deleteProduct($id)
{
    include('Connect.php');
    try {
        // Bắt đầu transaction
        $conn->beginTransaction();

        // Xóa các bản ghi liên quan trong order_detail trước
        $sql = 'DELETE FROM order_detail WHERE Product_ID = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Sau đó mới xóa sản phẩm
        $sql = 'DELETE FROM product WHERE Product_ID = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        return true;
    } catch(PDOException $e) {
        // Nếu có lỗi thì rollback
        $conn->rollBack();
        error_log("Error deleting product: " . $e->getMessage());
        return false;
    }
}
public function searchProducts($query) {
    include ('Connect.php');
    $sql = 'SELECT 
    product.product_id , 
    product.name, 
    product.price,
    product.description,
    product.product_img,
    brands.brand_name AS brand_name, 
    category.name AS category_name
    FROM product
    JOIN brands ON product.brand_id = brands.brand_id
    JOIN category ON product.category_id = category.category_id
    WHERE product.name LIKE :query OR brands.brand_name LIKE :query OR category.name LIKE :query LIMIT 8' ;
    $stmt = $conn->prepare($sql);
    $searchQuery = '%' . $query . '%';
    $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getProductById($id)
    {
        include('Connect.php');
        $sql = 'SELECT * FROM product WHERE Product_ID=' . $id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }
    
    // phân trang  
public function getTotalProductCount()
{
    include('Connect.php');
    $sql = 'SELECT COUNT(*) AS total FROM product';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

// Lấy sản phẩm theo trang (có offset và limit)
public function getProductsByPage($limit, $offset)
{
    include('Connect.php');
    $sql = 'SELECT 
            product.product_id,
            product.name,
            product.price,
            product.description,
            product.product_img,
            brands.brand_name AS brand_name, 
            category.name AS category_name
            FROM product
            JOIN brands ON product.brand_id = brands.brand_id
            JOIN category ON product.category_id = category.category_id
            ORDER BY product.product_id DESC
            LIMIT :limit OFFSET :offset';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Lọc sản phẩm theo chữ cái và khoảng giá

private function buildPriceFilter($price_range)
{
    switch ($price_range) {
        case '1':
            return " AND p.price < 5000000";
        case '2':
            return " AND p.price BETWEEN 5000000 AND 10000000";
        case '3':
            return " AND p.price BETWEEN 10000000 AND 20000000";
        case '4':
            return " AND p.price > 20000000";
        default:
            return "";
    }
}



public function filterProducts($letter = '', $price_range = '', $limit = 8, $offset = 0)
{
    include('Connect.php');

    $sql = "SELECT 
                p.product_id, p.name, p.price, p.description, p.product_img, 
                b.brand_name, c.name as category_name
            FROM product p
            JOIN brands b ON p.brand_id = b.brand_id
            JOIN category c ON p.category_id = c.category_id
            WHERE 1=1";

    $params = [];

    if (!empty($letter)) {
        $sql .= " AND p.name LIKE :letter";
        $params[':letter'] = $letter . '%';
    }

    if (!empty($price_range)) {
        $sql .= $this->buildPriceFilter($price_range);
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $conn->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function countFilteredProducts($letter = '', $price_range = '')
{
    include('Connect.php');

    $sql = "SELECT COUNT(*) FROM product p WHERE 1=1";
    $params = [];

    if (!empty($letter)) {
        $sql .= " AND p.name LIKE :letter";
        $params[':letter'] = $letter . '%';
    }

    if (!empty($price_range)) {
        $sql .= $this->buildPriceFilter($price_range);
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}




}

