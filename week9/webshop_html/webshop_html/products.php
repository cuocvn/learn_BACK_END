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
    <h2 class="mb-3">Sản phẩm</h2>
    <!-- PHP: tab "active" theo ?cat=..., danh sách lọc qua bảng product_categories -->
    <ul class="nav nav-pills mb-4">
      <li class="nav-item"><a class="nav-link active" href="products.html">Tất cả</a></li>
      <li class="nav-item"><a class="nav-link" href="products.html?cat=1">Điện thoại</a></li>
      <li class="nav-item"><a class="nav-link" href="products.html?cat=2">Laptop</a></li>
      <li class="nav-item"><a class="nav-link" href="products.html?cat=3">Phụ kiện</a></li>
      <li class="nav-item"><a class="nav-link" href="products.html?cat=4">Apple</a></li>
    </ul>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=12"><img src="https://picsum.photos/seed/p12/400/300" class="card-img-top" alt="Oppo Reno11"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=12">Oppo Reno11</a></h6>
            <p class="text-danger fw-bold mb-3">10.990.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="12">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=11"><img src="https://picsum.photos/seed/p11/400/300" class="card-img-top" alt="Lenovo ThinkPad E14"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=11">Lenovo ThinkPad E14</a></h6>
            <p class="text-danger fw-bold mb-3">17.990.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="11">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=10"><img src="https://picsum.photos/seed/p10/400/300" class="card-img-top" alt="Sạc nhanh Anker 65W"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=10">Sạc nhanh Anker 65W</a></h6>
            <p class="text-danger fw-bold mb-3">790.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="10">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=9"><img src="https://picsum.photos/seed/p9/400/300" class="card-img-top" alt="Bàn phím cơ Keychron K2"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=9">Bàn phím cơ Keychron K2</a></h6>
            <p class="text-danger fw-bold mb-3">2.190.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="9">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=8"><img src="https://picsum.photos/seed/p8/400/300" class="card-img-top" alt="Chuột Logitech MX Master 3S"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=8">Chuột Logitech MX Master 3S</a></h6>
            <p class="text-danger fw-bold mb-3">2.490.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="8">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=7"><img src="https://picsum.photos/seed/p7/400/300" class="card-img-top" alt="Tai nghe AirPods Pro 2"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=7">Tai nghe AirPods Pro 2</a></h6>
            <p class="text-danger fw-bold mb-3">5.990.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="7">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=6"><img src="https://picsum.photos/seed/p6/400/300" class="card-img-top" alt="Asus Vivobook 15"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=6">Asus Vivobook 15</a></h6>
            <p class="text-danger fw-bold mb-3">14.990.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="6">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=5"><img src="https://picsum.photos/seed/p5/400/300" class="card-img-top" alt="Dell XPS 13"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=5">Dell XPS 13</a></h6>
            <p class="text-danger fw-bold mb-3">31.990.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="5">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=4"><img src="https://picsum.photos/seed/p4/400/300" class="card-img-top" alt="MacBook Air M2 13""></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=4">MacBook Air M2 13"</a></h6>
            <p class="text-danger fw-bold mb-3">26.990.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="4">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=3"><img src="https://picsum.photos/seed/p3/400/300" class="card-img-top" alt="Xiaomi 14"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=3">Xiaomi 14</a></h6>
            <p class="text-danger fw-bold mb-3">15.490.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="3">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=2"><img src="https://picsum.photos/seed/p2/400/300" class="card-img-top" alt="Samsung Galaxy S24"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=2">Samsung Galaxy S24</a></h6>
            <p class="text-danger fw-bold mb-3">19.990.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="2">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <a href="product-detail.html?id=1"><img src="https://picsum.photos/seed/p1/400/300" class="card-img-top" alt="iPhone 15 128GB"></a>
          <div class="card-body d-flex flex-column">
            <h6 class="card-title"><a class="text-decoration-none text-dark" href="product-detail.html?id=1">iPhone 15 128GB</a></h6>
            <p class="text-danger fw-bold mb-3">22.990.000 ₫</p>
            <form method="post" action="cart.html" class="mt-auto">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="1">
              <input type="hidden" name="qty" value="1">
              <button class="btn btn-primary w-100">Thêm vào giỏ</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- ===== includes/footer.php ===== -->
  <footer class="bg-dark text-white-50 text-center py-3">© 2026 MyShop – Bài tập PHP &amp; MySQL</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
