<?php
// ============================================================================
// PHẦN 1: ĐỊNH NGHĨA CÁC ĐỐI TƯỢNG (OOP)
// ============================================================================

/**
 * 1. Interface Borrowable: chức năng mượn và trả tài liệu
 */
interface Borrowable {
    public function borrow();          // Mượn tài liệu
    public function returnDocument();  // Trả tài liệu
    public function isAvailable();     // Kiểm tra xem có sẵn để mượn không
}

/**
 * 2. Lớp trừu tượng Document: chứa các thuộc tính và phương thức chung
 */
abstract class Document implements Borrowable {
    protected $id;          // Mã tài liệu
    protected $title;       // Tiêu đề
    protected $author;      // Tác giả
    protected $year;        // Năm xuất bản
    protected $category;    // Thể loại
    protected $status;      // Trạng thái: 'available' (sẵn sàng) hoặc 'borrowed' (đang mượn)

    public function __construct($id, $title, $author, $year, $category, $status = 'available') {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->category = $category;
        $this->status = $status;
    }

    // Phương thức trừu tượng: lớp con bắt buộc phải tự định nghĩa loại của mình
    abstract public function getType();

    // Các hàm lấy dữ liệu (Getters)
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getAuthor() { return $this->author; }
    public function getYear() { return $this->year; }
    public function getCategory() { return $this->category; }
    public function getStatus() { return $this->status; }

    // Thực thi interface Borrowable
    public function isAvailable() {
        return $this->status === 'available';
    }

    public function borrow() {
        if ($this->isAvailable()) {
            $this->status = 'borrowed';
            return true;
        }
        return false;
    }

    public function returnDocument() {
        if (!$this->isAvailable()) {
            $this->status = 'available';
            return true;
        }
        return false;
    }
}

/**
 * 3. Lớp Book (Sách in) kế thừa từ Document
 */
class Book extends Document {
    private $pages;   // Số trang
    private $weight;  // Cân nặng (kg)

    public function __construct($id, $title, $author, $year, $category, $pages, $weight, $status = 'available') {
        parent::__construct($id, $title, $author, $year, $category, $status);
        $this->pages = $pages;
        $this->weight = $weight;
    }

    public function getType() { return 'Book'; }
    public function getPages() { return $this->pages; }
    public function getWeight() { return $this->weight; }
}

/**
 * 4. Lớp EBook (Sách điện tử) kế thừa từ Document
 */
class EBook extends Document {
    private $fileSize; // Dung lượng (MB)
    private $format;   // Định dạng (PDF, EPUB,...)

    public function __construct($id, $title, $author, $year, $category, $fileSize, $format, $status = 'available') {
        parent::__construct($id, $title, $author, $year, $category, $status);
        $this->fileSize = $fileSize;
        $this->format = $format;
    }

    public function getType() { return 'EBook'; }
    public function getFileSize() { return $this->fileSize; }
    public function getFormat() { return $this->format; }
}

/**
 * 5. Lớp Magazine (Tạp chí) kế thừa từ Document
 */
class Magazine extends Document {
    private $issueNumber; // Số phát hành
    private $month;       // Tháng phát hành

    public function __construct($id, $title, $author, $year, $category, $issueNumber, $month, $status = 'available') {
        parent::__construct($id, $title, $author, $year, $category, $status);
        $this->issueNumber = $issueNumber;
        $this->month = $month;
    }

    public function getType() { return 'Magazine'; }
    public function getIssueNumber() { return $this->issueNumber; }
    public function getMonth() { return $this->month; }
}

/**
 * 6. Lớp Library: quản lý danh sách tài liệu
 */
class Library {
    public $documents = [];

    // Thêm tài liệu (kiểm tra trùng mã)
    public function addDocument($doc) {
        foreach ($this->documents as $item) {
            if ($item->getId() == $doc->getId()) {
                throw new Exception("Lỗi: Mã tài liệu '{$doc->getId()}' đã tồn tại!");
            }
        }
        $this->documents[] = $doc;
    }

    // Xóa tài liệu theo mã ID
    public function deleteDocument($id) {
        foreach ($this->documents as $index => $item) {
            if ($item->getId() == $id) {
                array_splice($this->documents, $index, 1);
                return true;
            }
        }
        throw new Exception("Lỗi: Không tìm thấy tài liệu mã '{$id}' để xóa!");
    }

    // Tìm tài liệu theo mã ID
    public function findById($id) {
        foreach ($this->documents as $item) {
            if ($item->getId() == $id) {
                return $item;
            }
        }
        return null;
    }

