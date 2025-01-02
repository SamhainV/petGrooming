<?php
require_once __DIR__ . '/../config/database.php';

class Role {
    public $role_id;
    public $name;  // 'admin', 'user', etc.

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function findAll() {
        $sql = "SELECT * FROM role";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Role');
    }

    // ... findById, create, update, delete...
}
