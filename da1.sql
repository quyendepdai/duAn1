-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 16, 2025 at 03:43 AM
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
-- Database: `da1`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `category_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `description`, `Name`, `category_image`) VALUES
(1, 'laptop ASUS', 'ASUS', 'anh1.pnd'),
(2, 'Laptop MSI', 'MSI', 'snack.jpg'),
(3, 'Macbook pro', 'Macbook pro', 'nuoc_ngot.jpg'),
(4, 'laptop Dell', 'Dell', NULL);

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
(3, 'NEWCUSTOMER', '20000.00', '2024-12-22');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `Order_id` int NOT NULL,
  `User_id` int DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Total_order` decimal(10,2) DEFAULT NULL,
  `Status` enum('Pending','Shipped','Delivered','Cancelled') DEFAULT NULL,
  `coupon_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`Order_id`, `User_id`, `Date`, `Total_order`, `Status`, `coupon_id`) VALUES
(1, 1, '2023-05-01', '50000.00', 'Pending', 1),
(2, 2, '2023-05-02', '30000.00', 'Shipped', 2),
(3, 3, '2023-05-03', '30000.00', 'Delivered', 3);

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
(2, 1, 2, 1, '20000.00'),
(3, 2, 3, 3, '30000.00');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Description` text,
  `product_img` varchar(100) DEFAULT NULL,
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Name`, `Price`, `Description`, `product_img`, `category_id`) VALUES
(2, 'ROG Zephyrus', '20000.00', 'Laptop gaming mỏng nhẹ hàng đầu Việt Nam ASUS ROG Zephyrus G14, G15, G16, M16, Duo 16, AMD Ryzen 9, Intel 13, RTX 4080, Anime Matrix, màn 4K chính hãng giá tốt nhất.', 'anh1.png', 1),
(3, 'ROG Flow', '10000.00', 'Laptop gaming 2 trong 1 xoay gập 360 cảm ứng ASUS ROG Flow X13, Z13, X16, Ryzen 9, i9 gen 13, RTX 4060, MUX Switch, Webcam HD 1080P, bàn phím Led RGB, kết nối XG Mobile.', 'anh2.jpg', 1);

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
(3, 'ledainhoc', '159753', 'Lê Đại Học', 'ledainhoc@email.com', '0852147963', '789 Đường PQR, Đà Nẵng', 'user');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_id`);

--
-- Constraints for dumped tables
--

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
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
