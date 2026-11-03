<?php
require_once __DIR__ . '/Document.php';

/**
 * Lớp Magazine đại diện cho Tạp chí định kỳ
 */
class Magazine extends Document {
    private int $issueNumber; // Số phát hành
    private int $month;       // Tháng phát hành (1-12)

    public function __construct(
        string $id,
        string $title,
        string $author,
        int $year,
        string $category,
        int $issueNumber,
        int $month,
        string $status = 'available'
    ) {
        parent::__construct($id, $title, $author, $year, $category, $status);
        $this->issueNumber = $issueNumber;
        $this->month = $month;
    }

    public function getType(): string {
        return 'Magazine';
    }

    public function getIssueNumber(): int {
        return $this->issueNumber;
    }

    public function setIssueNumber(int $issueNumber): void {
        $this->issueNumber = $issueNumber;
    }

    public function getMonth(): int {
        return $this->month;
    }

    public function setMonth(int $month): void {
        $this->month = $month;
    }

    public function getSpecificDetails(): array {
        return [
            'issueNumber' => $this->issueNumber,
            'month' => $this->month
        ];
    }
}
