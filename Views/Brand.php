
<main class="container my-4">


    <h2 class="text-center mb-4"> Brand <?= htmlspecialchars($brand_current['brand_name']); ?></h2>
    <div class="row">
        <?php if (!empty($all_products)): ?>
            <?php foreach ($all_products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="./asset/images/<?php echo htmlspecialchars($product['product_img']); ?>"
                            class="card-img-top"
                            alt="<?php echo htmlspecialchars($product['Name']); ?>"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($product['Name']); ?>
                            </h5>
                            <p class="card-text text-success fw-bold">
                                Giá: <?php echo number_format($product['Price'], 0, ',', '.'); ?> VND
                            </p>
                            <p class="card-text text-muted">
                                <?php echo htmlspecialchars($product['Description']); ?>
                            </p>
                            <a href="index.php?route=add_to_cart&id=<?= $product['Product_ID']; ?>"
                                class="btn btn-primary mt-auto">
                                Thêm vào giỏ hàng
                            </a>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Hiện không có sản phẩm nào trong danh mục này.</p>
        <?php endif; ?>
    </div>
    <div>them</div>
</main>