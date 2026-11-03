<?php
require_once 'model/Category.php';
require_once 'model/Product.php';

$categoryModel = new Category();
$productModel = new Product();

// Lấy danh mục cho menu
$categories = $categoryModel->getAllCategory();

// Lấy toàn bộ sản phẩm để hiển thị lên bảng
$products = $productModel->getAllProduct();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Quản lý sản phẩm - MyShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

  <!-- ===== includes/header.php ===== -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">🛒 MyShop</a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Danh mục</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="products.html">Tất cả</a></li>
              <li><a class="dropdown-item" href="products.html?cat=1">Điện thoại</a></li><li><a class="dropdown-item" href="products.html?cat=2">Laptop</a></li><li><a class="dropdown-item" href="products.html?cat=3">Phụ kiện</a></li><li><a class="dropdown-item" href="products.html?cat=4">Apple</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link text-warning" href="admin-products.html">Quản trị</a></li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="cart.html">Giỏ hàng <span class="badge bg-danger">0</span></a></li>
          <li class="nav-item"><a class="nav-link" href="login.html">Đăng nhập</a></li>
          <li class="nav-item"><a class="nav-link" href="register.html">Đăng ký</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-4 flex-grow-1">
    <h2 class="mb-3">Trang quản trị</h2>
    <ul class="nav nav-tabs mb-3">
      <li class="nav-item"><a class="nav-link active" href="admin-products.html">Sản phẩm</a></li>
      <li class="nav-item"><a class="nav-link " href="admin-users.html">Người dùng</a></li>
    </ul>
    <a href="admin-product-form.html" class="btn btn-primary mb-3">+ Thêm sản phẩm</a>
    <div class="table-responsive">
      <table class="table table-bordered align-middle bg-white">
        <thead class="table-light"><tr><th>ID</th><th>Ảnh</th><th>Tên</th><th>Danh mục</th><th>Giá</th><th>Tồn</th><th>Thao tác</th></tr></thead>
        <tbody>
           <?php foreach ($products as $p): ?>
    <tr>
      <td><?= $p['id'] ?></td>
      <td><img src="<?= $p['image'] ?>" class="thumb" alt=""></td>
      <td><?= htmlspecialchars($p['name']) ?></td>
      <td><?= htmlspecialchars($p['category_names'] ?? 'Chưa phân loại') ?></td>
      <td><?= number_format($p['price'], 0, ',', '.') ?> ₫</td>
      <td><?= $p['stock'] ?></td>
      <td class="text-nowrap">
        <a href="admin-product-form.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
        <form method="post" class="d-inline">
          <button name="delete" value="<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
            </tbody>
      </table>
    </div>
  </main>

  <!-- ===== includes/footer.php ===== -->
  <footer class="bg-dark text-white-50 text-center py-3">© 2026 MyShop – Bài tập PHP &amp; MySQL</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
