<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/auth.php';

$error = '';

if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập tên đăng nhập và mật khẩu!';
    } else {
        $db = Database::getInstance();
        $user = $db->select("SELECT * FROM users WHERE username = ?", "s", [$username]);

        if (!empty($user) && (password_verify($password, $user[0]['password']) || $password === $user[0]['password'])) {
            $_SESSION['user'] = [
                'id' => $user[0]['id'],
                'username' => $user[0]['username'],
                'email' => $user[0]['email'],
                'role' => $user[0]['role']
            ];
            header("Location: index.php");
            exit;
        } else {
            $error = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Hệ Thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 420px;">
    <div class="text-center mb-4">
        <a href="index.php" class="text-decoration-none">
            <h2 class="fw-bold text-primary"><i class="bi bi-shield-lock"></i> TechShop System</h2>
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white text-center py-3">
            <h4 class="mb-0 fw-bold">Đăng Nhập</h4>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" placeholder="Tên tài khoản">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mt-2">
                    <i class="bi bi-box-arrow-in-right"></i> Đăng Nhập
                </button>
            </form>

            <div class="alert alert-info mt-3 p-2 small mb-0">
                <strong>Gợi ý tài khoản demo:</strong><br>
                Admin: <code>admin</code> / <code>123456</code><br>
                User: <code>nguyenvana</code> / <code>123456</code>
            </div>

            <div class="text-center mt-3 pt-3 border-top">
                Chưa có tài khoản? <a href="register.php" class="fw-bold text-decoration-none">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
