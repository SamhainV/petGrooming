<?php
require_once __DIR__ . '/../models/Store.php';

class StoreController {
    // GET /store/index
    public function index() {
        $storeModel = new Store();
        $stores = $storeModel->findAll();
        require_once __DIR__ . '/../views/store/list.php';
    }

    // GET|POST /store/create
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario
            $store = new Store();
            $store->name         = $_POST['name'];
            $store->nif          = $_POST['nif'];
            $store->street       = $_POST['street'];
            $store->postal_code  = $_POST['postal_code'];
            $store->city         = $_POST['city'];
            $store->province     = $_POST['province'];
            $store->country      = $_POST['country'];

            if ($store->create()) {
                header('Location: index.php?controller=Store&action=index');
                exit;
            } else {
                echo "Error creando la tienda";
            }
        } else {
            // Mostrar formulario
            require_once __DIR__ . '/../views/store/create.php';
        }
    }

    // GET|POST /store/edit
    public function edit() {
        $storeModel = new Store();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Actualizar
            $store = $storeModel->findById($_POST['store_id']);
            if ($store) {
                $store->name         = $_POST['name'];
                $store->nif          = $_POST['nif'];
                $store->street       = $_POST['street'];
                $store->postal_code  = $_POST['postal_code'];
                $store->city         = $_POST['city'];
                $store->province     = $_POST['province'];
                $store->country      = $_POST['country'];

                if ($store->update()) {
                    header('Location: index.php?controller=Store&action=index');
                    exit;
                } else {
                    echo "Error actualizando la tienda";
                }
            }
        } else {
            // Mostrar form con datos existentes
            $store_id = $_GET['store_id'] ?? null;
            $store = $storeModel->findById($store_id);
            require_once __DIR__ . '/../views/store/edit.php';
        }
    }

    // GET /store/delete
    public function delete() {
        if (isset($_GET['store_id'])) {
            $storeModel = new Store();
            $storeModel->delete($_GET['store_id']);
        }
        header('Location: index.php?controller=Store&action=index');
        exit;
    }
}
