<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Quản lý người dùng - MyShop</title>
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
    <h2 class="mb-3">Trang quản trị</h2>
    <ul class="nav nav-tabs mb-3">
      <li class="nav-item"><a class="nav-link " href="admin-products.html">Sản phẩm</a></li>
      <li class="nav-item"><a class="nav-link active" href="admin-users.html">Người dùng</a></li>
    </ul>
    <div class="table-responsive">
      <table class="table table-bordered align-middle bg-white">
        <thead class="table-light"><tr><th>ID</th><th>Họ tên</th><th>Email</th><th>Vai trò</th><th>Ngày tạo</th><th>Thao tác</th></tr></thead>
        <tbody>
          <tr><td>1</td><td>Quản trị viên</td><td>admin@shop.vn</td><td><span class="badge bg-danger">admin</span></td><td>2026-10-01</td>
            <td class="text-nowrap"><form method="post" class="d-inline"><input type="hidden" name="id" value="1">
              <button name="action" value="role" class="btn btn-sm btn-warning">Đổi quyền</button>
              <button name="action" value="delete" class="btn btn-sm btn-danger">Xóa</button></form></td></tr>
          <tr><td>2</td><td>Nguyễn Văn A</td><td>a@gmail.com</td><td><span class="badge bg-secondary">customer</span></td><td>2026-10-02</td>
            <td class="text-nowrap"><form method="post" class="d-inline"><input type="hidden" name="id" value="2">
              <button name="action" value="role" class="btn btn-sm btn-warning">Đổi quyền</button>
              <button name="action" value="delete" class="btn btn-sm btn-danger">Xóa</button></form></td></tr>
        </tbody>
      </table>
    </div>
  </main>

  <!-- ===== includes/footer.php ===== -->
  <footer class="bg-dark text-white-50 text-center py-3">© 2026 MyShop – Bài tập PHP &amp; MySQL</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