    // Mượn tài liệu
    public function borrowDocument($id) {
        $doc = $this->findById($id);
        if (!$doc) {
            throw new Exception("Lỗi: Không tìm thấy tài liệu mã '{$id}'!");
        }
        if (!$doc->isAvailable()) {
            throw new Exception("Lỗi: Tài liệu '{$doc->getTitle()}' hiện đang có người mượn!");
        }
        return $doc->borrow();
    }

    // Trả tài liệu
    public function returnDocument($id) {
        $doc = $this->findById($id);
        if (!$doc) {
            throw new Exception("Lỗi: Không tìm thấy tài liệu mã '{$id}'!");
        }
        if ($doc->isAvailable()) {
            throw new Exception("Lỗi: Tài liệu '{$doc->getTitle()}' đang sẵn sàng, không cần trả!");
        }
        return $doc->returnDocument();
    }

    // Tìm kiếm đơn giản theo tên, mã, tác giả
    public function search($keyword, $list) {
        $keyword = trim($keyword);
        if ($keyword == '') {
            return $list;
        }
        $result = [];
        foreach ($list as $doc) {
            if (stripos($doc->getId(), $keyword) !== false ||
                stripos($doc->getTitle(), $keyword) !== false ||
                stripos($doc->getAuthor(), $keyword) !== false) {
                $result[] = $doc;
            }
        }
        return $result;
    }

    // Lọc theo thể loại, loại tài liệu, trạng thái
    public function filter($list, $category, $type, $status) {
        $result = [];
        foreach ($list as $doc) {
            if ($category != '' && $category != 'all' && $doc->getCategory() != $category) {
                continue;
            }
            if ($type != '' && $type != 'all' && $doc->getType() != $type) {
                continue;
            }
            if ($status != '' && $status != 'all' && $doc->getStatus() != $status) {
                continue;
            }
            $result[] = $doc;
        }
        return $result;
    }

    // Sắp xếp đơn giản (thuật toán đổi chỗ 2 vòng lặp)
    public function sort($list, $field, $order) {
        $n = count($list);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $swap = false;
                if ($field == 'year') {
                    if ($order == 'asc' && $list[$i]->getYear() > $list[$j]->getYear()) $swap = true;
                    if ($order == 'desc' && $list[$i]->getYear() < $list[$j]->getYear()) $swap = true;
                } else {
                    // Mặc định sắp xếp theo tên
                    $cmp = strcasecmp($list[$i]->getTitle(), $list[$j]->getTitle());
                    if ($order == 'asc' && $cmp > 0) $swap = true;
                    if ($order == 'desc' && $cmp < 0) $swap = true;
                }
                if ($swap) {
                    $tmp = $list[$i];
                    $list[$i] = $list[$j];
                    $list[$j] = $tmp;
                }
            }
        }
        return $list;
    }

    // Thống kê số lượng
    public function getStatistics() {
        $stats = [
            'total' => count($this->documents),
            'book' => 0,
            'ebook' => 0,
            'magazine' => 0,
            'available' => 0,
            'borrowed' => 0
        ];
        foreach ($this->documents as $doc) {
            if ($doc->getType() == 'Book') $stats['book']++;
            if ($doc->getType() == 'EBook') $stats['ebook']++;
            if ($doc->getType() == 'Magazine') $stats['magazine']++;

            if ($doc->isAvailable()) $stats['available']++;
            else $stats['borrowed']++;
        }
        return $stats;
    }
}

// ============================================================================
// PHẦN 2: XỬ LÝ DỮ LIỆU & CÁC CHỨC NĂNG (PHP)
// ============================================================================

// Bắt đầu Session SAU KHI các class đã được khai báo
// (Nếu gọi session_start() trước class, PHP sẽ báo lỗi incomplete object)
session_start();

