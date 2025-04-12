<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Lý - TECH-MART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $route == 'admin/products' ? 'active' : '' ?>"
                            href="index.php?route=admin/products">Quản lý sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $route == 'admin/categories' ? 'active' : '' ?>"
                            href="index.php?route=admin/categories">Quản lý danh mục</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Quản lý đơn hàng</a>
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
            <h2>Danh sách sản phẩm</h2>
            <a href="index.php?route=admin/products/products/add" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm sản phẩm
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Thương hiệu</th>
                        <th>Danh mục</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['product_id'] ?></td>
                            <td>
                                <img src="./asset/images/<?= $product['product_img'] ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= number_format($product['price']) ?> VND</td>
                            <td><?= htmlspecialchars($product['brand_name']) ?></td>
                            <td><?= htmlspecialchars($product['category_name']) ?></td>
                            <td>
                                <a href="index.php?route=admin/products/edit&id=<?= $product['product_id'] ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <button onclick="confirmDelete(<?= $product['product_id'] ?>)"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- PHÂN TRANG -->
        <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <!-- Nút Previous -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?route=admin/products&page=<?= $page - 1 ?>" aria-label="Previous">
                                &laquo;
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Các trang -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="index.php?route=admin/products&page=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Nút Next -->
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?route=admin/products&page=<?= $page + 1 ?>" aria-label="Next">
                                &raquo;
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>

    </div>

    <script>
        function confirmDelete(productId) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
                window.location.href = `index.php?route=admin/products/delete&id=${productId}`;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>