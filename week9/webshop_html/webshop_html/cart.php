<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Giỏ hàng - MyShop</title>
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
          <li class="nav-item"><a class="nav-link" href="cart.html">Giỏ hàng <span class="badge bg-danger">3</span></a></li>
          <li class="nav-item"><a class="nav-link" href="login.html">Đăng nhập</a></li>
          <li class="nav-item"><a class="nav-link" href="register.html">Đăng ký</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-4 flex-grow-1">
    <h2 class="mb-3">Giỏ hàng</h2>
    <!-- PHP: nếu giỏ trống hiện: <div class="alert alert-info">Giỏ hàng trống. <a href="products.html" class="alert-link">Mua sắm ngay</a></div> -->
    <form method="post">
      <input type="hidden" name="action" value="update">
      <div class="table-responsive">
        <table class="table table-bordered align-middle bg-white">
          <thead class="table-light"><tr><th>Sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th><th></th></tr></thead>
          <tbody>
          <tr>
            <td><img src="https://picsum.photos/seed/p1/400/300" class="thumb me-2" alt="">iPhone 15 128GB</td>
            <td>22.990.000 ₫</td>
            <td><input type="number" name="qty[1]" value="1" min="1" class="form-control qty-input"></td>
            <td>22.990.000 ₫</td>
            <td><button name="remove" value="1" class="btn btn-sm btn-outline-danger">Xóa</button></td>
          </tr>
          <tr>
            <td><img src="https://picsum.photos/seed/p8/400/300" class="thumb me-2" alt="">Chuột Logitech MX Master 3S</td>
            <td>2.490.000 ₫</td>
            <td><input type="number" name="qty[8]" value="2" min="1" class="form-control qty-input"></td>
            <td>4.980.000 ₫</td>
            <td><button name="remove" value="8" class="btn btn-sm btn-outline-danger">Xóa</button></td>
          </tr>
          </tbody>
        </table>
      </div>
      <button class="btn btn-outline-secondary">Cập nhật giỏ hàng</button>
    </form>
    <div class="text-end mt-3">
      <h4>Tổng: <span class="text-danger">27.970.000 ₫</span></h4>
      <form method="post"><input type="hidden" name="action" value="checkout"><button class="btn btn-success btn-lg">Đặt hàng</button></form>
    </div>
  </main>

  <!-- ===== includes/footer.php ===== -->
  <footer class="bg-dark text-white-50 text-center py-3">© 2026 MyShop – Bài tập PHP &amp; MySQL</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
