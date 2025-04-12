<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Danh Mục - TECH-MART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Header -->
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
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Danh sách danh mục</h2>
            <a href="index.php?route=admin/categories/add" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm danh mục
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category['category_id'] ?></td>
                            <td><?= htmlspecialchars($category['Name']) ?></td>
                            <td>
                                <a href="index.php?route=admin/categories/edit&id=<?= $category['category_id'] ?>"
                                    class="btn btn-warning btn-sm">
                                    Sửa
                                </a>
                                <button onclick="confirmDelete(<?= $category['category_id'] ?>)"
                                    class="btn btn-danger btn-sm">
                                    Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(categoryId) {
            if (confirm('Bạn có chắc chắn muốn xóa danh mục này không?')) {
                window.location.href = `index.php?route=admin/categories/delete&id=${categoryId}`;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>