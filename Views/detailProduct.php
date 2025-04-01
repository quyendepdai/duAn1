<div class="container mt-5">
    <div class="row">
        <!-- Ảnh sản phẩm -->
        <div class="col-md-5">
            <img style="height:250px;width:400px;   " src="./asset/images/<?= $detail_product['product_img'] ?>" class="img-fluid rounded shadow" alt="Tên sản phẩm">
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-7">
            <h2><?= $detail_product['Name'] ?></h2>
            <p class="text-muted">Mã sản phẩm: <strong><?= $detail_product['Product_ID'] ?></strong></p>
            <h4 class="text-success"><?= number_format($detail_product['Price'], 0, ',', '.'); ?> VND</h4>
            <p class="mt-3">
                <?= $detail_product['Description'] ?>
            </p>

            <a href="index.php?route=add_to_cart&id=<?= $detail_product['Product_ID']; ?>" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
            </a>

            <a href="index.php" class="btn btn-secondary mt-3">Quay lại</a>
        </div>
    </div>

    <!-- Mô tả chi tiết sản phẩm -->
    <hr>
</div>


<div class="container mt-4">
    <h3 class="mb-4">Sản phẩm tương tự</h3> 
    <div class="row">
        <?php $count = 0; ?>
        <?php foreach ($similar_product as $row) { ?>
            <div class="col-md-3 mb-3"> <!-- 4 sản phẩm mỗi hàng -->
                <div class="card">
                    <div class="card-body text-center">
                        <img src="./asset/images/<?= $row['product_img'] ?>" class="card-img-top" alt="">
                        <a style="text-decoration: none;color:black;hover{color:red}" href="index.php?route=detail_product&id=<?php echo $row['Product_ID']?>">
                            <h5 class="product-title"><?php echo htmlspecialchars($row['Name']);?></h5>
                            </a>
                        <div class="product-price">
                            <?= number_format($row['Price'], 0, ',', '.'); ?> VND
                        </div>
                         <a href="index.php?route=add_to_cart&id=<?= $detail_product['Product_ID']; ?>" class="btn btn-primary mt-3">
                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        <?php
            $count++;
            if ($count >= 4) break;
        } ?>
    </div>
</div>