<?php
/**
 * Interface Borrowable định nghĩa các phương thức cho chức năng mượn và trả tài liệu
 */
interface Borrowable {
    /**
     * Mượn tài liệu
     * @return bool True nếu mượn thành công, false nếu thất bại
     */
    public function borrow(): bool;

    /**
     * Trả tài liệu
     * @return bool True nếu trả thành công, false nếu thất bại
     */
    public function returnDocument(): bool;

    /**
     * Kiểm tra tài liệu có đang sẵn sàng để mượn không
     * @return bool
     */
    public function isAvailable(): bool;
}
