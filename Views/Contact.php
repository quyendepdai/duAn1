<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-4">Liên hệ với chúng tôi</h2>
            <div class="mb-4">
                <h5>Địa chỉ:</h5>
                <p>Can Lộc, Hà Tĩnh</p>
            </div>
            <div class="mb-4">
                <h5>Số điện thoại:</h5>
                <p><a href="tel:0123456789" class="text-decoration-none">0705 205 205</a></p>
            </div>
            <div class="mb-4">
                <h5>Email:</h5>
                <p><a href="HFood@gmail.com" class="text-decoration-none">HFood@gmail.com</a></p>
            </div>
            <div class="mb-4">
                <h5>Giờ làm việc:</h5>
                <p>Thứ 2 - Chủ nhật: 10:00 - 24:00</p>
            </div>
            <div class="mb-4">
                <h5>Mạng xã hội:</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="text-decoration-none">
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>
                    <a href="#" class="text-decoration-none">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    <a href="#" class="text-decoration-none">
                        <i class="fab fa-twitter fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h2 class="mb-4">Gửi tin nhắn cho chúng tôi</h2>
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="name" required value="<?= $userInfo['Name'] ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required value="<?= $userInfo['Email'] ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" id="phone" value="<?= $userInfo['Phone'] ?>">
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Chủ đề</label>
                    <input type="text" class="form-control" id="subject">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Nội dung tin nhắn</label>
                    <textarea class="form-control" id="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
            </form>
        </div>
    </div>

    <div class="mt-5">
        <h2 class="mb-4">Bản đồ</h2>
        <div class="ratio ratio-16x9">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3424.805713338313!2d105.64691607465082!3d18.4594779710387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3139b71d1a47df01%3A0x39cd466a15db32e7!2sHo%C3%A0ng%20Elkun!5e1!3m2!1svi!2s!4v1733149992763!5m2!1svi!2s"
                style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">