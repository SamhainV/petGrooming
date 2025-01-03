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

    /**
     * Obtiene todos los registros de la tabla pet.
     */

/**
 * Obtiene todos los registros de la tabla pet, incluyendo el nombre completo del dueño.
 */
public function findAll() {
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
        JOIN 
            customer c ON p.customer_id = c.customer_id
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

    /**
     * Obtiene un registro por su ID.
     */
    public function findById($id) {
        $sql = "SELECT * FROM pet WHERE pet_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $pet = $stmt->fetchObject('Pet');
        return $pet ?: null;
    }

    /**
     * Inserta un nuevo registro en la tabla pet.
     * Retorna true si el INSERT fue exitoso, false en caso contrario.
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
     * Retorna true si el UPDATE fue exitoso, false en caso contrario.
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
     * Retorna true si la eliminación fue exitosa, false en caso contrario.
     */
    public function delete($id) {
        $sql = "DELETE FROM pet WHERE pet_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
