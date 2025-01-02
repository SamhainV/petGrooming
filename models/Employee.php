<?php
require_once __DIR__ . '/../config/database.php';

class Employee {
    public $employee_id;
    public $name;
    public $email;
    public $password;

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // Ejemplo: búsqueda por email para login
    public function findByEmail($email) {
        $sql = "SELECT * FROM employee WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetchObject('Employee');
    }

    // ... findAll, findById, create, update, delete, etc.
}
