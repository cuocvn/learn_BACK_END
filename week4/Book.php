<?php
require_once __DIR__ . '/Document.php';

/**
 * Lớp Book đại diện cho Sách in truyền thống
 */
class Book extends Document {
    private int $pages;      // Số trang
    private float $weight;   // Khối lượng (gram hoặc kg)

    public function __construct(
        string $id,
        string $title,
        string $author,
        int $year,
        string $category,
        int $pages,
        float $weight,
        string $status = 'available'
    ) {
        parent::__construct($id, $title, $author, $year, $category, $status);
        $this->pages = $pages;
        $this->weight = $weight;
    }

    public function getType(): string {
        return 'Book';
    }

    public function getPages(): int {
        return $this->pages;
    }

    public function setPages(int $pages): void {
        $this->pages = $pages;
    }

    public function getWeight(): float {
        return $this->weight;
    }

    public function setWeight(float $weight): void {
        $this->weight = $weight;
    }

    public function getSpecificDetails(): array {
        return [
            'pages' => $this->pages,
            'weight' => $this->weight
        ];
    }
}
