<?php
require_once __DIR__ . '/../config/database.php';

class Pet {
    public $pet_id;
    public $name;
    public $age;
    public $customer_id;
    public $type; // 'dog' o 'cat'
    public $photo;

    private $pdo;

    public function __construct() {
        $db = Database::getInstance(); // Utilizar el método estático
        $this->pdo = $db->getConnection(); // Obtener la conexión PDO
    }    
    
    /**
     * Obtiene todos los registros de la tabla pet, incluyendo el nombre completo del dueño.
     */
    public function findAll() {
        $sql = "
            SELECT 
                p.*, 
                CONCAT(c.name, ' ', c.last_name, ' ', c.second_last_name) AS owner_name
            FROM 
                pet p
            LEFT JOIN 
                customer c ON p.customer_id = c.customer_id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Obtiene un registro por su ID y devuelve una instancia de `Pet`.
     */
    public function findById($id) {
        $sql = "
            SELECT 
                * 
            FROM 
                pet
            WHERE 
                pet_id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $pet = new self();
            $pet->pet_id = $data['pet_id'];
            $pet->name = $data['name'];
            $pet->age = $data['age'];
            $pet->customer_id = $data['customer_id'];
            $pet->type = $data['type'];
            $pet->photo = $data['photo'];
            return $pet;
        }

        return null;
    }

    /**
     * Inserta un nuevo registro en la tabla pet.
     */
    public function create() {
        $sql = "INSERT INTO pet (name, age, customer_id, type, photo)
                VALUES (:name, :age, :customer_id, :type, :photo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name',         $this->name);
        $stmt->bindValue(':age',          $this->age, PDO::PARAM_INT);
        $stmt->bindValue(':customer_id',  $this->customer_id, PDO::PARAM_INT);
        $stmt->bindValue(':type',         $this->type);
        $stmt->bindValue(':photo',        $this->photo);
        return $stmt->execute();
    }

    /**
     * Actualiza los datos de la mascota actual en la tabla pet.
     */
    public function update() {
        $sql = "UPDATE pet 
                SET name = :name, 
                    age = :age,
                    customer_id = :customer_id,
                    type = :type,
                    photo = :photo
                WHERE pet_id = :pet_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':pet_id',       $this->pet_id, PDO::PARAM_INT);
        $stmt->bindValue(':name',         $this->name);
        $stmt->bindValue(':age',          $this->age, PDO::PARAM_INT);
        $stmt->bindValue(':customer_id',  $this->customer_id, PDO::PARAM_INT);
        $stmt->bindValue(':type',         $this->type);
        $stmt->bindValue(':photo',        $this->photo);
        return $stmt->execute();
    }

    /**
     * Elimina un registro de la tabla pet por su ID.
     */
    public function delete($id) {
        $sql = "DELETE FROM pet WHERE pet_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Encuentra todas las mascotas de un cliente específico.
     */

     public function findByCustomerId($customer_id) {
        $sql = "
            SELECT 
                p.pet_id, 
                p.name, 
                p.age, 
                p.type, 
                p.photo, 
                CONCAT(c.name, ' ', c.last_name, ' ', c.second_last_name) AS owner_name
            FROM 
                pet p
            LEFT JOIN 
                customer c ON p.customer_id = c.customer_id
            WHERE 
                p.customer_id = :customer_id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}
