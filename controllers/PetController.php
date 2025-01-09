<?php
require_once __DIR__ . '/../models/Pet.php';

class PetController {
    // GET /pet/index
    
    public function index() {
        $customer_id = $_GET['customer_id'] ?? null;
    
        if (!$customer_id) {
            echo "Cliente no especificado.";
            exit;
        }
    
        $petModel = new Pet();
        $pets = $petModel->findByCustomerId($customer_id);
    
        // Pasa el ID del cliente para mostrar en la vista
        require_once __DIR__ . '/../views/pet/list.php';
    }

    // GET|POST /pet/create
    public function create() {
        $customer_id = $_GET['customer_id'] ?? null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pet = new Pet();
            $pet->name = $_POST['name'];
            $pet->age = $_POST['age'];
            $pet->customer_id = $_POST['customer_id'];
            $pet->type = $_POST['type'];
            $pet->photo = $_POST['photo'] ?? null;
    
            if ($pet->create()) {
                header('Location: index.php?controller=Customer&action=index');
                exit;
            } else {
                echo "Error al crear la mascota.";
            }
        } else {
            require_once __DIR__ . '/../views/pet/create.php';
        }
    }

    // GET|POST /pet/edit
    public function edit() {
        
        $petModel = new Pet();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            $pet = $petModel->findById($_POST['pet_id']);
            if ($pet) {
                echo "editando mascota";
                $pet->name = $_POST['name'];
                $pet->age = $_POST['age'];
                $pet->type = $_POST['type'];
                $pet->photo = $_POST['photo'] ?? $pet->photo;
    
                if ($pet->update()) {
                    echo "editando mascota";
                    $pet->algo();
                    header('Location: index.php?controller=Pet&action=index&customer_id=' . $pet->customer_id);
                    exit;
                } else {
                    echo "Error al actualizar la mascota.";
                }
            }
        } else {
            $pet_id = $_GET['pet_id'] ?? null;
            $pet = $petModel->findById($pet_id);
    
            if (!$pet) {
                echo "Mascota no encontrada.";
                exit;
            }
    
            require_once __DIR__ . '/../views/pet/edit.php';
        }
    }
    

    // GET /pet/delete
    public function delete() {
    if (isset($_GET['pet_id'])) {
        $petModel = new Pet();

        // Obtener el cliente antes de eliminar la mascota
        $pet = $petModel->findById($_GET['pet_id']);
        $customer_id = $pet->customer_id ?? null;

        // Eliminar la mascota
        if ($pet) {
            $petModel->delete($_GET['pet_id']);
        }

        // Redirigir a la lista de mascotas del cliente
        if ($customer_id) {
            header('Location: index.php?controller=Pet&action=index&customer_id=' . $customer_id);
        } else {
            // Si no hay cliente asociado, redirigir a la lista principal de mascotas
            header('Location: index.php?controller=Pet&action=index');
        }
        exit;
    }

    // Si no se pasa el `pet_id`, redirigir a la lista principal de mascotas
    header('Location: index.php?controller=Pet&action=index');
    exit;
}

    
}
