-- Cơ sở dữ liệu cho Bài 3: `web_quanly`
CREATE DATABASE IF NOT EXISTS `web_quanly` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web_quanly`;

-- 1. Bảng người dùng: `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Bảng sản phẩm: `products`
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL UNIQUE,
  `name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `description` text,
  `image` varchar(255) DEFAULT 'default.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tài khoản mẫu (Mật khẩu mặc định là: 123456):
INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'admin', '$2y$10$raZDnbdeUs9cKkRi.mieHORc6SFutLB7WD8qfRjAziDnfdLLmArGu', 'admin@example.com', 'admin'),
(2, 'nguyenvana', '$2y$10$raZDnbdeUs9cKkRi.mieHORc6SFutLB7WD8qfRjAziDnfdLLmArGu', 'vana@example.com', 'user');

-- Dữ liệu mẫu sản phẩm:
INSERT INTO `products` (`id`, `code`, `name`, `price`, `description`, `image`) VALUES
(1, 'SP001', 'Điện thoại iPhone 15 Pro Max', 29990000.00, 'Titan tự nhiên, chip A17 Pro cực mạnh mẽ, camera 48MP zoom quang học 5x.', 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500'),
(2, 'SP002', 'Laptop MacBook Air M2', 24500000.00, 'Thiết kế siêu mỏng nhẹ, pin 18 tiếng, màn hình Liquid Retina tuyệt đẹp.', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500'),
(3, 'SP003', 'Đồng hồ thông minh Apple Watch', 9800000.00, 'Theo dõi sức khỏe toàn diện, đo nhịp tim, chống nước và màn hình luôn sáng.', 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=500'),
(4, 'SP004', 'Tai nghe AirPods Pro 2', 5400000.00, 'Chống ồn chủ động đỉnh cao, âm thanh vòm không gian sống động.', 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=500');
