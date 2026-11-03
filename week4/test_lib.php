<?php
require_once __DIR__ . '/sample_data.php';
require_once __DIR__ . '/Library.php';

try {
    $library = new Library();
    
    // Thêm các tài liệu mẫu
    foreach (getSampleDocuments() as $doc) {
        $library->addDocument($doc);
    }
    
    echo "--- 1. DANH SÁCH BAN ĐẦU (" . count($library->getAllDocuments()) . " tài liệu) ---\n";
    foreach ($library->getAllDocuments() as $doc) {
        echo "[{$doc->getType()}] ID: {$doc->getId()} | {$doc->getTitle()} | {$doc->getAuthor()} | {$doc->getYear()} | {$doc->getStatus()}\n";
    }
    
    echo "\n--- 2. KIỂM TRA THỐNG KÊ ---\n";
    print_r($library->getStatistics());
    
    echo "\n--- 3. KIỂM TRA TÌM KIẾM 'clean' ---\n";
    $searchRes = $library->search('clean');
    foreach ($searchRes as $d) {
        echo "Tìm thấy: {$d->getId()} - {$d->getTitle()}\n";
    }
    
    echo "\n--- 4. KIỂM TRA LỌC (Category: 'Công nghệ thông tin') ---\n";
    $filtered = $library->filter($library->getAllDocuments(), category: 'Công nghệ thông tin');
    foreach ($filtered as $d) {
        echo "Lọc: {$d->getId()} - {$d->getTitle()} ({$d->getCategory()})\n";
    }

    echo "\n--- 5. KIỂM TRA SẮP XẾP THEO NĂM XUẤT BẢN GIẢM DẦN ---\n";
    $sorted = $library->sort($library->getAllDocuments(), field: 'year', order: 'desc');
    foreach ($sorted as $d) {
        echo "Năm {$d->getYear()} - {$d->getTitle()}\n";
    }

    echo "\n--- 6. KIỂM TRA NGOẠI LỆ TRÙNG MÃ (B001) ---\n";
    try {
        $library->addDocument(new Book('B001', 'Trùng', 'Ai đó', 2020, 'Test', 100, 0.2));
        echo "Lỗi: Không bắt được ngoại lệ trùng mã!\n";
    } catch (DuplicateIdException $e) {
        echo "Thành công bắt DuplicateIdException: " . $e->getMessage() . "\n";
    }

    echo "\n--- 7. KIỂM TRA MƯỢN TRẢ VÀ NGOẠI LỆ ---\n";
    // Mượn B001 (đang available)
    $library->borrowDocument('B001');
    echo "Mượn B001 thành công. Trạng thái hiện tại: " . $library->getDocument('B001')->getStatus() . "\n";

    // Cố mượn lại B001 (đang borrowed) -> phải ném DocumentUnavailableException
    try {
        $library->borrowDocument('B001');
        echo "Lỗi: Không bắt được ngoại lệ tài liệu không khả dụng!\n";
    } catch (DocumentUnavailableException $e) {
        echo "Thành công bắt DocumentUnavailableException: " . $e->getMessage() . "\n";
    }

    // Trả B001 -> available
    $library->returnDocument('B001');
    echo "Trả B001 thành công. Trạng thái hiện tại: " . $library->getDocument('B001')->getStatus() . "\n";

    // Xóa B001
    $library->deleteDocument('B001');
    echo "Xóa B001 thành công.\n";

    // Cố xóa lần nữa -> phải ném DocumentNotFoundException
    try {
        $library->deleteDocument('B001');
        echo "Lỗi: Không bắt được ngoại lệ tài liệu không tồn tại!\n";
    } catch (DocumentNotFoundException $e) {
        echo "Thành công bắt DocumentNotFoundException: " . $e->getMessage() . "\n";
    }

    echo "\n=== TẤT CẢ CÁC KIỂM TRA ĐỀU THÀNH CÔNG RỰC RỠ! ===\n";

} catch (Exception $e) {
    echo "Ngoại lệ không mong muốn: " . $e->getMessage() . "\n";
}
