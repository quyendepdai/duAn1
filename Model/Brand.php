<<<<<<< HEAD
<?php
class Brand
{
    // Phương thức cho CategoryController
    public function getAllBrand()
    {
        include('Connect.php');
        $sql = 'SELECT * FROM brands';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        include('Connect.php');
        
        $sql = 'SELECT * FROM brands WHERE brand_id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
=======
<?php
class Brand
{
    // Phương thức cho CategoryController
    public function getAllBrand()
    {
        include('Connect.php');
        $sql = 'SELECT * FROM brands';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        include('Connect.php');
        
        $sql = 'SELECT * FROM brands WHERE brand_id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
>>>>>>> 8bb1d22542e001b6d5b4fb09cfa411fb3f5e6bdc
}