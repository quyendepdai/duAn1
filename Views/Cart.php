<?php
require_once './Model/Coupon.php';
require_once './Controller/CartController.php';

 $subtotal = 0;

// Lấy danh sách mã giảm giá
$couponModel = new Coupon();
$available_coupons = $couponModel->getAllValidCoupons();
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Giỏ hàng của bạn</h2>
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
    <?php if (empty($carts)): ?>
    <div class="text-center py-5">
        <h4 class="text-muted mb-4">Giỏ hàng của bạn đang trống</h4>
        <a href="index.php" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
    </div>
    <?php else: ?>
    <div class="row">
        <!-- Phần hiển thị sản phẩm -->
        <div class="col-lg-8 mb-4">
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th style="width: 150px;">Giá</th>
                            <th style="width: 100px;">Số lượng</th>
                            <th style="width: 150px;">Thành tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                // echo('<pre>');
                                // print_r($userInfo);
                                // echo('</pre>');

                                foreach ($carts as $key => $cart): 
                                    $name = $cart['name'] ?? 'Không có tên';
                                    $price = (float)($cart['price'] ?? 0);
                                    $quantity = (int)($cart['quantity'] ?? 0);
                                    $image = $cart['product_img'] ?? 'default.jpg';
                                    $item_total = $price * $quantity;
                                    $subtotal += $item_total;
                            ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="./asset/images/<?= htmlspecialchars($image) ?>"
                                        alt="<?= htmlspecialchars($name) ?>" class="rounded me-3"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0"><?= htmlspecialchars($name) ?></h6>
                                    </div>
                                </div>
                            </td>
                            <td><?= number_format($price, 0, ',', '.') ?> VND</td>
                            <td>
                                <span class="fw-bold"><?= $quantity ?></span>
                            </td>
                            <td class="text-end"><?= number_format($item_total, 0, ',', '.') ?> VND</td>
                            <td>
                                <button onclick="removeItem(<?= $cart['product_id'] ?>)"
                                    class="btn btn-link text-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Phần tổng thanh toán -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Tổng thanh toán</h5>

                    <!-- Mã giảm giá -->
                    <div class="mb-4">
                        <form action="index.php?route=apply_coupon" method="POST" class="mb-3">
                            <div class="input-group">
                                <select name="coupon_code" class="form-select">
                                    <option value="">Chọn mã giảm giá</option>
                                    <?php foreach($available_coupons as $coupon): ?>
                                    <option value="<?= htmlspecialchars($coupon['Code']) ?>">
                                        <?= htmlspecialchars($coupon['Code']) ?>
                                        (Giảm <?= number_format($coupon['Discount_Amount'], 0, ',', '.') ?> VND)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-success">Áp dụng</button>
                            </div>
                        </form>
                    </div>

                    <!-- Chi tiết thanh toán -->
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span><?= number_format($subtotal, 0, ',', '.') ?> VND</span>
                        </div>
                        <?php 
                            $discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;
                            if ($discount > 0): 
                            ?>
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Giảm giá:</span>
                            <span>-<?= number_format($discount, 0, ',', '.') ?> VND</span>
                        </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
                            <span>Tổng tiền:</span>
                            <span class="text-primary"><?= number_format($subtotal - $discount, 0, ',', '.') ?>
                                VND</span>
                        </div>
                    </div>

                    <!-- Nút thanh toán -->
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary w-100 mb-2" onclick="showCheckoutModal()">
                            Thanh toán ngay
                        </button>
                        <a href="index.php" class="btn btn-outline-secondary w-100">
                            Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Thanh toán -->
<div class="modal fade" id="checkoutModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Thông tin thanh toán</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?route=add_new_order" id="checkoutForm" method="post">
                    <!-- Thông tin khách hàng -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= $userInfo['Name'] ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                value="<?= $userInfo['Phone'] ?>">
                        </div>
                    </div>

                    <!-- Địa chỉ giao hàng -->
                    <div class="mb-4">
                        <h6 class="mb-3">Địa chỉ giao hàng</h6>
                        <div class="row">
                            <div class="col mb-3">
                                <input type="text" class="form-control" id="address" name="address"
                                    value="<?= $userInfo['Address'] ?>">
                            </div>
                        </div>

                    </div>
                    <!-- Phương thức thanh toán -->
                    <div class="mb-4">
                        <h6 class="mb-3">Phương thức thanh toán</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="cod"
                                value="cash_on_delivery" checked>
                            <label class="form-check-label" for="cod">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="banking"
                                value="bank_transfer">
                            <label class="form-check-label" for="banking">
                                Chuyển khoản ngân hàng
                            </label>
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>

                    <input type="hidden" id="totalMoney" name="totalMoney" value="<?=  $subtotal ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Xác nhận đặt hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showCheckoutModal() {
    const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
    checkoutModal.show();

}


function removeItem(productId) {
    Swal.fire({
        title: 'Xác nhận xóa',
        text: "Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `index.php?route=remove_from_cart&id=${productId}`;
        }
    });
}

function validateorder() {
    const name = document.getElementById('name').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');

    const phonename = /^[0-9]{9,11}$/;

    if (!name || !phone || !address || !paymentMethod) {
        Swal.fire('Lỗi', 'Vui lòng nhập đầy đủ các thông tin', 'error');
        return false;
    }

    if (!phonename.test(phone)) {
        Swal.fire('Lỗi', 'Số điện thoại không hợp lệ. Chỉ được phép chứa số từ 9 đến 11 chữ số.', 'error');
        return false;
    }
    // if (!phone) {
    //     Swal.fire('Lỗi', 'Vui lòng nhập số điện thoại', 'error');
    //     return false;
    // }


    // if (!address) {
    //     Swal.fire('Lỗi', 'Vui lòng nhập địa chỉ giao hàng', 'error');
    //     return false;
    // }

    // if (!paymentMethod) {
    //     Swal.fire('Lỗi', 'Vui lòng chọn phương thức thanh toán', 'error');
    //     return false;
    // }
    return true;
}
document.getElementById('checkoutForm').onsubmit = validateorder;
</script>