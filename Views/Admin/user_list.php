<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng - TECH-MART</title>
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

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Danh sách người dùng</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['User_id'] ?></td>
                    <td><?= $user['Username'] ?></td>
                    <td><?= $user['Email'] ?></td>
                    <td>
                        <form method="post" action="index.php?route=admin/change_role"
                              onsubmit="return confirm('Bạn có chắc muốn thay đổi vai trò người dùng này không?')">
                            <input type="hidden" name="id" value="<?= $user['User_id'] ?>">
                            <select name="role" class="form-select" onchange="this.form.submit()">
                                <option value="user" <?= $user['Role'] === 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $user['Role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="index.php?route=admin/delete_user&id=<?= $user['User_id'] ?>"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')"
                           class="btn btn-sm btn-danger">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
