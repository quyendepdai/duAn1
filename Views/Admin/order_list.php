<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($all_brands) || !is_array($all_brands)) $all_brands = [];
?>

<!-- HEADER -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng - TECH MART</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .navbar-nav .nav-link { white-space: nowrap; padding: 8px 15px; }
        .navbar .container { max-width: 1400px; }
        .search-form { width: auto; min-width: 200px; max-width: 300px; }
        @media (max-width: 991.98px) {
            .navbar-nav { padding: 10px 0; }
            .search-form { width: 100%; max-width: none; margin: 10px 0; }
            .user-actions { flex-direction: column; align-items: stretch !important; gap: 10px; margin-top: 10px; }
            .user-actions .btn { width: 100%; }
        }
    </style>
</head>

<body>
    <div class="bg-warning py-2 text-center">
        <span class="fw-bold">Chào mừng bạn đến với TechMart!!!</span>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="index.php">TECH MART</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link fw-bold" href="index.php">Home</a></li>
                    <?php foreach (array_slice($all_brands, 0, 6) as $c): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="index.php?route=brand&brand_id=<?= $c['brand_id'] ?>">
                                <?= htmlspecialchars($c['brand_name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li class="nav-item"><a class="nav-link fw-bold" href="index.php?route=contact">Contact</a></li>
                </ul>

                <form class="search-form d-flex me-3" action="index.php" method="GET">
                    <input type="hidden" name="route" value="search">
                    <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm sản phẩm" required>
                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                </form>

                <div class="user-actions d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="me-3 text-nowrap">Xin chào, 
                            <a href="index.php?route=admin/products">
                                <button class="btn btn-outline-primary"><strong><?= htmlspecialchars($_SESSION['username'] ?? 'Người dùng'); ?></strong></button>
                            </a>
                        </span>
                        <a href="index.php?route=logout" class="btn btn-outline-danger me-2">Đăng xuất</a>
                    <?php else: ?>
                        <a href="index.php?route=login" class="btn btn-outline-primary me-2">Đăng nhập</a>
                    <?php endif; ?>
                    <a href="<?= isset($_SESSION['user_id']) ? 'index.php?route=cart' : 'index.php?route=login' ?>" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="ms-1"><?= isset($countCartByUser) ? '('.$countCartByUser.')' : '' ?></span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

<!-- MAIN -->
<div class="container my-5">
    <h2 class="text-center text-primary fw-bold mb-4">📦 Danh sách đơn hàng</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (!empty($orders)): ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>👤 Khách hàng</th>
                                <th>📞 SĐT</th>
                                <th>📍 Địa chỉ</th>
                                <th>📝 Ghi chú</th>
                                <th>📊 Trạng thái</th>
                                <th>⚙️ Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <?php $status = (int)($order['status'] ?? 0); ?>
                                <tr>
                                    <td class="fw-bold"><?= $order['order_id'] ?? '' ?></td>
                                    <td><?= htmlspecialchars($order['customer_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($order['phone'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($order['address'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($order['note'] ?? '') ?></td>
                                    <td>
                                        <?php
                                            switch ($status) {
                                                case 0: echo '<span class="badge bg-secondary">🕒 Mới</span>'; break;
                                                case 1: echo '<span class="badge bg-info text-dark">✅ Đã duyệt</span>'; break;
                                                case 2: echo '<span class="badge bg-success">🏁 Hoàn tất</span>'; break;
                                                default: echo '<span class="badge bg-light text-dark">Không rõ</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                                            <?php if ($status === 0): ?>
                                                <form action="index.php?route=admin/updateOrderStatus" method="POST">
                                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                    <input type="hidden" name="status" value="1">
                                                    <button type="submit" class="btn btn-sm btn-success">Duyệt</button>
                                                </form>
                                            <?php elseif ($status === 1): ?>
                                                <form action="index.php?route=admin/updateOrderStatus" method="POST">
                                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                    <input type="hidden" name="status" value="2">
                                                    <button type="submit" class="btn btn-sm btn-warning">Hoàn tất</button>
                                                </form>
                                            <?php endif; ?>

                                            <form method="POST" action="index.php?route=admin/deleteOrder" onsubmit="return confirm('Bạn có chắc muốn xóa đơn này?')">
                                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center text-muted py-5">
            <h5>Không có đơn hàng nào.</h5>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
