<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Danh Mục - TECH-MART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container ">
   
    <h2 class="mb-4 ">Sửa mã giảm giá</h2>
    <div class="card shadow-sm ">
        <div class="card-body">
            <form action="index.php?route=admin/update_coupon" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($coupon['Coupon_id']) ?>">
                <div class="mb-3">
                    <label for="code" class="form-label">Mã giảm giá</label>
                    <input type="text" class="form-control" id="code" name="code" required 
                           value="<?= htmlspecialchars($coupon['Code']) ?>">
                </div>
                <div class="mb-3">
                    <label for="discount" class="form-label">Số tiền giảm (VND)</label>
                    <input type="number" class="form-control" id="discount" name="discount" required
                           value="<?= htmlspecialchars($coupon['Discount_Amount']) ?>">
                </div>
                <div class="mb-3">
                    <label for="expiry" class="form-label">Ngày hết hạn</label>
                    <input type="date" class="form-control" id="expiry" name="expiry" required
                           value="<?= htmlspecialchars($coupon['Expiration_Date']) ?>">
                </div>
                <div class="text-end">
                    <a href="index.php?route=admin/coupons" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>