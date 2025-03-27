<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4">Đăng Ký Tài Khoản</h2>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error']; ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    <form action="index.php?route=register" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input type="text" class="form-control" id="username" name="username" >
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" >
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu:</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                </div>
                <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="d-grid">
                        <button type="submit" class="btn btn-success">Đăng Ký</button>
                    </div>
                     <div class="d-flex gap-2 mt-2">
                          <a href="index.php?route=login"  style="width:50%" class="btn btn-primary">Đăng Nhập</a>
                        <a href="index.php" style="width:50%"  style="width:50%" class="btn btn-primary">Trang chủ</a>
                    </div>
                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>