// Khởi tạo 6 tài liệu mẫu ban đầu nếu Session chưa có hoặc chưa đúng lớp Library
if (!isset($_SESSION['library']) || !($_SESSION['library'] instanceof Library)) {
    $lib = new Library();
    $lib->addDocument(new Book('B001', 'Lập trình PHP cơ bản', 'Nguyễn Văn A', 2023, 'Công nghệ thông tin', 320, 0.5, 'available'));
    $lib->addDocument(new Book('B002', 'Nhà Giả Kim', 'Paulo Coelho', 2020, 'Văn học', 228, 0.3, 'borrowed'));
    $lib->addDocument(new EBook('EB001', 'Clean Code Tiếng Việt', 'Robert C. Martin', 2022, 'Công nghệ thông tin', 15.2, 'PDF', 'available'));
    $lib->addDocument(new EBook('EB002', 'Lược Sử Loài Người', 'Yuval Noah Harari', 2021, 'Lịch sử', 8.5, 'EPUB', 'available'));
    $lib->addDocument(new Magazine('M001', 'Tạp chí Khoa học & Đời sống', 'Hội Khoa học VN', 2024, 'Khoa học', 15, 9, 'available'));
    $lib->addDocument(new Magazine('M002', 'Forbes Việt Nam', 'Forbes Media', 2024, 'Kinh tế', 120, 8, 'borrowed'));
    $_SESSION['library'] = $lib;
}

$library = $_SESSION['library'];
$message = '';
$error = '';

