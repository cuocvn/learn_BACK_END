<?php
require_once __DIR__ . '/Borrowable.php';
require_once __DIR__ . '/Exceptions.php';
require_once __DIR__ . '/Document.php';
require_once __DIR__ . '/Book.php';
require_once __DIR__ . '/EBook.php';
require_once __DIR__ . '/Magazine.php';

/**
 * Lớp Library quản lý danh sách các tài liệu trong thư viện
 * Viết bằng thuật toán cơ bản, dễ hiểu
 */
class Library {
    // Mảng danh sách các tài liệu
    private $documents = [];

    /**
     * Tìm tài liệu theo mã ID
     */
    public function getDocument($id) {
        foreach ($this->documents as $doc) {
            if ($doc->getId() == $id) {
                return $doc;
            }
        }
        return null;
    }

    /**
     * Kiểm tra xem mã tài liệu đã tồn tại hay chưa
     */
    public function hasDocument($id) {
        return $this->getDocument($id) !== null;
    }

    /**
     * Lấy toàn bộ danh sách tài liệu
     */
    public function getAllDocuments() {
        return $this->documents;
    }

    /**
     * Thêm tài liệu mới vào danh sách
     */
    public function addDocument(Document $document) {
        $id = $document->getId();
        // Kiểm tra trùng mã
        if ($this->hasDocument($id)) {
            throw new DuplicateIdException($id);
        }
        $this->documents[] = $document;
    }

    /**
     * Xóa tài liệu theo mã ID
     */
    public function deleteDocument($id) {
        foreach ($this->documents as $index => $doc) {
            if ($doc->getId() == $id) {
                // Xóa phần tử tại vị trí $index
                array_splice($this->documents, $index, 1);
                return true;
            }
        }
        // Nếu duyệt hết mảng mà không thấy mã thì báo lỗi
        throw new DocumentNotFoundException($id);
    }

    /**
     * Chức năng mượn tài liệu
     */
    public function borrowDocument($id) {
        $doc = $this->getDocument($id);
        if ($doc === null) {
            throw new DocumentNotFoundException($id);
        }

        if (!$doc->isAvailable()) {
            throw new DocumentUnavailableException("Tài liệu '{$doc->getTitle()}' đang có người mượn!");
        }

        return $doc->borrow();
    }

    /**
     * Chức năng trả tài liệu
     */
    public function returnDocument($id) {
        $doc = $this->getDocument($id);
        if ($doc === null) {
            throw new DocumentNotFoundException($id);
        }

        if ($doc->isAvailable()) {
            throw new DocumentUnavailableException("Tài liệu '{$doc->getTitle()}' đang ở trạng thái sẵn sàng, không cần trả!");
        }

        return $doc->returnDocument();
    }

    /**
     * Thuật toán tìm kiếm cơ bản: duyệt qua từng phần tử,
     * so sánh từ khóa với Mã ID, Tiêu đề hoặc Tác giả
     */
    public function search($keyword, $sourceList = null) {
        $source = $sourceList ?? $this->documents;
        $keyword = trim($keyword);

        if ($keyword == '') {
            return $source;
        }

        $ketQua = [];
        foreach ($source as $doc) {
            // stripos: tìm chuỗi không phân biệt hoa thường
            $timThayTrongMa = stripos($doc->getId(), $keyword) !== false;
            $timThayTrongTieuDe = stripos($doc->getTitle(), $keyword) !== false;
            $timThayTrongTacGia = stripos($doc->getAuthor(), $keyword) !== false;

            if ($timThayTrongMa || $timThayTrongTieuDe || $timThayTrongTacGia) {
                $ketQua[] = $doc;
            }
        }

        return $ketQua;
    }

    /**
     * Thuật toán lọc đơn giản: duyệt qua danh sách, kiểm tra điều kiện bằng if
     */
    public function filter($sourceList, $category = null, $type = null, $status = null) {
        $ketQua = [];
        foreach ($sourceList as $doc) {
            // Lọc thể loại
            if (!empty($category) && $category != 'all' && $doc->getCategory() != $category) {
                continue;
            }
            // Lọc loại tài liệu (Book, EBook, Magazine)
            if (!empty($type) && $type != 'all' && $doc->getType() != $type) {
                continue;
            }
            // Lọc trạng thái (available, borrowed)
            if (!empty($status) && $status != 'all' && $doc->getStatus() != $status) {
                continue;
            }

            $ketQua[] = $doc;
        }
        return $ketQua;
    }

