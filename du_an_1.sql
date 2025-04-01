-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2025 at 08:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `du_an_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int NOT NULL,
  `brand_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `created_at`) VALUES
(1, 'Apple', '2025-03-20 02:59:09'),
(2, 'Asus', '2025-03-20 02:59:09'),
(3, 'Dell', '2025-03-20 02:59:09'),
(4, 'HP', '2025-03-20 02:59:09'),
(5, 'Lenovo', '2025-03-20 02:59:09'),
(6, 'Acer', '2025-03-20 02:59:09'),
(7, 'MSI', '2025-03-20 02:59:09'),
(8, 'Razer', '2025-03-20 02:59:09'),
(9, 'Microsoft', '2025-03-20 02:59:09'),
(10, 'Samsung', '2025-03-20 02:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(11, 4, 18, 2, '2025-03-28 23:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `description`, `Name`, `create_at`) VALUES
(1, 'Laptop chuyên dụng cho gaming, hiệu suất cao, card đồ họa mạnh', 'Gaming', '2025-03-20 03:08:46'),
(2, 'Laptop mỏng nhẹ, thời lượng pin dài, phù hợp cho di chuyển', 'Ultrabook', '2025-03-20 03:08:46'),
(3, 'Laptop dành cho công việc chuyên nghiệp, hiệu suất cao', 'Workstation', '2025-03-20 03:08:46'),
(4, 'Laptop có thể gập 360 độ hoặc tháo rời màn hình để dùng như tablet', '2-in-1', '2025-03-20 03:08:46'),
(5, 'Laptop dành cho doanh nhân, bền bỉ, bảo mật cao', 'Business', '2025-03-20 03:08:46'),
(6, 'Laptop phù hợp cho học sinh, sinh viên, giá thành hợp lý', 'Student', '2025-03-20 03:08:46'),
(7, 'Laptop giá rẻ, cấu hình cơ bản cho nhu cầu thông thường', 'Budget', '2025-03-20 03:08:46'),
(8, 'Laptop dành cho thiết kế đồ họa, chỉnh sửa video, hiệu năng mạnh', 'Creator', '2025-03-20 03:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `Coupon_id` int NOT NULL,
  `Code` varchar(50) DEFAULT NULL,
  `Discount_Amount` decimal(10,2) DEFAULT NULL,
  `Expiration_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`Coupon_id`, `Code`, `Discount_Amount`, `Expiration_Date`) VALUES
(1, 'SUMMER2025', '20000.00', '2025-08-21'),
(2, 'DISCOUNT20', '20000.00', '2025-12-01'),
(3, 'NEWCUSTOMER', '20000.00', '2025-03-25');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_id` int NOT NULL,
  `discount_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `discount_type` enum('percentage','fixed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int NOT NULL,
  `product_id` int NOT NULL,
  `stock_quantity` int DEFAULT '0',
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `Order_id` int NOT NULL,
  `User_id` int DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Total_order` bigint DEFAULT NULL,
  `Status` enum('Pending','Shipped','Delivered','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Pending',
  `coupon_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`Order_id`, `User_id`, `Date`, `Total_order`, `Status`, `coupon_id`) VALUES
(6, 1, '2025-03-30 07:36:23', 109490000, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `ID` int NOT NULL,
  `Order_id` int DEFAULT NULL,
  `Product_ID` int DEFAULT NULL,
  `Quantity` int DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`ID`, `Order_id`, `Product_ID`, `Quantity`, `Price`) VALUES
(15, 6, 2, 1, '15500000.00'),
(16, 6, 10, 1, '39990000.00'),
(17, 6, 18, 2, '27000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int NOT NULL,
  `order_id` int NOT NULL,
  `payment_method` enum('credit_card','paypal','bank_transfer','cash_on_delivery') NOT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `transaction_id` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'xxxxxxxxx',
  `payment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `payment_status`, `transaction_id`, `payment_date`) VALUES
(6, 6, 'cash_on_delivery', 'pending', 'xxxxxxxxx', '2025-03-30 07:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0',
  `Description` text,
  `product_img` varchar(100) DEFAULT NULL,
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Name`, `brand_id`, `Price`, `stock_quantity`, `Description`, `product_img`, `category_id`) VALUES
(2, 'Asus Vivobook Go 15 E1504FA R5 7520U (NJ776W) 123', 2, '15500000.00', 0, 'Laptop gaming mỏng nhẹ hàng đầu Việt Nam ASUS ROG Zephyrus G14, G15, G16, M16, Duo 16, AMD Ryzen 9, Intel 13, RTX 4080, Anime Matrix, màn 4K chính hãng giá tốt nhất.', '1.jpg', 1),
(3, 'MSI Modern 15 B12MO i5 1235U (628VN)', 7, '12890000.00', 0, 'Các sản phẩm của MSI thường có thiết kế mạnh mẽ và hiện đại, đặc biệt là dòng sản phẩm game với các đèn RGB và các yếu tố thẩm mỹ thể thao điện tử (e-sports). Các máy tính xách tay thường có các tính năng tối ưu như tản nhiệt cải tiến, bàn phím có đèn nền, và màn hình chất lượng cao.', '6.jpg', 2),
(4, 'Dell Inspiron 15 3520 i5 1235U (N5I5057W1)', 3, '13000000.00', 0, 'Asus luôn chú trọng vào việc phát triển các công nghệ mới, như màn hình OLED, hệ thống tản nhiệt tiên tiến, và các tính năng chơi game độc đáo.', '3.jpg', 4),
(6, 'MSI Modern 15 F13MG i5 1335U (082VN)', 7, '14690000.00', 0, 'Các sản phẩm của MSI thường có thiết kế mạnh mẽ và hiện đại, đặc biệt là dòng sản phẩm game với các đèn RGB và các yếu tố thẩm mỹ thể thao điện tử (e-sports). Các máy tính xách tay thường có các tính năng tối ưu như tản nhiệt cải tiến, bàn phím có đèn nền, và màn hình chất lượng cao.', '5.jpg', 2),
(7, 'MacBook Air 13 inch M3 16GB/512GB', 1, '30690000.00', 0, 'MacBook Air có thiết kế mỏng nhẹ, cực kỳ di động, phù hợp với những người cần một chiếc máy tính xách tay dễ mang theo.', '7.jpg', 1),
(8, 'MacBook Air 13 inch M2 16GB/512GB/10GPU', 1, '27900000.00', 0, 'MacBook Air có thiết kế mỏng nhẹ, cực kỳ di động, phù hợp với những người cần một chiếc máy tính xách tay dễ mang theo.', '8.jpg', 3),
(9, 'MacBook Air 13 inch M3 16GB/256GB', 1, '26590000.00', 0, 'MacBook Air có thiết kế mỏng nhẹ, cực kỳ di động, phù hợp với những người cần một chiếc máy tính xách tay dễ mang theo.', '1a.jpg', 3),
(10, 'MacBook Pro 14 inch M4 16GB/512GB', 1, '39990000.00', 0, 'MacBook Air có thiết kế mỏng nhẹ, cực kỳ di động, phù hợp với những người cần một chiếc máy tính xách tay dễ mang theo.', '2a.jpg', 3),
(11, 'MacBook Air 15 inch M3 16GB/256GB/10GPU', 1, '30790000.00', 0, 'MacBook Air có thiết kế mỏng nhẹ, cực kỳ di động, phù hợp với những người cần một chiếc máy tính xách tay dễ mang theo.', '3a.jpg', 3),
(12, 'Asus Gaming Vivobook K3605ZF i5 12500H (RP745W)', 2, '17690000.00', 0, 'Asus luôn chú trọng vào việc phát triển các công nghệ mới, như màn hình OLED, hệ thống tản nhiệt tiên tiến, và các tính năng chơi game độc đáo.', '4a.jpg', 1),
(13, 'Asus TUF Gaming F15 FX507ZC4 i5 12500H', 2, '20190000.00', 0, 'Asus luôn chú trọng vào việc phát triển các công nghệ mới, như màn hình OLED, hệ thống tản nhiệt tiên tiến, và các tính năng chơi game độc đáo.', '1s.jpg', 1),
(14, 'Asus TUF Gaming A15 FA506NFR R7 7435HS', 2, '18390000.00', 0, 'Asus luôn chú trọng vào việc phát triển các công nghệ mới, như màn hình OLED, hệ thống tản nhiệt tiên tiến, và các tính năng chơi game độc đáo. 123', '2s.jpg', 1),
(15, 'MSI Gaming Katana 15 B13UDXK i7 13620H (2077VN)', 7, '23690000.00', 0, 'MSI đặc biệt nổi bật trong cộng đồng game thủ nhờ vào các sản phẩm hiệu năng cao, thiết kế đặc trưng, và tính năng tối ưu cho việc chơi game', '1sa.jpg', 2),
(16, 'MSI Gaming Thin 15 B13UCX i5 13420H (2080VN)', 7, '17690000.00', 0, 'MSI đặc biệt nổi bật trong cộng đồng game thủ nhờ vào các sản phẩm hiệu năng cao, thiết kế đặc trưng, và tính năng tối ưu cho việc chơi game', '2s.jpg', 2),
(18, 'MSI Prestige 14 AI Studio C1UDXG Ultra 7 155H (058VN)', 7, '27000000.00', 0, 'MSI đặc biệt nổi bật trong cộng đồng game thủ nhờ vào các sản phẩm hiệu năng cao, thiết kế đặc trưng, và tính năng tối ưu cho việc chơi game', '1.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int NOT NULL,
  `order_id` int NOT NULL,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_status` enum('processing','shipped','delivered','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'processing',
  `estimated_delivery` datetime DEFAULT NULL,
  `tracking_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `customer_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`shipping_id`, `order_id`, `shipping_address`, `shipping_status`, `estimated_delivery`, `tracking_number`, `phone`, `customer_name`, `note`) VALUES
(4, 6, 'asdasdasd', 'processing', NULL, NULL, '0912312341', 'new order 2', 'adasasdad');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_id` int NOT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `Role` enum('user','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_id`, `Username`, `Password`, `Name`, `Email`, `Phone`, `Address`, `Role`) VALUES
(1, 'user', 'user123', 'Nguyễn Văn A', 'nguyenvana@email.com', '0987654321', '123 Đường ABC, TP.HCM', 'user'),
(2, 'admin', 'admin123', 'Trần Văn B', 'tranvanb@email.com', '0123456789', '456 Đường XYZ, Hà Nội', 'admin'),
(3, 'ledainhoc', '159753', 'Lê Đại Học', 'ledainhoc@email.com', '0852147963', '789 Đường PQR, Đà Nẵng', 'user'),
(4, 'newuser', '123456', 'name', 'newuser@gmail.com', '09234241223', 'ha noi', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`),
  ADD UNIQUE KEY `brand_name` (`brand_name`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`Coupon_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`Order_id`),
  ADD KEY `User_id` (`User_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Order_id` (`Order_id`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `fk_brand` (`brand_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD UNIQUE KEY `tracking_number` (`tracking_number`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discount_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`User_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `user` (`User_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupon` (`Coupon_id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`Order_id`) REFERENCES `order` (`Order_id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`Order_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`),
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`User_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`Order_id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`User_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`Product_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
