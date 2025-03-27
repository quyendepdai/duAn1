<?php
require_once './Model/Coupon.php';
require_once './Controller/CartController.php';

// Khởi tạo biến tổng tiền
$subtotal = 0;
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Lấy danh sách mã giảm giá
$couponModel = new Coupon();
$available_coupons = $couponModel->getAllValidCoupons();
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Giỏ hàng của bạn</h2>
    
    <?php if (empty($cart)): ?>
        <div class="text-center py-5">
            <h4 class="text-muted mb-4">Giỏ hàng của bạn đang trống</h4>
            <a href="index.php" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="row">
            <!-- Phần hiển thị sản phẩm -->
            <div class="col-lg-8 mb-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $product_id => $product): 
                                $name = $product['name'] ?? 'Không có tên';
                                $price = (float)($product['price'] ?? 0);
                                $quantity = (int)($product['quantity'] ?? 0);
                                $image = $product['img'] ?? 'default.jpg';
                                $item_total = $price * $quantity;
                                $subtotal += $item_total;
                            ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="./asset/images/<?= htmlspecialchars($image) ?>" 
                                                 alt="<?= htmlspecialchars($name) ?>"
                                                 class="rounded me-3" 
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
                                        <button onclick="removeItem(<?= $product_id ?>)" 
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
                                <span class="text-primary"><?= number_format($subtotal - $discount, 0, ',', '.') ?> VND</span>
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
                <form id="checkoutForm">
                    <!-- Thông tin khách hàng -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="fullName" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fullName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" required>
                        </div>
                    </div>

                    <!-- Địa chỉ giao hàng -->
                    <div class="mb-4">
                        <h6 class="mb-3">Địa chỉ giao hàng</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="province" class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="province" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="district" class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="district" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ward" class="form-label">Phường/Xã <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ward" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ cụ thể <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" required>
                        </div>
                    </div>

                    <!-- Phương thức thanh toán -->
                    <div class="mb-4">
                        <h6 class="mb-3">Phương thức thanh toán</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="banking" value="banking">
                            <label class="form-check-label" for="banking">
                                Chuyển khoản ngân hàng
                            </label>
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="note" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="submitOrder()">Xác nhận đặt hàng</button>
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

function submitOrder() {
    Swal.fire({
        title: 'Đặt hàng thành công!',
        text: 'Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất!',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?route=clear_cart';
        }
    });
}
</script>