    /**
     * Thuật toán sắp xếp đơn giản (Đổi chỗ trực tiếp - Selection Sort)
     * Thường được học trong môn Cơ sở lập trình / Cấu trúc dữ liệu
     */
    public function sort($sourceList, $field = 'title', $order = 'asc') {
        $danhSach = $sourceList;
        $soLuong = count($danhSach);

        for ($i = 0; $i < $soLuong - 1; $i++) {
            for ($j = $i + 1; $j < $soLuong; $j++) {
                $canDoiCho = false;

                if ($field == 'year') {
                    // Sắp xếp theo năm xuất bản
                    if ($order == 'asc') {
                        if ($danhSach[$i]->getYear() > $danhSach[$j]->getYear()) {
                            $canDoiCho = true;
                        }
                    } else {
                        if ($danhSach[$i]->getYear() < $danhSach[$j]->getYear()) {
                            $canDoiCho = true;
                        }
                    }
                } else {
                    // Mặc định sắp xếp theo tên tài liệu (strcasecmp so sánh 2 chuỗi)
                    $soSanhChuoi = strcasecmp($danhSach[$i]->getTitle(), $danhSach[$j]->getTitle());
                    if ($order == 'asc') {
                        if ($soSanhChuoi > 0) {
                            $canDoiCho = true;
                        }
                    } else {
                        if ($soSanhChuoi < 0) {
                            $canDoiCho = true;
                        }
                    }
                }

                // Thực hiện hoán vị 2 phần tử
                if ($canDoiCho) {
                    $tam = $danhSach[$i];
                    $danhSach[$i] = $danhSach[$j];
                    $danhSach[$j] = $tam;
                }
            }
        }

        return $danhSach;
    }

    /**
     * Lấy danh sách các thể loại có trong thư viện
     */
    public function getCategories() {
        $theLoai = [];
        foreach ($this->documents as $doc) {
            $cat = $doc->getCategory();
            if (!in_array($cat, $theLoai)) {
                $theLoai[] = $cat;
            }
        }
        return $theLoai;
    }

    /**
     * Thuật toán thống kê: dùng các biến đếm đơn giản
     */
    public function getStatistics() {
        $tongSo = count($this->documents);
        $demSach = 0;
        $demEbook = 0;
        $demTapChi = 0;
        $demSanSang = 0;
        $demDangMuon = 0;

        foreach ($this->documents as $doc) {
            // Đếm theo từng loại
            if ($doc->getType() == 'Book') {
                $demSach++;
            } elseif ($doc->getType() == 'EBook') {
                $demEbook++;
            } elseif ($doc->getType() == 'Magazine') {
                $demTapChi++;
            }

            // Đếm theo trạng thái
            if ($doc->isAvailable()) {
                $demSanSang++;
            } else {
                $demDangMuon++;
            }
        }

        return [
            'total' => $tongSo,
            'by_type' => [
                'Book' => $demSach,
                'EBook' => $demEbook,
                'Magazine' => $demTapChi
            ],
            'by_status' => [
                'available' => $demSanSang,
                'borrowed' => $demDangMuon
            ]
        ];
    }

    /**
     * Nạp dữ liệu từ mảng
     */
    public function loadFromArray($list) {
        $this->documents = [];
        foreach ($list as $item) {
            if ($item instanceof Document) {
                $this->documents[] = $item;
            } elseif (is_array($item)) {
                $type = $item['type'] ?? '';
                $id = $item['id'] ?? '';
                $title = $item['title'] ?? '';
                $author = $item['author'] ?? '';
                $year = (int)($item['year'] ?? 0);
                $category = $item['category'] ?? '';
                $status = $item['status'] ?? 'available';

                if ($type == 'Book') {
                    $pages = (int)($item['pages'] ?? 0);
                    $weight = (float)($item['weight'] ?? 0);
                    $this->documents[] = new Book($id, $title, $author, $year, $category, $pages, $weight, $status);
                } elseif ($type == 'EBook') {
                    $fileSize = (float)($item['fileSize'] ?? 0);
                    $format = $item['format'] ?? 'PDF';
                    $this->documents[] = new EBook($id, $title, $author, $year, $category, $fileSize, $format, $status);
                } elseif ($type == 'Magazine') {
                    $issueNumber = (int)($item['issueNumber'] ?? 1);
                    $month = (int)($item['month'] ?? 1);
                    $this->documents[] = new Magazine($id, $title, $author, $year, $category, $issueNumber, $month, $status);
                }
            }
        }
    }

    /**
     * Chuyển danh sách tài liệu thành mảng để lưu Session
     */
    public function toArray() {
        $result = [];
        foreach ($this->documents as $doc) {
            $data = [
                'id' => $doc->getId(),
                'title' => $doc->getTitle(),
                'author' => $doc->getAuthor(),
                'year' => $doc->getYear(),
                'category' => $doc->getCategory(),
                'status' => $doc->getStatus(),
                'type' => $doc->getType()
            ];

            if ($doc instanceof Book) {
                $data['pages'] = $doc->getPages();
                $data['weight'] = $doc->getWeight();
            } elseif ($doc instanceof EBook) {
                $data['fileSize'] = $doc->getFileSize();
                $data['format'] = $doc->getFormat();
            } elseif ($doc instanceof Magazine) {
                $data['issueNumber'] = $doc->getIssueNumber();
                $data['month'] = $doc->getMonth();
            }

            $result[] = $data;
        }
        return $result;
    }
}
