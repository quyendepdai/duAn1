<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm - TECH-MART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=admin/products">Quản lý sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Quản lý mã giảm giá</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Sửa Sản Phẩm</h2>
        <form action="index.php?route=admin/products/edit&id=<?= $product['Product_ID'] ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['Name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $product['Price'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($product['Description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php foreach ($all_category as $category): ?>
                        <option value="<?= $category['category_id'] ?>"
                            <?= ($category['category_id'] == $product['category_id']) ? 'selected' : '' ?>>
                            <?= $category['Name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="product_img" class="form-label">Hình ảnh hiện tại</label>
                <img src="./asset/images/<?= $product['product_img'] ?>" alt="Current Image" style="width: 100px; height: 100px; object-fit: cover; display: block; margin-bottom: 10px;">
                <input type="file" class="form-control" id="product_img" name="product_img">
                <input type="hidden" name="current_image" value="<?= $product['product_img'] ?>">
                <small class="form-text text-muted">Chỉ chọn ảnh nếu muốn thay đổi</small>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            <a href="index.php?route=admin/products" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>