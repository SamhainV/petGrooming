<?php
require_once __DIR__ . '/../models/Customer.php';

class CustomerController {

    public function index() {
        $customerModel = new Customer();
    
        // Parámetros de paginación
        $itemsPerPage = 10; // Número de clientes por página
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // Página actual
        $offset = ($currentPage - 1) * $itemsPerPage; // Cálculo del desplazamiento para la consulta SQL
    
        // Obtener los clientes paginados
        $customers = $customerModel->findAllPaginated($offset, $itemsPerPage);
    
        // Obtener el número total de clientes para calcular el total de páginas
        $totalCustomers = $customerModel->countAll();
        $totalPages = ceil($totalCustomers / $itemsPerPage);
    
        // Pasar los datos necesarios a la vista
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

            $phoneNumbers = $_POST['phone_numbers'] ?? [];

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
                $customer->name             = $_POST['name']             ?? $customer->name;
                $customer->last_name        = $_POST['last_name']        ?? $customer->last_name;
                $customer->second_last_name = $_POST['second_last_name'] ?? $customer->second_last_name;
                $customer->address          = $_POST['address']          ?? $customer->address;
                $customer->email            = $_POST['email']            ?? $customer->email;
                $customer->store_id         = $_POST['store_id']         ?? $customer->store_id;

                $phoneNumbers = $_POST['phone_numbers'] ?? [];

                $customer->customer_id = $customer_id;
                if ($customer->updateWithPhones($phoneNumbers)) {
                    header('Location: index.php?controller=Customer&action=index');
                    exit;
                } else {
                    echo "Error actualizando el cliente.";
                }
            }
        } else {
            $customer_id = $_GET['customer_id'] ?? null;
            $customer = $customerModel->findById($customer_id);

            $phones = $customerModel->getPhonesByCustomerId($customer_id);

            require_once __DIR__ . '/../views/customer/edit.php';
        }
    }

    public function delete() {
        if (isset($_GET['customer_id'])) {
            $customerModel = new Customer();
            $customerModel->delete($_GET['customer_id']);
        }
        header('Location: index.php?controller=Customer&action=index');
        exit;
    }
}
