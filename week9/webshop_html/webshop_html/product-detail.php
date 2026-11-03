<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Chi tiết sản phẩm - MyShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

  <!-- ===== includes/header.php ===== -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.html">🛒 MyShop</a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="index.html">Trang chủ</a></li>
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
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Trang chủ</a></li>
        <li class="breadcrumb-item active">iPhone 15 128GB</li>
      </ol>
    </nav>
    <div class="row g-4">
      <div class="col-md-6"><img src="https://picsum.photos/seed/p1/400/300" class="img-fluid rounded shadow-sm w-100" alt="iPhone 15 128GB"></div>
      <div class="col-md-6">
        <h2>iPhone 15 128GB</h2>
        <p><a class="badge bg-secondary text-decoration-none" href="products.html?cat=1">Điện thoại</a> <a class="badge bg-secondary text-decoration-none" href="products.html?cat=4">Apple</a></p>
        <h3 class="text-danger">22.990.000 ₫</h3>
        <p>Chip A16, camera 48MP, cổng USB-C.</p>
        <p class="text-muted">Còn lại: 20 sản phẩm</p>
        <form method="post" action="cart.html" class="d-flex gap-2">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="product_id" value="1">
          <input type="number" name="qty" value="1" min="1" max="20" class="form-control qty-input">
          <button class="btn btn-primary btn-lg">Mua hàng</button>
        </form>
      </div>
    </div>
  </main>

  <!-- ===== includes/footer.php ===== -->
  <footer class="bg-dark text-white-50 text-center py-3">© 2026 MyShop – Bài tập PHP &amp; MySQL</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
