<?php
//SELECT o.order_id, o.Total_order, o.date, o.status, od.id, od.quantity, p.product_id, p.name, p.price FROM `order` o 
// JOIN `order_detail` od ON o.order_id = od.order_id 
// JOIN `product` p ON od.product_id = p.product_id 
// WHERE o.user_id = 1;
require_once './Controller/CartController.php';

?>

<div class="container my-5">
    <h2 class="text-center mb-4">Đơn hàng đã đặt</h2>
      <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

    <?php if (empty($all_orders)): ?>
        <div class="text-center py-5">
            <h4 class="text-muted mb-4">Đơn hàng của bạn đang trống</h4>
            <a href="index.php" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="row">
            <!-- Phần hiển thị sản phẩm -->
            <div class="col mb-4">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th style="width: 100px;">Số lượng</th>
                                <th style="width: 150px;">Thành tiền</th>
                                <th style="width: 150px;">Trạng thái</th>
                                <th style="width: 250px;">Ngày đặt hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                               
                                foreach ($all_orders as $key => $order): 
                            ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="./asset/images/<?= htmlspecialchars($order['product_img']) ?>" 
                                                 alt="<?= htmlspecialchars($order['name']) ?>"
                                                 class="rounded me-3" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0"><?= htmlspecialchars($order['name']) ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= number_format($order['price'], 0, ',', '.') ?> VND</td>
                                    <td>
                                        <span class="fw-bold"><?= $order['quantity'] ?></span>
                                    </td>
                                    <td class="text-end"><?= number_format($order['price'] * $order['quantity'] , 0, ',', '.') ?> VND</td>
                                    <td>
                                       <span class="fw-bold"><?= $order['status'] ?></span>
                                    </td>
                                    <td>
                                       <span class="fw-bold"><?= $order['date'] ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
        </div>
    <?php endif; ?>
</div>
