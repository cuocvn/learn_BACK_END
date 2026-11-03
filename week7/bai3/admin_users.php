<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/auth.php';
requireAdmin();

$db = Database::getInstance();

// Xử lý XÓA người dùng
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = (int)($_GET['id'] ?? 0);
    // Không cho tự xóa tài khoản của chính mình đang đăng nhập
    if ($id === (int)$_SESSION['user']['id']) {
        header("Location: admin_users.php?msg=cannot_delete_self");
        exit;
    }
    if ($id > 0) {
        $db->execute("DELETE FROM users WHERE id = ?", "i", [$id]);
        header("Location: admin_users.php?msg=deleted");
        exit;
    }
}

$users = $db->select("SELECT id, username, email, role, created_at FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản Lý Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-laptop"></i> TechShop</a>
        <div class="collapse navbar-collapse show" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang Chủ</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="admin_products.php"><i class="bi bi-box-seam"></i> Quản Lý Sản Phẩm</a></li>
                <li class="nav-item"><a class="nav-link active text-warning" href="admin_users.php"><i class="bi bi-people-fill"></i> Quản Lý Người Dùng</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <span class="text-white small">Admin: <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></span>
                <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Đăng Xuất</a>
            </div>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Quản Lý Người Dùng (Admin)</h2>
            <small class="text-muted">Quản lý danh sách, phân quyền admin/user và thông tin tài khoản</small>
        </div>
        <a href="user_add.php" class="btn btn-success">
            <i class="bi bi-person-plus-fill"></i> Thêm Người Dùng Mới
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] === 'added'): ?>
            <div class="alert alert-success alert-dismissible fade show">Thêm người dùng mới thành công! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php elseif ($_GET['msg'] === 'updated'): ?>
            <div class="alert alert-success alert-dismissible fade show">Cập nhật thông tin người dùng thành công! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php elseif ($_GET['msg'] === 'deleted'): ?>
            <div class="alert alert-info alert-dismissible fade show">Đã xóa người dùng thành công! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php elseif ($_GET['msg'] === 'cannot_delete_self'): ?>
            <div class="alert alert-warning alert-dismissible fade show">Bạn không thể tự xóa tài khoản của chính mình! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 70px;">ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Email</th>
                            <th class="text-center" style="width: 130px;">Quyền (Role)</th>
                            <th style="width: 180px;">Ngày tạo</th>
                            <th class="text-center" style="width: 140px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Chưa có người dùng nào.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $u['id'] ?></td>
                                    <td class="fw-semibold">
                                        <i class="bi bi-person-circle text-primary me-1"></i>
                                        <?= htmlspecialchars($u['username']) ?>
                                        <?php if ((int)$u['id'] === (int)$_SESSION['user']['id']): ?>
                                            <span class="badge bg-info text-dark ms-1">Bạn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td class="text-center">
                                        <?php if ($u['role'] === 'admin'): ?>
                                            <span class="badge bg-danger">admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">user</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small"><?= $u['created_at'] ?></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="user_edit.php?id=<?= $u['id'] ?>" class="btn btn-outline-warning" title="Chỉnh sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <?php if ((int)$u['id'] !== (int)$_SESSION['user']['id']): ?>
                                                <a href="admin_users.php?action=delete&id=<?= $u['id'] ?>" 
                                                   class="btn btn-outline-danger" 
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')"
                                                   title="Xóa">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
