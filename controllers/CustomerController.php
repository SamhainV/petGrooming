<?php
require_once __DIR__ . '/../models/Customer.php';

class CustomerController {
    public function index() {
        $customerModel = new Customer();
        $customers = $customerModel->findAll();
    
        // Recorremos todos los clientes para obtener sus teléfonos
        foreach ($customers as $customer) {
            // getPhonesByCustomerId() es un método en el modelo
            $customer->phones = $customerModel->getPhonesByCustomerId($customer->customer_id);
        }
    
        // Ahora la variable $customers incluye, dentro de cada objeto $customer,
        // una nueva propiedad $customer->phones con la lista de teléfonos.
        require_once __DIR__ . '/../views/customer/list.php';
    }
    

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerModel = new Customer();
            $customerModel->name             = $_POST['name']             ?? '';
            $customerModel->last_name        = $_POST['last_name']        ?? '';
            $customerModel->second_last_name = $_POST['second_last_name'] ?? '';
            $customerModel->address          = $_POST['address']          ?? '';
            $customerModel->email            = $_POST['email']            ?? '';
            $customerModel->store_id         = $_POST['store_id']         ?? null;

            // Array de teléfonos
            // En el formulario se llamará phone_numbers[] para poder recibirlos en un array
            $phoneNumbers = $_POST['phone_numbers'] ?? [];

            // Usamos el método createWithPhones
            $newId = $customerModel->createWithPhones($phoneNumbers);
            if ($newId) {
                header('Location: index.php?controller=Customer&action=index');
                exit;
            } else {
                echo "Error creando el cliente.";
            }
        } else {
            require_once __DIR__ . '/../views/customer/create.php';
        }
    }

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

                // Teléfonos
                $phoneNumbers = $_POST['phone_numbers'] ?? [];

                // Actualizamos tanto el cliente como sus teléfonos
                $customer->customer_id = $customer_id; // Asegurar que esté seteado
                if ($customer->updateWithPhones($phoneNumbers)) {
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

            // Obtenemos los teléfonos del cliente
            $phones = $customerModel->getPhonesByCustomerId($customer_id);

            require_once __DIR__ . '/../views/customer/edit.php';
        }
    }

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
