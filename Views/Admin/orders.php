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
                        <a class="nav-link" href="index.php?route=admin/orders">Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=admin/coupons">Quản lý mã giảm giá</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=admin/useradmin">Quản lý người dùng</a>
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
         
        <?php
            if (isset($_SESSION['success'])): ?>
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
            <h2>Danh sách Orders</h2>
           
        </div>

    <!-- <form method="GET" class="row g-3 mb-3">
        <input type="hidden" name="route" value="admin/products">

        <div class="col-md-3">
            <label class="form-label">Lọc theo chữ cái</label>
            <select name="letter" class="form-select">
                <option value="">Tất cả</option>
                <?php foreach (range('A', 'Z') as $char): ?>
                    <option value="<?= $char ?>" <?= ($_GET['letter'] ?? '') == $char ? 'selected' : '' ?>><?= $char ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Khoảng giá</label>
            <select name="price_range" class="form-select">
                <option value="">Tất cả</option>
                <option value="1" <?= ($_GET['price_range'] ?? '') == '1' ? 'selected' : '' ?>>Dưới 5 triệu</option>
                <option value="2" <?= ($_GET['price_range'] ?? '') == '2' ? 'selected' : '' ?>>5 - 10 triệu</option>
                <option value="3" <?= ($_GET['price_range'] ?? '') == '3' ? 'selected' : '' ?>>10 - 20 triệu</option>
                <option value="4" <?= ($_GET['price_range'] ?? '') == '4' ? 'selected' : '' ?>>Trên 20 triệu</option>
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Lọc</button>
        </div>
    </form> -->


        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User_id</th>
                        <th>Tên người nhận</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allOrders as $order): ?>
                        <tr>
                            <td><?= $order['order_id'] ?></td>
                            <td><?= $order['user_id'] ?></td>
                            <td><?= $order['customer_name'] ?></td>
                            <td><?= $order['phone'] ?></td>
                            <td><?= $order['shipping_address'] ?></td>
                            <td>
                                 <?php
                                            switch ($order['status']) {
                                                case 'Pending': echo '<span class="badge bg-secondary">🕒 Mới</span>'; break;
                                                case 'Shipped': echo '<span class="badge bg-info text-dark">✅ Đang vận</span>'; break;
                                                case 'Delivered': echo '<span class="badge bg-success">🏁 Hoàn tất</span>'; break;
                                                default: echo '<span class="badge bg-light text-dark">Không rõ</span>';
                                            }
                                        ?>
                            </td>
                            <td><?= number_format( $order['total_order'], 0, ',', '.') ?><b> VND</b></td>
                            <td><?= $order['date'] ?></td>
                            <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                                            <?php if ($order['status'] === 'Pending'): ?>
                                                <form action="index.php?route=admin/updateOrderStatus" method="POST">
                                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                    <input type="hidden" name="status" value="Pending">
                                                    <button type="submit" class="btn btn-sm btn-success">Duyệt</button>
                                                </form>
                                            <?php elseif ($order['status'] === 'Shipped'): ?>
                                                <form action="index.php?route=admin/updateOrderStatus" method="POST">
                                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                    <input type="hidden" name="status" value="Shipped">
                                                    <button type="submit" class="btn btn-sm btn-warning">Hoàn tất</button>
                                                </form>
                                            <?php endif; ?>

                                            <form method="POST" action="index.php?route=admin/updateOrderStatus" onsubmit="return confirm('Bạn có chắc muốn xóa đơn này?')">
                                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                <input type="hidden" name="status" value="Cancelled">
                                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- PHÂN TRANG -->


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