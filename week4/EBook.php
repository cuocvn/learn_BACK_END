<?php
require_once __DIR__ . '/Document.php';

/**
 * Lớp EBook đại diện cho Sách điện tử
 */
class EBook extends Document {
    private float $fileSize; // Dung lượng tệp (MB)
    private string $format;  // Định dạng tệp (PDF, EPUB, MOBI,...)

    public function __construct(
        string $id,
        string $title,
        string $author,
        int $year,
        string $category,
        float $fileSize,
        string $format,
        string $status = 'available'
    ) {
        parent::__construct($id, $title, $author, $year, $category, $status);
        $this->fileSize = $fileSize;
        $this->format = trim($format);
    }

    public function getType(): string {
        return 'EBook';
    }

    public function getFileSize(): float {
        return $this->fileSize;
    }

    public function setFileSize(float $fileSize): void {
        $this->fileSize = $fileSize;
    }

    public function getFormat(): string {
        return $this->format;
    }

    public function setFormat(string $format): void {
        $this->format = trim($format);
    }

    public function getSpecificDetails(): array {
        return [
            'fileSize' => $this->fileSize,
            'format' => $this->format
        ];
    }
}
