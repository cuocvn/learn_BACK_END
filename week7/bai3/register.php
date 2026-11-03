<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/auth.php';

$error = '';
$success = '';

if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $repassword = $_POST['repassword'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $error = 'Vui lòng điền đầy đủ các thông tin!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Địa chỉ email không hợp lệ!';
    } elseif ($password !== $repassword) {
        $error = 'Mật khẩu nhập lại không khớp!';
    } elseif (strlen($password) < 6) {
        $error = 'Mật khẩu phải có ít nhất 6 ký tự!';
    } else {
        $db = Database::getInstance();
        $check = $db->select("SELECT id FROM users WHERE username = ? OR email = ?", "ss", [$username, $email]);
        if (!empty($check)) {
            $error = 'Tên đăng nhập hoặc Email đã tồn tại!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user'; // Đăng ký mặc định là user thông thường
            $stmt = $db->execute(
                "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)",
                "ssss",
                [$username, $hash, $email, $role]
            );
            if ($stmt) {
                $success = 'Đăng ký tài khoản thành công! Bạn có thể đăng nhập ngay.';
            } else {
                $error = 'Có lỗi xảy ra khi đăng ký, vui lòng thử lại!';
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
    <title>Đăng Ký Tài Khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 450px;">
    <div class="text-center mb-4">
        <a href="index.php" class="text-decoration-none">
            <h2 class="fw-bold text-primary"><i class="bi bi-shield-lock"></i> TechShop System</h2>
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0 fw-bold">Đăng Ký Tài Khoản</h4>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Địa chỉ Email</label>
                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nhập lại mật khẩu</label>
                    <input type="password" name="repassword" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mt-2">
                    <i class="bi bi-person-plus-fill"></i> Đăng Ký
                </button>
            </form>

            <div class="text-center mt-3 pt-3 border-top">
                Đã có tài khoản? <a href="login.php" class="fw-bold text-decoration-none">Đăng nhập ngay</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
