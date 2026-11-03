<?php
require_once __DIR__ . '/Database.php';

$error = '';
$code = '';
$name = '';
$price = '';
$description = '';
$image = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if ($code === '' || $name === '' || $price <= 0) {
        $error = 'Vui lòng nhập đầy đủ Mã, Tên và Giá hợp lệ!';
    } else {
        $db = Database::getInstance();
        // Kiểm tra trùng mã
        $check = $db->select("SELECT id FROM products WHERE code = ?", "s", [$code]);
        if (!empty($check)) {
            $error = 'Mã sản phẩm này đã tồn tại, vui lòng chọn mã khác!';
        } else {
            if ($image === '') {
                $image = 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg&text=No+Image';
            }
            $success = $db->execute(
                "INSERT INTO products (code, name, price, description, image) VALUES (?, ?, ?, ?, ?)",
                "ssdss",
                [$code, $name, $price, $description, $image]
            );
            if ($success) {
                header("Location: admin_products.php?msg=added");
                exit;
            } else {
                $error = 'Không thể thêm sản phẩm, vui lòng thử lại.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-shop"></i> MiniShop</a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-light me-2">Trang Chủ</a>
            <a href="admin_products.php" class="btn btn-warning"><i class="bi bi-gear-fill"></i> Quản Lý Sản Phẩm</a>
        </div>
    </div>
</nav>

<div class="container py-5" style="max-width: 700px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-plus-circle"></i> Thêm Sản Phẩm Mới</h4>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Mã sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" placeholder="SP005" value="<?= htmlspecialchars($code) ?>" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" value="<?= htmlspecialchars($name) ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" step="1000" name="price" class="form-control" placeholder="50000" value="<?= htmlspecialchars($price) ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Link hình ảnh (URL)</label>
                        <input type="text" name="image" class="form-control" placeholder="https://example.com/image.jpg" value="<?= htmlspecialchars($image) ?>">
                        <small class="text-muted">Nhập URL ảnh từ internet hoặc để trống để dùng ảnh mặc định.</small>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Nhập thông tin mô tả chi tiết..."><?= htmlspecialchars($description) ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="admin_products.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save"></i> Lưu Sản Phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
