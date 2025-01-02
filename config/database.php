<?php
class Database {
    private $host = "localhost";
    private $db_name = "pet_grooming_db";
    private $username = "root";
    private $password = "A29xxRamones";
    private $charset = "utf8mb4";

    public $pdo;

    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
