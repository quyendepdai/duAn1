<!-- Slideshow LAPTOP -->
<div id="mainBanner" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img  src="./asset/images/banner.jpg" class="d-block w-100 banner" style="height: 500px; width: 100%; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="./asset/images/banner1.jpg" class="d-block w-100 banner" alt="Banner 2" style="height: 500px; width: 100%; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="./asset/images/banner2.jpg" class="d-block w-100 banner" alt="Banner 3" style="height: 500px; width: 100%; object-fit: cover;">
            
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainBanner" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainBanner" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Danh mục HÃNG LAPTOP -->
<style>

.section-title {    
    position: relative;
    margin-bottom: 2rem;
}
.title-decoration {
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
}
.title-decoration::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #00c6ff);
}
/* Category Container */
.category-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
    padding: 20px 0;
}
.category-link {
    text-decoration: none;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.5s ease forwards;
}
.category-button {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 25px;
    background: white;
    border: 2px solid #007bff;
    border-radius: 50px;
    color: #007bff;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 123, 255, 0.1);
}
.category-icon {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}
.category-name {
    font-size: 1rem;
}
.category-button:hover {
    background: linear-gradient(45deg, #007bff, #00c6ff);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}
.category-button:hover .category-icon {
    transform: rotate(360deg);
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
.category-link:nth-child(1) { animation-delay: 0.1s; }
.category-link:nth-child(2) { animation-delay: 0.2s; }
.category-link:nth-child(3) { animation-delay: 0.3s; }
.category-link:nth-child(4) { animation-delay: 0.4s; }
.category-link:nth-child(5) { animation-delay: 0.5s; }
@media (max-width: 768px) {
    .category-button {
        padding: 10px 20px;
    }
    .category-name {
        font-size: 0.9rem;
    }
    .category-icon {
        font-size: 1rem;
    }
}
@media (max-width: 576px) {
    .category-container {
        gap: 10px;
    }    
    .category-button {
        padding: 8px 16px;
    }   
    .title-decoration::after {
        width: 60px;
    }
}
@media (hover: none) {
    .category-button:active {
        background: linear-gradient(45deg, #007bff, #00c6ff);
        color: white;
        transform: translateY(-3px);
    }
}
 </style>
<section class="category-section container mb-5">
    <h3 class="section-title text-center mb-4">
        <span class="title-decoration">DANH MỤC SẢN PHẨM</span>
    </h3>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="category-container">

                <?php 
                    
                foreach ($all_category as $category): ?>
                    <a href="index.php?route=category&category_id=<?= $category['category_id'] ?>" 
                       class="category-link">
                        <div class="category-button">
                            <span class="category-name"><?= htmlspecialchars($category['Name']) ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- CÁC SẢN PHẨM NỔI BẬT -->
 <style>
.featured-section {
    padding: 40px 0;
}

.product-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    margin-bottom: 20px;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.product-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(45deg, #ff6b6b, #ff8787);
    color: white;
    padding: 8px 15px;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
    animation: pulse 2s infinite;
}
.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}
.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.product-card:hover .product-image img {
    transform: scale(1.1);
}
.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: all 0.3s ease;
}
.product-card:hover .product-overlay {
    opacity: 1;
}
.cart-btn {
    width: 45px;
    height: 45px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #007bff;
    font-size: 1.2rem;
    transform: translateY(20px);
    transition: all 0.3s ease;
}
.product-card:hover .cart-btn {
    transform: translateY(0);
}
.cart-btn:hover {
    background: #007bff;
    color: white;
}
.product-details {
    padding: 20px;
}
.product-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}
.product-price {
    color: #28a745;
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 15px;
}
.add-to-cart-btn {
    display: block;
    width: 100%;
    padding: 12px;
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    text-align: center;
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.3s ease;
    transform: translateY(5px);
    opacity: 0;
}
.product-card:hover .add-to-cart-btn {
    transform: translateY(0);
    opacity: 1;
}
.add-to-cart-btn:hover {
    background: linear-gradient(45deg, #0056b3, #004094);
    color: white;
}
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .col-md-3 {
        width: 50%;
    }
}

@media (max-width: 576px) {
    .col-md-3 {
        width: 100%;
    }
    
    .product-card {
        max-width: 320px;
        margin: 0 auto 20px;
    }
    
    .product-title {
        font-size: 1rem;
    }
    
    .product-price {
        font-size: 1.1rem;
    }
}

 </style>
<section class="featured-section container mb-5">
    <h2 class="section-title text-center mb-5">
        <span class="title-decoration">SẢN PHẨM NỔI BẬT</span>
    </h2>
    <div class="row">
        <?php 
        $products_copy = $all_products;
        shuffle($products_copy);
        $featured_products = array_slice($products_copy, 0, 4);
        foreach ($featured_products as $index => $product): 
        ?>
            <div class="col-md-3 mb-4">
                <div class="product-card" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="product-badge">Hot</div>
                    <div class="product-image">
                        <img src="./asset/images/<?= htmlspecialchars($product['product_img']); ?>"
                             alt="<?= htmlspecialchars($product['name']); ?>">
                        <div class="product-overlay">
                            <a href="index.php?route=add_to_cart&id=<?= $product['product_id']; ?>"
                               class="cart-btn">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-details">
                    <a style="text-decoration: none;color:black;hover{color:red}" href="index.php?route=detail_product&id=<?= $product['product_id'] ?>">
                            <h5 class="product-title"><?= htmlspecialchars($product['name']); ?></h5>
                        </a>
                        <div class="product-price">
                            <?= number_format($product['price'], 0, ',', '.'); ?> VND
                        </div>

                        <?php 
                            if(isset($_SESSION['user_id'])):
                        ?>
                        <a href="index.php?route=add_to_cart&id=<?= $product['product_id']; ?>"
                           class="add-to-cart-btn">
                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                        </a>
                        <?php 
                            else:
                        ?>
                        <a href="index.php?route=login"
                           class="add-to-cart-btn">
                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                        </a>
                        <?php 
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- TẤT CẢ SẢN PHẨM -->
<main class="container mb-5">
    <h2 class="text-center mb-4">Danh Sách Sản Phẩm </h2>
    <div class="row">
        
        <?php 
        foreach ($all_products as $product): ?>
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
                        <p class="card-text text-muted small">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>
                        <a href="index.php?route=add_to_cart&id=<?= $product['product_id']; ?>"
                            class="btn btn-primary mt-auto">
                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<!-- Phân trang sản phẩm -->
<div class="container mb-5">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">

            <!-- Nút Previous -->
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Các số trang -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="index.php?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Nút Next -->
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>
</div>

<!-- Thông tin dịch vụ -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 text-center">
                <i class="fas fa-motorcycle fa-3x mb-3 text-primary"></i>
                <h5>Giao hàng nhanh</h5>
                <p class="text-muted">2H-5H có ngay</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-headset fa-3x mb-3 text-primary"></i>
                <h5>Hỗ trợ 24/7</h5>
                <p class="text-muted">Hotline: 0705 205 644</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-wallet fa-3x mb-3 text-primary"></i>
                <h5>Thanh toán dễ dàng</h5>
                <p class="text-muted">Tiền mặt/Chuyển khoản</p>
            </div>
        </div>
    </div>
</section>