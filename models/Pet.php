<?php
require_once __DIR__ . '/../config/database.php';

class Pet {
    public $pet_id;
    public $name;
    public $age;
    public $customer_id;
    public $type;  // 'dog' o 'cat'
    public $photo;

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function findAll() {
        $sql = "SELECT * FROM pet";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Pet');
    }

    // ... findById, create, update, delete, etc.
}
