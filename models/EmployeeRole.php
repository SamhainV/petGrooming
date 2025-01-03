<?php
require_once __DIR__ . '/../config/database.php';

class EmployeeRole {
    public $employee_role_id;
    public $employee_id;
    public $role_id;

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    /**
     * Encuentra todos los roles asignados a empleados.
     */
    public function findAll() {
        $sql = "SELECT * FROM employee_role";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'EmployeeRole');
    }

    /**
     * Encuentra un registro por su ID.
     */
    public function findById($id) {
        $sql = "SELECT * FROM employee_role WHERE employee_role_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $employeeRole = $stmt->fetchObject('EmployeeRole');
        return $employeeRole ?: null;
    }

    /**
     * Crea (inserta) un nuevo registro.
     */
    public function create() {
        $sql = "INSERT INTO employee_role (employee_id, role_id) VALUES (:employee_id, :role_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':employee_id', $this->employee_id, PDO::PARAM_INT);
        $stmt->bindValue(':role_id', $this->role_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Elimina un registro por su ID.
     */
    public function delete($id) {
        $sql = "DELETE FROM employee_role WHERE employee_role_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Encuentra todos los roles de un empleado.
     */
    public function findRolesByEmployee($employee_id) {
        $sql = "SELECT r.* FROM role r
                JOIN employee_role er ON r.role_id = er.role_id
                WHERE er.employee_id = :employee_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Role');
    }
}
