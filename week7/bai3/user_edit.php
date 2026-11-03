<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/auth.php';
requireAdmin();

$db = Database::getInstance();
$id = (int)($_GET['id'] ?? 0);

$user = $db->select("SELECT id, username, email, role FROM users WHERE id = ?", "i", [$id]);
if (empty($user)) {
    die("<div class='container mt-5'><div class='alert alert-danger'>Không tìm thấy người dùng! <a href='admin_users.php'>Quay về</a></div></div>");
}
$u = $user[0];

$error = '';
$username = $u['username'];
$email = $u['email'];
$role = $u['role'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if ($username === '' || $email === '') {
        $error = 'Vui lòng nhập đầy đủ tên đăng nhập và email!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ!';
    } else {
        // Kiểm tra trùng username hoặc email với người khác
        $check = $db->select("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?", "ssi", [$username, $email, $id]);
        if (!empty($check)) {
            $error = 'Tên đăng nhập hoặc Email đã được sử dụng!';
        } else {
            if (!empty($password)) {
                // Nếu có nhập mật khẩu mới
                if (strlen($password) < 6) {
                    $error = 'Mật khẩu mới phải có ít nhất 6 ký tự!';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $success = $db->execute(
                        "UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?",
                        "ssssi",
                        [$username, $email, $hash, $role, $id]
                    );
                }
            } else {
                // Không đổi mật khẩu
                $success = $db->execute(
                    "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?",
                    "sssi",
                    [$username, $email, $role, $id]
                );
            }

            if (empty($error)) {
                if ($success) {
                    // Nếu sửa chính mình thì update session
                    if ($id === (int)$_SESSION['user']['id']) {
                        $_SESSION['user']['username'] = $username;
                        $_SESSION['user']['email'] = $email;
                        $_SESSION['user']['role'] = $role;
                    }
                    header("Location: admin_users.php?msg=updated");
                    exit;
                } else {
                    $error = 'Không thể cập nhật người dùng!';
                }
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
    <title>Sửa Thông Tin Người Dùng</title>
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
        <div class="card-header bg-warning text-dark py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square"></i> Sửa Người Dùng #<?= $u['id'] ?></h4>
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
                    <label class="form-label fw-bold">Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control" placeholder="Để trống nếu không muốn đổi mật khẩu">
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
                    <button type="submit" class="btn btn-warning px-4 fw-bold"><i class="bi bi-check-circle"></i> Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
