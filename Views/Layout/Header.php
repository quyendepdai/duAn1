<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($all_brands) || !is_array($all_brands)) {
    $all_brands = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECH MART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css">
    <link rel="stylesheet" href="./asset/css/style.css">
    <style>
        .navbar-nav .nav-link {
            white-space: nowrap;
            padding: 8px 15px;
        }

        .navbar .container {
            max-width: 1400px;
        }

        .search-form {
            width: auto;
            min-width: 200px;
            max-width: 300px;
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                padding: 10px 0;
            }

            .search-form {
                width: 100%;
                max-width: none;
                margin: 10px 0;
            }

            .user-actions {
                flex-direction: column;
                align-items: stretch !important;
                gap: 10px;
                margin-top: 10px;
            }

            .user-actions .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="bg-warning py-2 text-center">
        <span class="fw-bold">Chào mừng bạn đến với TechMart!!!</span>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="index.php?controller=home">TECH MART</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="index.php">Home</a>
                    </li>
                    <?php 
                        $first_four = isset($all_brands) && is_array($all_brands) ? array_slice($all_brands, 0, 6) : []; 
                        foreach ($first_four as $c): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" href="index.php?route=brand&brand_id=<?= $c['brand_id'] ?>">
                                <?= htmlspecialchars($c['brand_name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="index.php?route=contact">Contact</a>
                    </li>
                </ul>

                <form class="search-form d-flex me-3" action="index.php" method="GET">
                    <input type="hidden" name="route" value="search">
                    <input class="form-control me-2" type="search" name="query"
                        placeholder="Tìm kiếm sản phẩm" required>
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <div class="user-actions d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="me-3 text-nowrap">Xin chào,
                            <a href="index.php?route=admin/products"><button class="btn btn-outline-primary"><strong><?php echo htmlspecialchars($_SESSION['username'] ?? 'Người dùng'); ?></strong></button></a>
                        </span>
                        <a href="index.php?route=logout" class="btn btn-outline-danger me-2">Đăng xuất</a>
                    <?php else: ?>
                        <a href="index.php?route=login" class="btn btn-outline-primary me-2">Đăng nhập</a>
                    <?php endif; ?>

                    <a href="<?= isset($_SESSION['user_id']) ? 'index.php?route=cart' : 'index.php?route=login' ?>" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="ms-1">
                            <?= isset($countCartByUser) ? '('.$countCartByUser.')'  : null ; ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <button id="backToTop" class="btn btn-primary"
        style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 1050;">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>