<?php
/**
 * Các lớp ngoại lệ tùy chỉnh cho hệ thống quản lý thư viện
 */

class LibraryException extends Exception {}

/**
 * Ngoại lệ khi mã tài liệu bị trùng lặp
 */
class DuplicateIdException extends LibraryException {
    public function __construct(string $id, int $code = 0, ?Throwable $previous = null) {
        parent::__construct("Lỗi: Mã tài liệu '{$id}' đã tồn tại trong thư viện!", $code, $previous);
    }
}

/**
 * Ngoại lệ khi không tìm thấy tài liệu
 */
class DocumentNotFoundException extends LibraryException {
    public function __construct(string $id, int $code = 0, ?Throwable $previous = null) {
        parent::__construct("Lỗi: Không tìm thấy tài liệu với mã '{$id}'!", $code, $previous);
    }
}

/**
 * Ngoại lệ khi tài liệu không khả dụng (ví dụ đã được mượn hoặc không thể mượn)
 */
class DocumentUnavailableException extends LibraryException {
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null) {
        parent::__construct("Lỗi trạng thái tài liệu: {$message}", $code, $previous);
    }
}
