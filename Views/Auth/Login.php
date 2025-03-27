<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4">Đăng nhập</h2>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['error']; ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="index.php?route=login">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Đăng nhập</button>
                        </div>
                        <div class="mt-3 text-center d-flex gap-2 ">
                            <a href="index.php?route=register" style="width:50%" class="btn btn-primary">Đăng ký</a>
                            <a href="index.php" style="width:50%" class="btn btn-primary">Trang chủ</a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>