<div class="container my-5">
    <h2 class="mb-4">Kết quả tìm kiếm cho "<?php echo htmlspecialchars($query); ?>"</h2>
    <div class="row">
        <?php if (empty($results)): ?>
            <p>Không tìm thấy sản phẩm nào.</p>
        <?php else: ?>

            <?php foreach ($results as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="./asset/images/<?php echo htmlspecialchars($product['product_img']); ?>"
                            class="card-img-top"
                            alt="<?php echo htmlspecialchars($product['name']); ?>"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <a style="text-decoration: none;color:black;hover{color:red}" href="index.php?route=detail_product&id=<?= $product['product_id'] ?>">
                                <h5 class="product-title"><?= htmlspecialchars($product['name']); ?></h5>
                            </a>
                            <p class="card-text text-success fw-bold">
                                <?php echo number_format($product['price'], 0, ',', '.'); ?> VND
                            </p>
                            <a href="index.php?route=add_to_cart&id=<?= $product['product_id']; ?>" 
                               class="btn btn-primary mt-auto">
                                <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div>
    hello
</div>