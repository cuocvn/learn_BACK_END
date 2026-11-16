<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Thêm / sửa sản phẩm - MyShop</title>
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
      <li class="nav-item"><a class="nav-link active" href="admin-products.html">Sản phẩm</a></li>
      <li class="nav-item"><a class="nav-link " href="admin-users.html">Người dùng</a></li>
    </ul>
    <div class="card card-body">
      <h5>Thêm sản phẩm</h5>
      <!-- PHP: <div class="alert alert-danger py-2">...lỗi...</div>, tiêu đề "Sửa sản phẩm" và value các ô khi sửa -->
      <form method="post" class="row g-3">
        <div class="col-md-6"><label class="form-label">Tên sản phẩm</label><input name="name" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Giá (₫)</label><input type="number" name="price" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">Tồn kho</label><input type="number" name="stock" min="0" value="0" class="form-control"></div>
        <div class="col-12"><label class="form-label">Link ảnh</label><input name="image" class="form-control"></div>
        <div class="col-12"><label class="form-label">Mô tả</label><textarea name="description" rows="3" class="form-control"></textarea></div>
        <div class="col-12">
          <label class="form-label d-block">Danh mục</label>
        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="cats[]" value="1" id="c1"><label class="form-check-label" for="c1">Điện thoại</label></div>
        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="cats[]" value="2" id="c2"><label class="form-check-label" for="c2">Laptop</label></div>
        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="cats[]" value="3" id="c3"><label class="form-check-label" for="c3">Phụ kiện</label></div>
        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="cats[]" value="4" id="c4"><label class="form-check-label" for="c4">Apple</label></div>
        </div>
        <div class="col-12"><button class="btn btn-primary">Lưu</button> <a href="admin-products.html" class="btn btn-secondary">Hủy</a></div>
      </form>
    </div>
  </main>

  <!-- ===== includes/footer.php ===== -->
  <footer class="bg-dark text-white-50 text-center py-3">© 2026 MyShop – Bài tập PHP &amp; MySQL</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
