-- ============ CSDL: shop_db (MySQL / MariaDB) ============
DROP DATABASE IF EXISTS shop_db;
CREATE DATABASE shop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shop_db;

-- 1. Người dùng (role: 'admin' hoặc 'customer')
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,           -- lưu hash bằng password_hash()
  phone VARCHAR(15),
  address VARCHAR(255),
  role ENUM('admin','customer') NOT NULL DEFAULT 'customer',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Danh mục
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- 3. Sản phẩm (không chứa mã danh mục)
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  price DECIMAL(12,0) NOT NULL,
  image VARCHAR(255),
  description TEXT,
  stock INT NOT NULL DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3b. Bảng liên kết sản phẩm <-> danh mục (quan hệ nhiều-nhiều)
CREATE TABLE product_categories (
  product_id INT NOT NULL,
  category_id INT NOT NULL,
  PRIMARY KEY (product_id, category_id),
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;


-- ============ DỮ LIỆU MẪU ============
-- Mật khẩu của cả 2 tài khoản mẫu: password
INSERT INTO users (fullname,email,password,phone,address,role) VALUES
('Quản trị viên','admin@shop.vn','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','0900000001','TP.HCM','admin'),
('Nguyễn Văn A','a@gmail.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','0900000002','Hà Nội','customer');

INSERT INTO categories (name) VALUES ('Điện thoại'),('Laptop'),('Phụ kiện'),('Apple');

INSERT INTO products (name,price,image,description,stock,created_at) VALUES
('iPhone 15 128GB',22990000,'https://picsum.photos/seed/p1/400/300','Chip A16, camera 48MP, cổng USB-C.',20,'2026-09-01'),
('Samsung Galaxy S24',19990000,'https://picsum.photos/seed/p2/400/300','Màn hình AMOLED 120Hz, Galaxy AI.',15,'2026-09-05'),
('Xiaomi 14',15490000,'https://picsum.photos/seed/p3/400/300','Ống kính Leica, Snapdragon 8 Gen 3.',25,'2026-09-10'),
('MacBook Air M2 13"',26990000,'https://picsum.photos/seed/p4/400/300','Chip M2, pin 18 giờ, mỏng nhẹ.',10,'2026-09-15'),
('Dell XPS 13',31990000,'https://picsum.photos/seed/p5/400/300','Màn hình InfinityEdge, Core Ultra 7.',8,'2026-09-20'),
('Asus Vivobook 15',14990000,'https://picsum.photos/seed/p6/400/300','Core i5, RAM 16GB, SSD 512GB.',30,'2026-09-25'),
('Tai nghe AirPods Pro 2',5990000,'https://picsum.photos/seed/p7/400/300','Chống ồn chủ động, sạc MagSafe.',40,'2026-10-01'),
('Chuột Logitech MX Master 3S',2490000,'https://picsum.photos/seed/p8/400/300','Cảm biến 8000 DPI, click êm.',35,'2026-10-05'),
('Bàn phím cơ Keychron K2',2190000,'https://picsum.photos/seed/p9/400/300','Bluetooth, hot-swap, layout 75%.',22,'2026-10-10'),
('Sạc nhanh Anker 65W',790000,'https://picsum.photos/seed/p10/400/300','GaN, 3 cổng sạc cùng lúc.',60,'2026-10-15'),
('Lenovo ThinkPad E14',17990000,'https://picsum.photos/seed/p11/400/300','Bền bỉ, bàn phím tốt, Core i5.',12,'2026-10-20'),
('Oppo Reno11',10990000,'https://picsum.photos/seed/p12/400/300','Camera chân dung 50MP, sạc nhanh 67W.',18,'2026-10-24');

-- Gán danh mục: iPhone, MacBook, AirPods thuộc cả "Apple"
INSERT INTO product_categories (product_id,category_id) VALUES
(1,1),(1,4),(2,1),(3,1),(4,2),(4,4),(5,2),(6,2),(7,3),(7,4),(8,3),(9,3),(10,3),(11,2),(12,1);

