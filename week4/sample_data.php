<?php
require_once __DIR__ . '/Book.php';
require_once __DIR__ . '/EBook.php';
require_once __DIR__ . '/Magazine.php';

/**
 * Khởi tạo 6 tài liệu mẫu ban đầu (2 Sách, 2 Ebook, 2 Tạp chí)
 */
function getSampleDocuments() {
    return [
        // 2 Sách in (Book: id, title, author, year, category, pages, weight, status)
        new Book('B001', 'Lập trình hướng đối tượng PHP & MySQL', 'Nguyễn Văn An', 2023, 'Công nghệ thông tin', 350, 0.55, 'available'),
        new Book('B002', 'Nhà Giả Kim', 'Paulo Coelho', 2020, 'Văn học', 228, 0.35, 'borrowed'),

        // 2 Sách điện tử (EBook: id, title, author, year, category, fileSize, format, status)
        new EBook('EB001', 'Clean Code - Mã Sạch', 'Robert C. Martin', 2022, 'Công nghệ thông tin', 12.5, 'PDF', 'available'),
        new EBook('EB002', 'Lược Sử Loài Người', 'Yuval Noah Harari', 2021, 'Lịch sử', 8.2, 'EPUB', 'available'),

        // 2 Tạp chí (Magazine: id, title, author, year, category, issueNumber, month, status)
        new Magazine('M001', 'Tạp chí Khoa học & Đời sống', 'Bộ Khoa học Công nghệ', 2024, 'Khoa học', 18, 9, 'available'),
        new Magazine('M002', 'Forbes Việt Nam', 'Forbes Media', 2024, 'Kinh tế', 125, 8, 'borrowed')
    ];
}
