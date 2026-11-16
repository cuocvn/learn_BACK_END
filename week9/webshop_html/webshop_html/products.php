<?php
// 1. Nhúng các Model cần dùng
require_once 'model/Category.php';
require_once 'model/Product.php';

$categoryModel = new Category();
$productModel = new Product();

// 2. Lấy danh mục để đổ vào các tab lọc
$categories = $categoryModel->getAllCategory();

// 3. Lấy sản phẩm: Nếu có ?cat= thì lọc theo loại, ngược lại lấy tất cả
$catId = (int)($_GET['cat'] ?? 0);
if ($catId > 0) {
    $products = $productModel->getProductByCateId($catId);
} else {
    $products = $productModel->getAllProduct();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Sản phẩm - MyShop</title>
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

  <!-- ===== DANH SÁCH SẢN PHẨM & BỘ LỌC DANH MỤC ===== -->
  <main class="container my-4 flex-grow-1">
    <h2 class="mb-3">Danh sách sản phẩm</h2>

    <!-- TAB LỌC THEO DANH MỤC -->
    <ul class="nav nav-pills mb-4">
      <li class="nav-item">
        <a class="nav-link <?= $catId === 0 ? 'active' : '' ?>" href="products.php">Tất cả</a>
      </li>
      <?php foreach ($categories as $c): ?>
        <li class="nav-item">
          <a class="nav-link <?= $catId === (int)$c['id'] ? 'active' : '' ?>" href="products.php?cat=<?= $c['id'] ?>">
            <?= htmlspecialchars($c['name']) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <!-- LƯỚI SẢN PHẨM -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
      <?php if (empty($products)): ?>
        <div class="col-12">
          <div class="alert alert-info">Không có sản phẩm nào thuộc danh mục này.</div>
        </div>
      <?php else: ?>
        <?php foreach ($products as $p): ?>
          <div class="col">
            <div class="card h-100 shadow-sm">
              <a href="product-detail.php?id=<?= $p['id'] ?>">
                <img src="<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>">
              </a>
              <div class="card-body d-flex flex-column">
                <h6 class="card-title">
                  <a class="text-decoration-none text-dark" href="product-detail.php?id=<?= $p['id'] ?>">
                    <?= htmlspecialchars($p['name']) ?>
                  </a>
                </h6>
                <p class="text-danger fw-bold mb-3"><?= number_format($p['price'], 0, ',', '.') ?> ₫</p>
                <form method="post" action="cart.php" class="mt-auto">
                  <input type="hidden" name="action" value="add">
                  <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                  <input type="hidden" name="qty" value="1">
                  <button type="submit" class="btn btn-primary w-100">🛒 Thêm vào giỏ</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <!-- ===== FOOTER ===== -->
  <footer class="bg-dark text-white-50 text-center py-3 mt-4">© 2026 MyShop – Bài tập PHP &amp; MySQL</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
