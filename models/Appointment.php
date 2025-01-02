<?php
require_once __DIR__ . '/../config/database.php';

class Appointment {
    public $appointment_id;
    public $pet_id;
    public $date;
    public $time;
    public $description;
    public $store_id;
    public $status;                // 'pending', 'completed', 'canceled'
    public $assigned_employee_id;  // puede ser NULL

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function findAll() {
        $sql = "SELECT * FROM appointment";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Appointment');
    }

    // ... findById, create, update, delete, etc.
}
