<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/auth.php';
requireAdmin();

$error = '';
$username = '';
$email = '';
$role = 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if ($username === '' || $email === '' || $password === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ!';
    } elseif (strlen($password) < 6) {
        $error = 'Mật khẩu phải tối thiểu 6 ký tự!';
    } else {
        $db = Database::getInstance();
        $check = $db->select("SELECT id FROM users WHERE username = ? OR email = ?", "ss", [$username, $email]);
        if (!empty($check)) {
            $error = 'Tên đăng nhập hoặc Email đã tồn tại!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $success = $db->execute(
                "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)",
                "ssss",
                [$username, $hash, $email, $role]
            );
            if ($success) {
                header("Location: admin_users.php?msg=added");
                exit;
            } else {
                $error = 'Không thể thêm người dùng!';
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
    <title>Thêm Người Dùng Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-laptop"></i> TechShop</a>
        <div class="ms-auto">
            <a href="admin_users.php" class="btn btn-warning btn-sm"><i class="bi bi-arrow-left"></i> Về Danh Sách</a>
        </div>
    </div>
</nav>

<div class="container py-5" style="max-width: 550px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill"></i> Thêm Người Dùng Mới</h4>
        </div>
        <div class="card-body p-4">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên đăng nhập <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Phân quyền</label>
                    <select name="role" class="form-select">
                        <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User (Khách thông thường)</option>
                        <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin (Quản trị viên hệ thống)</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="admin_users.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Hủy</a>
                    <button type="submit" class="btn btn-success px-4"><i class="bi bi-save"></i> Lưu Người Dùng</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
