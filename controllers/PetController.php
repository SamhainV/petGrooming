<?php
require_once __DIR__ . '/../models/Pet.php';

class PetController {
    public function index() {
        $customer_id = $_GET['customer_id'] ?? null;

        if (!$customer_id) {
            echo "Cliente no especificado.";
            exit;
        }

        $petModel = new Pet();
        $pets = $petModel->findByCustomerId($customer_id);

        require_once __DIR__ . '/../views/pet/list.php';
    }

    public function create() {
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

    public function edit() {
        $petModel = new Pet();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pet = $petModel->findById($_POST['pet_id']);

            if ($pet) {
                $pet->name = $_POST['name'];
                $pet->age = $_POST['age'];
                $pet->type = $_POST['type'];
                $pet->photo = $_POST['photo'] ?? $pet->photo;

                if ($pet->update()) {
                    header('Location: index.php?controller=Pet&action=index&customer_id=' . $pet->customer_id);
                    exit;
                } else {
                    echo "Error al actualizar la mascota.";
                }
            } else {
                echo "Mascota no encontrada.";
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

    public function delete() {
        if (isset($_GET['pet_id'])) {
            $petModel = new Pet();
            $pet = $petModel->findById($_GET['pet_id']);
            $customer_id = $pet->customer_id ?? null;

            if ($pet) {
                $petModel->delete($pet->pet_id);
            }

            header('Location: index.php?controller=Pet&action=index&customer_id=' . $customer_id);
            exit;
        }

        header('Location: index.php?controller=Pet&action=index');
        exit;
    }
}
