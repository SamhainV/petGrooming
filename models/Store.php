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
        // Crear la conexión a la base de datos
        $db = new Database();
        $this->pdo = $db->getConnection();
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
}
