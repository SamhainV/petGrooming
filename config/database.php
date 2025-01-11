<?php
class Database {
    private $host = "localhost";
    private $db_name = "pet_grooming_db";
    private $username = "root";
    private $password = "A29xxRamones";
    private $charset = "utf8mb4";

    private static $instance = null;
    private $pdo;

    // Constructor privado para evitar instancias múltiples
    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true // Conexión persistente
            ]);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }

    // Método estático para obtener la instancia única
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Método para obtener la conexión PDO
    public function getConnection() {
        return $this->pdo;
    }
}