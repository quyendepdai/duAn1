<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm - TECH-MART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=admin/products">Quản lý sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=admin/categories">Quản lý danh mục</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=admin/coupons">Quản lý mã giảm giá</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="index.php?route=logout" class="btn btn-outline-light me-2">Đăng xuất</a>
                    <a href="index.php" class="btn btn-outline-light">Trang chủ</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Thêm Sản Phẩm Mới</h2>
        <form action="index.php?route=admin/products/add" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php foreach ($all_category as $category): ?>
                        <option value="<?= $category['category_id'] ?>"><?= $category['Name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="brand_id" class="form-label">Thương Hiệu</label>
                <select class="form-control" id="brand_id" name="brand_id" required>
                    <?php foreach ($all_brand as $brand): ?>
                        <option value="<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="product_img" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="product_img" name="product_img" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
            <a href="index.php?route=admin/products" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>