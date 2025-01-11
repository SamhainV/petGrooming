<?php
require_once __DIR__ . '/../config/database.php';

class Customer
{
    public $customer_id;
    public $name;
    public $last_name;
    public $second_last_name;
    public $address;
    public $email;
    public $store_id;

    public $phones = []; // Nuevo atributo para almacenar los teléfonos

    private $pdo;

    public function __construct()
    {
        // Utilizamos la conexión única del Singleton
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM customer";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Customer');
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM customer WHERE customer_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject('Customer') ?: null;
    }

    public function create()
    {
        $sql = "INSERT INTO customer (name, last_name, second_last_name, address, email, store_id)
                VALUES (:name, :last_name, :second_last_name, :address, :email, :store_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name',             $this->name);
        $stmt->bindValue(':last_name',        $this->last_name);
        $stmt->bindValue(':second_last_name', $this->second_last_name);
        $stmt->bindValue(':address',          $this->address);
        $stmt->bindValue(':email',            $this->email);
        $stmt->bindValue(':store_id',         $this->store_id, PDO::PARAM_INT);

        $stmt->execute();
        return $this->pdo->lastInsertId(); // Devolvemos el ID del cliente creado
    }

    public function update()
    {
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

    public function delete($id)
    {
        $sql = "DELETE FROM customer WHERE customer_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // ---------------------------
    // NUEVOS MÉTODOS para teléfonos
    // ---------------------------

    public function getPhonesByCustomerId($customer_id)
    {
        $sql = "SELECT * FROM customer_phone WHERE customer_id = :customer_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPhoneNumber($customer_id, $phone_number)
    {
        $sql = "INSERT INTO customer_phone (customer_id, phone_number)
                VALUES (:customer_id, :phone_number)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindValue(':phone_number', $phone_number);
        return $stmt->execute();
    }

    public function deleteAllPhones($customer_id)
    {
        $sql = "DELETE FROM customer_phone WHERE customer_id = :customer_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function createWithPhones($phoneNumbers)
    {
        try {
            $this->pdo->beginTransaction();

            $newId = $this->create();
            if (!$newId) {
                $this->pdo->rollBack();
                return false;
            }

            foreach ($phoneNumbers as $phone) {
                if (trim($phone) !== '') {
                    $this->addPhoneNumber($newId, $phone);
                }
            }

            $this->pdo->commit();
            return $newId;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function updateWithPhones($phoneNumbers)
    {
        try {
            $this->pdo->beginTransaction();

            $success = $this->update();
            if (!$success) {
                $this->pdo->rollBack();
                return false;
            }

            $this->deleteAllPhones($this->customer_id);

            foreach ($phoneNumbers as $phone) {
                if (trim($phone) !== '') {
                    $this->addPhoneNumber($this->customer_id, $phone);
                }
            }

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function findAllPaginated($offset, $limit) {
        $sql = "SELECT * FROM customer LIMIT :offset, :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        $customers = $stmt->fetchAll(PDO::FETCH_CLASS, 'Customer');
    
        // Obtener los teléfonos para cada cliente
        foreach ($customers as $customer) {
            $customer->phones = $this->getPhonesByCustomerId($customer->customer_id);
        }
    
        return $customers;
    }
    public function countAll() {
        $sql = "SELECT COUNT(*) AS total FROM customer";
        $stmt = $this->pdo->query($sql);
        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
}
