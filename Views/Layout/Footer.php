<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('shadow-scroll');
        } else {
            navbar.classList.remove('shadow-scroll');
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        var backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 200) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <!-- Phần thông tin chung -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>TECH MART</h5>
                <p>CỬA HÀNG CÔNG NGHỆ UY TÍN SỐ 1 VIỆT NAM</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Liên hệ</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt me-2"></i>FLC HH3.2 ĐẠI MỖ, NAM TỪ LIÊM, Hà NỘI</li>
                    <li><i class="fas fa-phone me-2"></i>Hotline: 0876 77 1802</li>
                    <li><i class="fas fa-envelope me-2"></i>Email: TECHMART@gmail.com</li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Theo dõi chúng tôi</h5>
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-outline-light btn-sm me-2">
                        <i class="fab fa-facebook-f"><i class="fa fa-facebook" aria-hidden="true"></i></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm me-2">
                        <i class="fab fa-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm me-2">
                        <i class="fab fa-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></i>
                    </a>
                </div>
            </div>
        </div>
        <hr class="bg-secondary">
        <p class="mb-0">© 2025 TECHMART. All rights reserved.</p>
    </div>
</footer>