-- Cơ sở dữ liệu: `web_sanpham`
CREATE DATABASE IF NOT EXISTS `web_sanpham` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web_sanpham`;

-- Cấu trúc bảng `products`
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `description` text,
  `image` varchar(255) DEFAULT 'default.jpg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu mẫu
INSERT INTO `products` (`id`, `code`, `name`, `price`, `description`, `image`) VALUES
(1, 'SP001', 'Bánh Kem Dâu Tây', 250000.00, 'Bánh kem tươi hương dâu tây ngọt ngào dành cho sinh nhật và tiệc tùng.', 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500'),
(2, 'SP002', 'Trà Sữa Trân Châu Đường Đen', 45000.00, 'Trà sữa vị béo thơm ngon kết hợp trân châu đường đen dẻo dai.', 'https://images.unsplash.com/photo-1558857563-b371033873b8?w=500'),
(3, 'SP003', 'Cà Phê Muối Đặc Biệt', 35000.00, 'Hương vị cà phê đậm đà hòa quyện với lớp kem muối béo ngậy.', 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=500'),
(4, 'SP004', 'Bánh Mì Kẹp Thịt Nướng', 30000.00, 'Bánh mì giòn rụm với thịt nướng thơm lừng, đồ chua và sốt đặc biệt.', 'https://images.unsplash.com/photo-1509722747041-616f39b57569?w=500');
