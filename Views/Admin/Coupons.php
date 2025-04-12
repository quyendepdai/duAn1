<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý mã giảm giá</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
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
                        <a class="nav-link <?= $route == 'admin/coupons' ? 'active' : '' ?>"
                            href="index.php?route=admin/coupons">Quản lý mã giảm giá</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="index.php?route=logout" class="btn btn-outline-light me-2">Đăng xuất</a>
                    <a href="index.php" class="btn btn-outline-light">Trang chủ</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Quản lý mã giảm giá</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal">
                <i class="fas fa-plus"></i> Thêm mã giảm giá
            </button>
        </div>

        <!-- Thông báo -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Thêm mã giảm giá thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Có lỗi xảy ra khi thêm mã giảm giá!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Bảng hiển thị mã giảm giá -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Mã giảm giá</th>
                                <th>Số tiền giảm</th>
                                <th>Ngày hết hạn</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($coupons)) {
                                foreach ($coupons as $coupon) {
                                    $id = isset($coupon['Coupon_id']) ? $coupon['Coupon_id'] : '';
                                    $code = isset($coupon['Code']) ? $coupon['Code'] : '';
                                    $discount = isset($coupon['Discount_Amount']) ? $coupon['Discount_Amount'] : 0;
                                    $expiry = isset($coupon['Expiration_Date']) ? $coupon['Expiration_Date'] : '';
                            ?>
                                    <tr>
                                        <td><?= htmlspecialchars($id) ?></td>
                                        <td><?= htmlspecialchars($code) ?></td>
                                        <td><?= number_format($discount, 0, ',', '.') ?> VND</td>
                                        <td><?= date('d/m/Y', strtotime($expiry)) ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm"
                                                onclick="editCoupon(<?= $id ?>, '<?= $code ?>', <?= $discount ?>, '<?= $expiry ?>')">
                                                <i class="fas fa-edit"></i> Sửa
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deleteCoupon(<?= $id ?>)">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="5" class="text-center">Không có mã giảm giá nào</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm mã giảm giá -->
    <div class="modal fade" id="addCouponModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Thêm mã giảm giá mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php?route=admin/addCoupon" method="POST">
                        <div class="mb-3">
                            <label for="add_code" class="form-label">Mã giảm giá</label>
                            <input type="text" class="form-control" id="add_code" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_discount" class="form-label">Số tiền giảm (VND)</label>
                            <input type="number" class="form-control" id="add_discount" name="discount" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_expiry" class="form-label">Ngày hết hạn</label>
                            <input type="date" class="form-control" id="add_expiry" name="expiry" required>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sửa mã giảm giá -->
    <div class="modal fade" id="editCouponModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Sửa mã giảm giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php?route=admin/update_coupon" method="POST">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_code" class="form-label">Mã giảm giá</label>
                            <input type="text" class="form-control" id="edit_code" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_discount" class="form-label">Số tiền giảm (VND)</label>
                            <input type="number" class="form-control" id="edit_discount" name="discount" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_expiry" class="form-label">Ngày hết hạn</label>
                            <input type="date" class="form-control" id="edit_expiry" name="expiry" required>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-warning">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteCoupon(id) {
            Swal.fire({
                title: 'Xác nhận xóa?',
                text: "Bạn có chắc muốn xóa mã giảm giá này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?route=admin/delete_coupon&id=' + id;
                }
            });
        }

        function editCoupon(id, code, discount, expiry) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_discount').value = discount;
            document.getElementById('edit_expiry').value = expiry;

            var editModal = new bootstrap.Modal(document.getElementById('editCouponModal'));
            editModal.show();
        }
    </script>
</body>

</html>