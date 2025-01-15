<?php
require_once __DIR__ . '/../config/database.php';

class Store {
    public $store_id;
    public $name;
    public $nif;
    public $street;
    public $postal_code;
    public $city;
    public $province;
    public $country;

    private $pdo;

    public function __construct() {
        $db = Database::getInstance(); // Utilizar el método estático
        $this->pdo = $db->getConnection(); // Obtener la conexión PDO
    }
    

    public function findAll() {
        $sql = "SELECT * FROM store";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Store');
    }

    public function findById($id) {
        $sql = "SELECT * FROM store WHERE store_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $store = $stmt->fetchObject('Store');
        return $store ?: null;
    }

    public function create() {
        $sql = "INSERT INTO store (name, nif, street, postal_code, city, province, country)
                VALUES (:name, :nif, :street, :postal_code, :city, :province, :country)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name',         $this->name);
        $stmt->bindValue(':nif',          $this->nif);
        $stmt->bindValue(':street',       $this->street);
        $stmt->bindValue(':postal_code',  $this->postal_code);
        $stmt->bindValue(':city',         $this->city);
        $stmt->bindValue(':province',     $this->province);
        $stmt->bindValue(':country',      $this->country);

        return $stmt->execute();
    }

    public function update() {
        $sql = "UPDATE store 
                SET name=:name, nif=:nif, street=:street, postal_code=:postal_code,
                    city=:city, province=:province, country=:country
                WHERE store_id=:store_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':store_id',     $this->store_id, PDO::PARAM_INT);
        $stmt->bindValue(':name',         $this->name);
        $stmt->bindValue(':nif',          $this->nif);
        $stmt->bindValue(':street',       $this->street);
        $stmt->bindValue(':postal_code',  $this->postal_code);
        $stmt->bindValue(':city',         $this->city);
        $stmt->bindValue(':province',     $this->province);
        $stmt->bindValue(':country',      $this->country);

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM store WHERE store_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function findByEmployeeId($employeeId) {
        $sql = "SELECT s.* 
                FROM store s
                JOIN employee_store es ON s.store_id = es.store_id
                WHERE es.employee_id = :employee_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':employee_id', $employeeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
}