// 1. Xử lý Thêm mới (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_add'])) {
    try {
        $type = $_POST['type'];
        $id = trim($_POST['id']);
        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $year = (int)$_POST['year'];
        $category = trim($_POST['category']);
        $status = $_POST['status'];

        if ($id == '' || $title == '' || $author == '' || $category == '' || $year <= 0) {
            throw new Exception("Vui lòng điền đầy đủ các thông tin bắt buộc!");
        }

        if ($type == 'Book') {
            $pages = (int)$_POST['pages'];
            $weight = (float)$_POST['weight'];
            $newDoc = new Book($id, $title, $author, $year, $category, $pages, $weight, $status);
        } elseif ($type == 'EBook') {
            $fileSize = (float)$_POST['fileSize'];
            $format = trim($_POST['format']);
            $newDoc = new EBook($id, $title, $author, $year, $category, $fileSize, $format, $status);
        } elseif ($type == 'Magazine') {
            $issueNumber = (int)$_POST['issueNumber'];
            $month = (int)$_POST['month'];
            $newDoc = new Magazine($id, $title, $author, $year, $category, $issueNumber, $month, $status);
        }

        $library->addDocument($newDoc);
        $_SESSION['library'] = $library;
        $message = "Thêm thành công tài liệu: {$title} ({$id})";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// 2. Xử lý Mượn / Trả / Xóa (GET)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $act = $_GET['action'];
    $id = $_GET['id'];
    try {
        if ($act == 'borrow') {
            $library->borrowDocument($id);
            $message = "Đã mượn tài liệu {$id} thành công!";
        } elseif ($act == 'return') {
            $library->returnDocument($id);
            $message = "Đã trả tài liệu {$id} thành công!";
        } elseif ($act == 'delete') {
            $library->deleteDocument($id);
            $message = "Đã xóa tài liệu {$id} thành công!";
        }
        $_SESSION['library'] = $library;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// 3. Xử lý Tìm kiếm, Lọc và Sắp xếp
$keyword = $_GET['search'] ?? '';
$filterCat = $_GET['category'] ?? 'all';
$filterType = $_GET['type'] ?? 'all';
$filterStatus = $_GET['status'] ?? 'all';
$sortBy = $_GET['sort_by'] ?? 'title';
$sortOrder = $_GET['sort_order'] ?? 'asc';

$displayList = $library->documents;
$displayList = $library->search($keyword, $displayList);
$displayList = $library->filter($displayList, $filterCat, $filterType, $filterStatus);
$displayList = $library->sort($displayList, $sortBy, $sortOrder);

$stats = $library->getStatistics();

// Lấy danh sách thể loại để đưa vào dropdown lọc
$categories = [];
foreach ($library->documents as $d) {
    if (!in_array($d->getCategory(), $categories)) {
        $categories[] = $d->getCategory();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Thư Viện Đơn Giản</title>
    <style>
        /* CSS cơ bản giúp trang gọn gàng, không màu mè */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #333;
        }
        .container {
            max-width: 1050px;
            margin: 0 auto;
        }
        h2 {
            border-bottom: 2px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 12px;
        }
        .box {
            border: 1px solid #ccc;
            padding: 12px;
            margin-bottom: 15px;
        }
        /* Thông báo */
        .msg { padding: 8px; border: 1px solid #aaa; margin-bottom: 12px; }
        .msg-error { border-color: red; color: red; font-weight: bold; }
        /* Bảng */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .center {
            text-align: center;
        }
        /* Hàng form */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 8px;
            align-items: center;
        }
        input, select {
            padding: 5px;
            border: 1px solid #bbb;
        }
        /* Chỉ tô màu cho nút bấm */
        button, .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
        }
        .btn-blue { background-color: #007bff; }
        .btn-green { background-color: #28a745; }
        .btn-orange { background-color: #fd7e14; }
        .btn-red { background-color: #dc3545; }
        .btn-gray { background-color: #6c757d; }
    </style>
</head>
<body>

<div class="container">

    <h2>QUẢN LÝ THƯ VIỆN ĐƠN GIẢN (OOP PHP)</h2>

    <!-- Thông báo kết quả hoặc lỗi -->
    <?php if ($message): ?>
        <div class="msg"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="msg msg-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Khối 1: Thống kê số lượng -->
    <div class="box">
        <strong>Thống kê:</strong>
        Tổng số: <b><?= $stats['total'] ?></b> |
        Sách in: <b><?= $stats['book'] ?></b> |
        EBook: <b><?= $stats['ebook'] ?></b> |
        Tạp chí: <b><?= $stats['magazine'] ?></b> |
        Sẵn sàng mượn: <b><?= $stats['available'] ?></b> |
        Đang được mượn: <b><?= $stats['borrowed'] ?></b>
    </div>

    <!-- Khối 2: Form thêm tài liệu mới -->
    <div class="box">
        <strong>Thêm tài liệu mới:</strong>
        <form method="POST" style="margin-top: 10px;">
            <div class="row">
                <div>
                    Loại:
                    <select name="type" id="docType" onchange="doiLoai(this.value)">
                        <option value="Book">Sách in (Book)</option>
                        <option value="EBook">Sách điện tử (EBook)</option>
                        <option value="Magazine">Tạp chí (Magazine)</option>
                    </select>
                </div>
                <div>Mã ID: <input type="text" name="id" placeholder="VD: B003" required style="width: 80px;"></div>
                <div>Tiêu đề: <input type="text" name="title" placeholder="Tên tài liệu..." required style="width: 220px;"></div>
                <div>Tác giả: <input type="text" name="author" placeholder="Tác giả..." required style="width: 140px;"></div>
                <div>Năm XB: <input type="number" name="year" value="<?= date('Y') ?>" style="width: 70px;" required></div>
                <div>Thể loại: <input type="text" name="category" placeholder="Thể loại..." required style="width: 110px;"></div>
                <div>
                    Trạng thái:
                    <select name="status">
                        <option value="available">Sẵn sàng</option>
                        <option value="borrowed">Đang mượn</option>
                    </select>
                </div>
            </div>

            <!-- Thuộc tính riêng từng loại -->
            <div class="row" id="fieldBook">
                <div>Số trang: <input type="number" name="pages" value="200" style="width: 70px;"></div>
                <div>Khối lượng (kg): <input type="number" step="0.1" name="weight" value="0.4" style="width: 70px;"></div>
            </div>

            <div class="row" id="fieldEBook" style="display: none;">
                <div>Dung lượng (MB): <input type="number" step="0.1" name="fileSize" value="10.0" style="width: 70px;"></div>
                <div>
                    Định dạng:
                    <select name="format">
                        <option value="PDF">PDF</option>
                        <option value="EPUB">EPUB</option>
                        <option value="MOBI">MOBI</option>
                    </select>
                </div>
            </div>

            <div class="row" id="fieldMagazine" style="display: none;">
                <div>Số phát hành: <input type="number" name="issueNumber" value="1" style="width: 70px;"></div>
                <div>Tháng phát hành: <input type="number" name="month" value="<?= (int)date('m') ?>" min="1" max="12" style="width: 60px;"></div>
            </div>

            <div style="margin-top: 8px;">
                <button type="submit" name="btn_add" class="btn btn-green">Lưu tài liệu</button>
            </div>
        </form>
    </div>

    <!-- Khối 3: Tìm kiếm, lọc và sắp xếp -->
    <div class="box">
        <form method="GET">
            <div class="row">
                <div>
                    Tìm kiếm:
                    <input type="text" name="search" placeholder="Mã, tên, tác giả..." value="<?= htmlspecialchars($keyword) ?>" style="width: 180px;">
                </div>
                <div>
                    Thể loại:
                    <select name="category">
                        <option value="all">-- Tất cả --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>" <?= $filterCat == $cat ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    Loại:
                    <select name="type">
                        <option value="all">-- Tất cả --</option>
                        <option value="Book" <?= $filterType == 'Book' ? 'selected' : '' ?>>Sách in</option>
                        <option value="EBook" <?= $filterType == 'EBook' ? 'selected' : '' ?>>EBook</option>
                        <option value="Magazine" <?= $filterType == 'Magazine' ? 'selected' : '' ?>>Tạp chí</option>
                    </select>
                </div>
                <div>
                    Trạng thái:
                    <select name="status">
                        <option value="all">-- Tất cả --</option>
                        <option value="available" <?= $filterStatus == 'available' ? 'selected' : '' ?>>Sẵn sàng</option>
                        <option value="borrowed" <?= $filterStatus == 'borrowed' ? 'selected' : '' ?>>Đang mượn</option>
                    </select>
                </div>
                <div>
                    Sắp xếp theo:
                    <select name="sort_by">
                        <option value="title" <?= $sortBy == 'title' ? 'selected' : '' ?>>Tên tài liệu</option>
                        <option value="year" <?= $sortBy == 'year' ? 'selected' : '' ?>>Năm XB</option>
                    </select>
                    <select name="sort_order">
                        <option value="asc" <?= $sortOrder == 'asc' ? 'selected' : '' ?>>A-Z / Tăng</option>
                        <option value="desc" <?= $sortOrder == 'desc' ? 'selected' : '' ?>>Z-A / Giảm</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-blue">Tìm / Lọc</button>
                    <a href="index.php" class="btn btn-gray">Bỏ lọc</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Khối 4: Bảng danh sách tài liệu -->
    <div class="box">
        <strong>Danh sách tài liệu (<?= count($displayList) ?>):</strong>
        <table>
            <thead>
                <tr>
                    <th class="center" style="width: 60px;">Mã</th>
                    <th>Tiêu đề</th>
                    <th>Tác giả</th>
                    <th class="center" style="width: 70px;">Năm</th>
                    <th>Thể loại</th>
                    <th class="center" style="width: 80px;">Loại</th>
                    <th>Thuộc tính riêng</th>
                    <th class="center" style="width: 90px;">Trạng thái</th>
                    <th class="center" style="width: 130px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($displayList)): ?>
                    <tr>
                        <td colspan="9" class="center" style="padding: 15px;">Không tìm thấy tài liệu phù hợp!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($displayList as $doc): ?>
                        <tr>
                            <td class="center"><?= htmlspecialchars($doc->getId()) ?></td>
                            <td><b><?= htmlspecialchars($doc->getTitle()) ?></b></td>
                            <td><?= htmlspecialchars($doc->getAuthor()) ?></td>
                            <td class="center"><?= $doc->getYear() ?></td>
                            <td><?= htmlspecialchars($doc->getCategory()) ?></td>
                            <td class="center"><?= htmlspecialchars($doc->getType()) ?></td>
                            <td>
                                <?php if ($doc instanceof Book): ?>
                                    <?= $doc->getPages() ?> trang, <?= $doc->getWeight() ?> kg
                                <?php elseif ($doc instanceof EBook): ?>
                                    <?= $doc->getFileSize() ?> MB, file <?= htmlspecialchars($doc->getFormat()) ?>
                                <?php elseif ($doc instanceof Magazine): ?>
                                    Số #<?= $doc->getIssueNumber() ?>, tháng <?= $doc->getMonth() ?>
                                <?php endif; ?>
                            </td>
                            <td class="center">
                                <?= $doc->isAvailable() ? 'Sẵn sàng' : 'Đang mượn' ?>
                            </td>
                            <td class="center">
                                <?php if ($doc->isAvailable()): ?>
                                    <a href="index.php?action=borrow&id=<?= urlencode($doc->getId()) ?>" class="btn btn-green">Mượn</a>
                                <?php else: ?>
                                    <a href="index.php?action=return&id=<?= urlencode($doc->getId()) ?>" class="btn btn-orange">Trả</a>
                                <?php endif; ?>
                                <a href="index.php?action=delete&id=<?= urlencode($doc->getId()) ?>" 
                                   class="btn btn-red" 
                                   onclick="return confirm('Bạn muốn xóa tài liệu này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
    // Hàm JavaScript đơn giản đổi form nhập liệu theo loại
    function doiLoai(type) {
        document.getElementById('fieldBook').style.display = (type === 'Book') ? 'flex' : 'none';
        document.getElementById('fieldEBook').style.display = (type === 'EBook') ? 'flex' : 'none';
        document.getElementById('fieldMagazine').style.display = (type === 'Magazine') ? 'flex' : 'none';
    }
</script>

</body>
</html>
