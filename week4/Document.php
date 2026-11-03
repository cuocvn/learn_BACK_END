<?php
require_once __DIR__ . '/Borrowable.php';

/**
 * Lớp trừu tượng Document quản lý các thuộc tính và phương thức chung của tài liệu
 */
abstract class Document implements Borrowable {
    protected string $id;
    protected string $title;
    protected string $author;
    protected int $year;
    protected string $category;
    protected string $status; // 'available' hoặc 'borrowed'

    public function __construct(
        string $id,
        string $title,
        string $author,
        int $year,
        string $category,
        string $status = 'available'
    ) {
        $this->id = trim($id);
        $this->title = trim($title);
        $this->author = trim($author);
        $this->year = $year;
        $this->category = trim($category);
        $this->status = in_array(strtolower($status), ['available', 'borrowed']) ? strtolower($status) : 'available';
    }

    /**
     * Phương thức trừu tượng trả về loại tài liệu (Book, EBook, Magazine,...)
     */
    abstract public function getType(): string;

    /**
     * Phương thức trừu tượng trả về các thông số chi tiết đặc thù của từng loại
     */
    abstract public function getSpecificDetails(): array;

    // Getters
    public function getId(): string {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function getYear(): int {
        return $this->year;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getStatus(): string {
        return $this->status;
    }

    // Setters
    public function setTitle(string $title): void {
        $this->title = trim($title);
    }

    public function setAuthor(string $author): void {
        $this->author = trim($author);
    }

    public function setYear(int $year): void {
        $this->year = $year;
    }

    public function setCategory(string $category): void {
        $this->category = trim($category);
    }

    public function setStatus(string $status): void {
        if (in_array(strtolower($status), ['available', 'borrowed'])) {
            $this->status = strtolower($status);
        }
    }

    // Triển khai các phương thức từ interface Borrowable
    public function borrow(): bool {
        if (!$this->isAvailable()) {
            return false;
        }
        $this->status = 'borrowed';
        return true;
    }

    public function returnDocument(): bool {
        if ($this->isAvailable()) {
            return false;
        }
        $this->status = 'available';
        return true;
    }

    public function isAvailable(): bool {
        return $this->status === 'available';
    }

    /**
     * Chuyển đổi đối tượng sang mảng kết hợp để dễ dàng hiển thị hoặc lưu trữ
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'year' => $this->year,
            'category' => $this->category,
            'status' => $this->status,
            'type' => $this->getType(),
            'specific' => $this->getSpecificDetails()
        ];
    }
}
