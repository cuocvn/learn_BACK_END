<?php
// 1. Nhúng các Model cần dùng
require_once 'model/Category.php';
require_once 'model/Product.php';

$categoryModel = new Category();
$productModel = new Product();

// 2. Lấy danh mục để đổ vào dropdown menu
$categories = $categoryModel->getAllCategory();

// 3. Lấy ID sản phẩm từ URL (ví dụ: product-detail.php?id=1)
$id = (int)($_GET['id'] ?? 0);

// 4. Lấy thông tin chi tiết sản phẩm từ CSDL
$product = $productModel->getProductById($id);

// Nếu không tìm thấy sản phẩm thì báo lỗi và dừng lại
if (!$product) {
    die("Sản phẩm không tồn tại! <a href='index.php'>Quay về trang chủ</a>");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($product['name']) ?> - MyShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

  <!-- ===== HEADER / NAVBAR ===== -->
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
              <li><a class="dropdown-item" href="products.php">Tất cả</a></li>
              <?php foreach ($categories as $c): ?>
                <li><a class="dropdown-item" href="products.php?cat=<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </li>
          <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <li class="nav-item"><a class="nav-link text-warning" href="admin-products.php">Quản trị</a></li>
          <?php endif; ?>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="cart.php">Giỏ hàng <span class="badge bg-danger"><?= array_sum($_SESSION['cart'] ?? []) ?></span></a></li>
          <?php if (isset($_SESSION['user'])): ?>
            <li class="nav-item"><span class="nav-link text-white">Chào, <?= htmlspecialchars($_SESSION['user']['fullname']) ?></span></li>
            <li class="nav-item"><a class="nav-link text-warning" href="logout.php">Đăng xuất</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Đăng nhập</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Đăng ký</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ===== NỘI DUNG CHI TIẾT SẢN PHẨM ===== -->
  <main class="container my-4 flex-grow-1">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="products.php">Sản phẩm</a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($product['name']) ?></li>
      </ol>
    </nav>
    <div class="row g-4 bg-white p-4 rounded shadow-sm">
      <div class="col-md-6">
        <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;" alt="<?= htmlspecialchars($product['name']) ?>">
      </div>
      <div class="col-md-6">
        <h2><?= htmlspecialchars($product['name']) ?></h2>

        <?php if (!empty($product['category_names'])): ?>
          <p>
            <?php foreach (explode(', ', $product['category_names']) as $catName): ?>
              <span class="badge bg-secondary"><?= htmlspecialchars($catName) ?></span>
            <?php endforeach; ?>
          </p>
        <?php endif; ?>

        <h3 class="text-danger my-3"><?= number_format($product['price'], 0, ',', '.') ?> ₫</h3>
        
        <p class="text-muted mb-1"><strong>Mô tả sản phẩm:</strong></p>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

        <p class="text-muted">Còn lại: <strong><?= (int)$product['stock'] ?></strong> sản phẩm</p>

        <!-- FORM THÊM VÀO GIỎ HÀNG -->
        <?php if ((int)$product['stock'] > 0): ?>
          <form method="post" action="cart.php" class="d-flex gap-2 align-items-center mt-3">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <label class="form-label mb-0 fw-bold">Số lượng:</label>
            <input type="number" name="qty" value="1" min="1" max="<?= (int)$product['stock'] ?>" class="form-control qty-input" style="width: 80px;">
            <button type="submit" class="btn btn-primary btn-lg">🛒 Mua hàng</button>
          </form>
        <?php else: ?>
          <div class="alert alert-warning mt-3">Sản phẩm hiện đang tạm hết hàng.</div>
        <?php endif; ?>

      </div>
    </div>
  </main>

  <!-- ===== FOOTER ===== -->
  <footer class="bg-dark text-white-50 text-center py-3 mt-4">© 2026 MyShop – Bài tập PHP &amp; MySQL</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
