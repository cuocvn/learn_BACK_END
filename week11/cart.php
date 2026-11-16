<?php
// 1. Nhúng các Model cần dùng
require_once 'model/Category.php';
require_once 'model/Product.php';

$categoryModel = new Category();
$categories = $categoryModel->getAllCategory();

// Khởi tạo giỏ hàng nếu chưa có trong Session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ========================================================
// 2. XỬ LÝ CÁC HÀNH ĐỘNG TRÊN GIỎ HÀNG (POST)
// ========================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // A. Xóa 1 sản phẩm khỏi giỏ (nút Xóa mang name="remove" value="ID")
    if (isset($_POST['remove'])) {
        $removeId = (int)$_POST['remove'];
        unset($_SESSION['cart'][$removeId]);
        header("Location: cart.php");
        exit;
    }

    $action = $_POST['action'] ?? '';

    // B. Thêm sản phẩm vào giỏ hàng (từ index.php, products.php hoặc product-detail.php)
    if ($action === 'add') {
        $pid = (int)($_POST['product_id'] ?? 0);
        $qty = max(1, (int)($_POST['qty'] ?? 1));
        if ($pid > 0) {
            $_SESSION['cart'][$pid] = ($_SESSION['cart'][$pid] ?? 0) + $qty;
        }
        header("Location: cart.php");
        exit;
    }

    // C. Cập nhật số lượng giỏ hàng
    if ($action === 'update' && isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $pid => $qty) {
            $pid = (int)$pid;
            $qty = (int)$qty;
            if ($qty <= 0) {
                unset($_SESSION['cart'][$pid]);
            } else {
                $_SESSION['cart'][$pid] = $qty;
            }
        }
        header("Location: cart.php");
        exit;
    }

    // D. Đặt hàng (Checkout)
    if ($action === 'checkout') {
        $_SESSION['cart'] = [];
        header("Location: cart.php?ordered=1");
        exit;
    }
}

// ========================================================
// 3. LẤY CHI TIẾT SẢN PHẨM TRONG GIỎ TỪ CSDL
// ========================================================
$cart = $_SESSION['cart'];
$products = [];

if (!empty($cart)) {
    global $conn;
    $ids = array_keys($cart);
    // Tạo chuỗi dấu hỏi chấm (?, ?, ...) cho Prepared Statement
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $products[$row['id']] = $row;
    }
}
?>
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
          <li class="nav-item"><a class="nav-link active" href="cart.php">Giỏ hàng <span class="badge bg-danger"><?= array_sum($_SESSION['cart'] ?? []) ?></span></a></li>
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

  <!-- ===== NỘI DUNG GIỎ HÀNG ===== -->
  <main class="container my-4 flex-grow-1">
    <h2 class="mb-3">Giỏ hàng của bạn</h2>

    <!-- Thông báo nếu vừa đặt hàng thành công -->
    <?php if (isset($_GET['ordered'])): ?>
      <div class="alert alert-success">
        🎉 Đặt hàng thành công! Đơn hàng của bạn đã được ghi nhận. 
        <a href="products.php" class="alert-link">Tiếp tục mua sắm</a>
      </div>
    <?php endif; ?>

    <!-- Kiểm tra giỏ hàng trống hay có hàng -->
    <?php if (empty($cart)): ?>
      <div class="alert alert-info">
        Giỏ hàng của bạn đang trống. <a href="products.php" class="alert-link">Mua sắm ngay</a>
      </div>
    <?php else: ?>
      <form method="post">
        <input type="hidden" name="action" value="update">
        <div class="table-responsive">
          <table class="table table-bordered align-middle bg-white shadow-sm">
            <thead class="table-light">
              <tr>
                <th>Sản phẩm</th>
                <th width="150" class="text-end">Đơn giá</th>
                <th width="120" class="text-center">Số lượng</th>
                <th width="160" class="text-end">Thành tiền</th>
                <th width="80" class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $total = 0;
              foreach ($cart as $id => $qty): 
                if (!isset($products[$id])) continue;
                $p = $products[$id];
                $subtotal = $p['price'] * $qty;
                $total += $subtotal;
              ?>
              <tr>
                <td>
                  <img src="<?= htmlspecialchars($p['image']) ?>" class="thumb me-2 rounded" style="width: 50px; height: 40px; object-fit: cover;" alt="">
                  <a href="product-detail.php?id=<?= $p['id'] ?>" class="text-decoration-none text-dark fw-bold">
                    <?= htmlspecialchars($p['name']) ?>
                  </a>
                </td>
                <td class="text-end"><?= number_format($p['price'], 0, ',', '.') ?> ₫</td>
                <td class="text-center">
                  <input type="number" name="qty[<?= $id ?>]" value="<?= $qty ?>" min="1" class="form-control qty-input text-center mx-auto" style="width: 80px;">
                </td>
                <td class="text-end text-danger fw-bold"><?= number_format($subtotal, 0, ',', '.') ?> ₫</td>
                <td class="text-center">
                  <button type="submit" name="remove" value="<?= $id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                    Xóa
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
          <button type="submit" class="btn btn-outline-secondary">🔄 Cập nhật giỏ hàng</button>
          <a href="products.php" class="btn btn-outline-primary">← Tiếp tục mua sắm</a>
        </div>
      </form>

      <div class="text-end mt-4 p-3 bg-white rounded shadow-sm">
        <h4 class="mb-3">Tổng cộng: <span class="text-danger fw-bold"><?= number_format($total, 0, ',', '.') ?> ₫</span></h4>
        <form method="post">
          <input type="hidden" name="action" value="checkout">
          <button type="submit" class="btn btn-success btn-lg px-4">Đồng ý đặt hàng</button>
        </form>
      </div>
    <?php endif; ?>
  </main>

  <!-- ===== FOOTER ===== -->
  <footer class="bg-dark text-white-50 text-center py-3 mt-4">© 2026 MyShop – Bài tập PHP &amp; MySQL</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
