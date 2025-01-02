<?php
require_once __DIR__ . '/../models/Pet.php';

class PetController {
    // GET /pet/index
    public function index() {
        $petModel = new Pet();
        $pets = $petModel->findAll();
        require_once __DIR__ . '/../views/pet/list.php';
    }

    // GET|POST /pet/create
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pet = new Pet();
            $pet->name = $_POST['name'] ?? null;
            $pet->age = $_POST['age'] ?? null;
            $pet->customer_id = $_POST['customer_id'] ?? null;
            $pet->type = $_POST['type'] ?? 'dog';  // default o 'cat'
            $pet->photo = $_POST['photo'] ?? null;

            if ($pet->create()) {
                header('Location: index.php?controller=Pet&action=index');
                exit;
            } else {
                echo "Error creando la mascota (pet).";
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
                $pet->name = $_POST['name'] ?? $pet->name;
                $pet->age = $_POST['age'] ?? $pet->age;
                $pet->customer_id = $_POST['customer_id'] ?? $pet->customer_id;
                $pet->type = $_POST['type'] ?? $pet->type;
                $pet->photo = $_POST['photo'] ?? $pet->photo;

                if ($pet->update()) {
                    header('Location: index.php?controller=Pet&action=index');
                    exit;
                } else {
                    echo "Error actualizando la mascota (pet).";
                }
            }
        } else {
            $pet_id = $_GET['pet_id'] ?? null;
            $pet = $petModel->findById($pet_id);
            require_once __DIR__ . '/../views/pet/edit.php';
        }
    }

    // GET /pet/delete
    public function delete() {
        if (isset($_GET['pet_id'])) {
            $petModel = new Pet();
            $petModel->delete($_GET['pet_id']);
        }
        header('Location: index.php?controller=Pet&action=index');
        exit;
    }
}
