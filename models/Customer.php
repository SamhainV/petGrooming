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
        $db = new Database();
        $this->pdo = $db->getConnection();
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
        $customer = $stmt->fetchObject('Customer');
        return $customer ?: null;
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

        return $stmt->execute();
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

    /**
     * Obtener todos los teléfonos de un cliente.
     */
    public function getPhonesByCustomerId($customer_id)
    {
        $sql = "SELECT * FROM customer_phone WHERE customer_id = :customer_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Añadir un teléfono a un cliente.
     */
    public function addPhoneNumber($customer_id, $phone_number)
    {
        $sql = "INSERT INTO customer_phone (customer_id, phone_number)
                VALUES (:customer_id, :phone_number)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindValue(':phone_number', $phone_number);
        return $stmt->execute();
    }

    /**
     * Eliminar todos los teléfonos de un cliente (si deseas hacerlo).
     */
    public function deleteAllPhones($customer_id)
    {
        $sql = "DELETE FROM customer_phone WHERE customer_id = :customer_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Método para crear cliente + teléfonos en una sola operación.
     * - Retorna true/false según el éxito de la transacción.
     */
    public function createWithPhones($phoneNumbers)
    {
        try {
            // Iniciamos transacción
            $this->pdo->beginTransaction();

            // Creamos el cliente
            $newId = $this->create();
            if (!$newId) {
                // Si falla la creación del cliente, hacemos rollback
                $this->pdo->rollBack();
                return false;
            }

            // Insertamos cada teléfono
            if (!empty($phoneNumbers)) {
                foreach ($phoneNumbers as $phone) {
                    // Evitar insertar valores vacíos
                    if (trim($phone) !== '') {
                        $this->addPhoneNumber($newId, $phone);
                    }
                }
            }

            // Si todo va bien, confirmamos
            $this->pdo->commit();
            return $newId; // Podemos devolver el ID del nuevo cliente
        } catch (\Exception $e) {
            // Si ocurre algún error, hacemos rollback
            $this->pdo->rollBack();
            return false;
        }
    }

    /**
     * Método para actualizar al cliente y sus teléfonos.
     * - Estrategia típica: borra todos los teléfonos antiguos y vuelvelos a insertar.
     */
    public function updateWithPhones($phoneNumbers)
    {
        try {
            $this->pdo->beginTransaction();

            // Actualizar datos básicos del cliente
            $success = $this->update();
            if (!$success) {
                $this->pdo->rollBack();
                return false;
            }

            // Borramos todos los teléfonos anteriores
            $this->deleteAllPhones($this->customer_id);

            // Insertamos los nuevos
            if (!empty($phoneNumbers)) {
                foreach ($phoneNumbers as $phone) {
                    if (trim($phone) !== '') {
                        $this->addPhoneNumber($this->customer_id, $phone);
                    }
                }
            }

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
