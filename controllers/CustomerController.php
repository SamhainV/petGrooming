<?php
require_once __DIR__ . '/../models/Customer.php';

class CustomerController {
    /**
     * Muestra la lista de customers (clientes).
     */
    public function index() {
        $customerModel = new Customer();
        $customers = $customerModel->findAll();
        require_once __DIR__ . '/../views/customer/list.php';
    }

    /**
     * Crea un nuevo customer.
     * - Si es GET, muestra el formulario.
     * - Si es POST, recibe datos y los guarda.
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recogemos datos del formulario
            $customer = new Customer();
            $customer->name             = $_POST['name']             ?? '';
            $customer->last_name        = $_POST['last_name']        ?? '';
            $customer->second_last_name = $_POST['second_last_name'] ?? '';
            $customer->address          = $_POST['address']          ?? '';
            $customer->email            = $_POST['email']            ?? '';
            $customer->store_id         = $_POST['store_id']         ?? null;

            // Llamamos al método create() del modelo
            if ($customer->create()) {
                // Redireccionar a la lista de clientes
                header('Location: index.php?controller=Customer&action=index');
                exit;
            } else {
                echo "Error creando el cliente.";
            }
        } else {
            // Mostrar el formulario
            require_once __DIR__ . '/../views/customer/create.php';
        }
    }

    /**
     * Edita un customer existente.
     * - Si es GET, muestra el formulario con datos existentes.
     * - Si es POST, procesa los cambios y actualiza.
     */
    public function edit() {
        $customerModel = new Customer();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_id = $_POST['customer_id'] ?? null;
            $customer = $customerModel->findById($customer_id);

            if ($customer) {
                // Actualizamos los campos
                $customer->name             = $_POST['name']             ?? $customer->name;
                $customer->last_name        = $_POST['last_name']        ?? $customer->last_name;
                $customer->second_last_name = $_POST['second_last_name'] ?? $customer->second_last_name;
                $customer->address          = $_POST['address']          ?? $customer->address;
                $customer->email            = $_POST['email']            ?? $customer->email;
                $customer->store_id         = $_POST['store_id']         ?? $customer->store_id;

                if ($customer->update()) {
                    header('Location: index.php?controller=Customer&action=index');
                    exit;
                } else {
                    echo "Error actualizando el cliente.";
                }
            }
        } else {
            // Mostrar formulario con datos
            $customer_id = $_GET['customer_id'] ?? null;
            $customer = $customerModel->findById($customer_id);
            require_once __DIR__ . '/../views/customer/edit.php';
        }
    }

    /**
     * Elimina un customer por su ID.
     */
    public function delete() {
        if (isset($_GET['customer_id'])) {
            $customerModel = new Customer();
            $customerModel->delete($_GET['customer_id']);
        }
        // Redirigir a la lista de clientes
        header('Location: index.php?controller=Customer&action=index');
        exit;
    }
}
