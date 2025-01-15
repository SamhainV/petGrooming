<?php
require_once __DIR__ . '/../config/database.php';

class Role {
    public $role_id;
    public $name;  // 'admin', 'user', etc.

    private $pdo;


    public function __construct() {
        $db = Database::getInstance(); // Utilizar el método estático
        $this->pdo = $db->getConnection(); // Obtener la conexión PDO
    }
    

    /**
     * Devuelve todos los registros de la tabla `role`.
     */
    public function findAll() {
        $sql = "SELECT * FROM role";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Role');
    }

    /**
     * Busca un registro por su ID.
     */
    public function findById($id) {
        $sql = "SELECT * FROM role WHERE role_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $role = $stmt->fetchObject('Role');
        return $role ?: null;
    }

    /**
     * Crea (inserta) un nuevo rol.
     */
    public function create() {
        $sql = "INSERT INTO role (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $this->name);
        return $stmt->execute();
    }

    /**
     * Actualiza la información del rol en la base de datos.
     */
    public function update() {
        $sql = "UPDATE role SET name = :name WHERE role_id = :role_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':role_id', $this->role_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        return $stmt->execute();
    }
    

    /**
     * Elimina un rol por su ID.
     */
    public function delete($id) {
        $sql = "DELETE FROM role WHERE role_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}