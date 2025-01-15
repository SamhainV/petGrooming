<?php
require_once __DIR__ . '/../config/database.php';

class Employee {
    public $employee_id;
    public $name;
    public $email;
    public $password;

    private $pdo;


    public function __construct() {
        $db = Database::getInstance(); // Utilizar el método estático
        $this->pdo = $db->getConnection(); // Obtener la conexión PDO
    }

    /**
     * Encuentra todos los empleados.
     */
    public function findAll() {
        $sql = "SELECT * FROM employee";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Employee');
    }

    /**
     * Encuentra un empleado por ID.
     */
    public function findById($id) {
        $sql = "SELECT * FROM employee WHERE employee_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $employee = $stmt->fetchObject('Employee');
        return $employee ?: null;
    }

    /**
     * Encuentra un empleado por email (p.ej. para login).
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM employee WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    /**
     * Crea (inserta) un nuevo empleado en la base de datos.
     */
    public function create() {
        $sql = "INSERT INTO employee (name, email, password)
                VALUES (:name, :email, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':email', $this->email);
        // En un entorno real, usarías password_hash() antes de guardar
        $stmt->bindValue(':password', $this->password);

        return $stmt->execute();
    }

    /**
     * Actualiza la información del empleado en la base de datos.
     */
    public function update() {
        $sql = "UPDATE employee 
                SET name = :name, email = :email, password = IF(:password IS NOT NULL, :password, password)
                WHERE employee_id = :employee_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':employee_id', $this->employee_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':email', $this->email);
    
        // Maneja el caso de contraseña vacía
        $stmt->bindValue(':password', isset($this->password) ? $this->password : null);
    
        return $stmt->execute();
    }
    
    /**
     * Elimina a un empleado por su ID.
     */
    public function delete($id) {
        $sql = "DELETE FROM employee WHERE employee_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function findAllExcludingAdmin() {
        $sql = "
            SELECT e.*
            FROM employee e
            JOIN employee_role er ON e.employee_id = er.employee_id
            JOIN role r ON er.role_id = r.role_id
            WHERE r.name != 'admin'
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Employee');
    }
    
}
