<?php
require_once __DIR__ . '/config.php';

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
        $this->conn->set_charset(DB_CHARSET);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function select($query, $types = "", $params = []) {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        return $data;
    }

    public function execute($query, $types = "", $params = []) {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $success = $stmt->execute();
        if (!$success) {
            echo "Lỗi truy vấn: " . $stmt->error;
        }
        $stmt->close();
        return $success;
    }
}
?>