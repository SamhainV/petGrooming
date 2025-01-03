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

    /**
     * Obtiene todos los registros de la tabla `appointment`.
     */
    public function findAll() {
        $sql = "SELECT * FROM appointment";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Appointment');
    }

    /**
     * Obtiene un registro de la tabla `appointment` por su ID.
     */
    public function findById($id) {
        $sql = "SELECT * FROM appointment WHERE appointment_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $appointment = $stmt->fetchObject('Appointment');
        return $appointment ?: null;
    }

    /**
     * Inserta un nuevo registro en la tabla `appointment`.
     * Retorna `true` si la inserción fue exitosa, `false` en caso contrario.
     */
    public function create() {
        $sql = "INSERT INTO appointment 
                (pet_id, date, time, description, store_id, status, assigned_employee_id)
                VALUES 
                (:pet_id, :date, :time, :description, :store_id, :status, :assigned_employee_id)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':pet_id', $this->pet_id, PDO::PARAM_INT);
        $stmt->bindValue(':date', $this->date);
        $stmt->bindValue(':time', $this->time);
        $stmt->bindValue(':description', $this->description);
        $stmt->bindValue(':store_id', $this->store_id, PDO::PARAM_INT);
        $stmt->bindValue(':status', $this->status);
        // Si assigned_employee_id es NULL, se puede enlazar con PDO::PARAM_INT o PDO::PARAM_NULL
        $stmt->bindValue(':assigned_employee_id', $this->assigned_employee_id, 
                         is_null($this->assigned_employee_id) ? PDO::PARAM_NULL : PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Actualiza los datos de la cita actual en la tabla `appointment`.
     * Retorna `true` si la actualización fue exitosa, `false` en caso contrario.
     */

     public function update() {
        $sql = "UPDATE appointment 
                SET pet_id = :pet_id, date = :date, time = :time, 
                    description = :description, status = :status, 
                    assigned_employee_id = :assigned_employee_id
                WHERE appointment_id = :appointment_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':appointment_id', $this->appointment_id, PDO::PARAM_INT);
        $stmt->bindValue(':pet_id', $this->pet_id, PDO::PARAM_INT);
        $stmt->bindValue(':date', $this->date);
        $stmt->bindValue(':time', $this->time);
        $stmt->bindValue(':description', $this->description);
        $stmt->bindValue(':status', $this->status);
        $stmt->bindValue(':assigned_employee_id', $this->assigned_employee_id ?: null, PDO::PARAM_INT);
        return $stmt->execute();
    }
    /**
     * Elimina un registro de la tabla `appointment` por su ID.
     * Retorna `true` si la eliminación fue exitosa, `false` en caso contrario.
     */
    public function delete($id) {
        $sql = "DELETE FROM appointment WHERE appointment_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function findAllWithDetails() {
        $sql = "SELECT a.*, 
                       p.name AS pet_name, 
                       e.name AS employee_name 
                FROM appointment a
                LEFT JOIN pet p ON a.pet_id = p.pet_id
                LEFT JOIN employee e ON a.assigned_employee_id = e.employee_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
}
