<?php
require_once __DIR__ . '/../config/database.php';

class Customer {
    public $customer_id;
    public $name;
    public $last_name;
    public $second_last_name;
    public $address;
    public $email;
    public $store_id;

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function findAll() {
        $sql = "SELECT * FROM customer";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Customer');
    }

    public function findById($id) {
        $sql = "SELECT * FROM customer WHERE customer_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $customer = $stmt->fetchObject('Customer');
        return $customer ?: null;
    }

    public function create() {
        $sql = "INSERT INTO customer (name, last_name, second_last_name, address, email, store_id)
                VALUES (:name, :last_name, :second_last_name, :address, :email, :store_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name',             $this->name);
        $stmt->bindValue(':last_name',        $this->last_name);
        $stmt->bindValue(':second_last_name', $this->second_last_name);
        $stmt->bindValue(':address',          $this->address);
        $stmt->bindValue(':email',            $this->email);
        $stmt->bindValue(':store_id',         $this->store_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update() {
        $sql = "UPDATE customer 
                SET name=:name, last_name=:last_name, second_last_name=:second_last_name,
                    address=:address, email=:email, store_id=:store_id
                WHERE customer_id=:customer_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':customer_id',      $this->customer_id, PDO::PARAM_INT);
        $stmt->bindValue(':name',             $this->name);
        $stmt->bindValue(':last_name',        $this->last_name);
        $stmt->bindValue(':second_last_name', $this->second_last_name);
        $stmt->bindValue(':address',          $this->address);
        $stmt->bindValue(':email',            $this->email);
        $stmt->bindValue(':store_id',         $this->store_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM customer WHERE customer_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
