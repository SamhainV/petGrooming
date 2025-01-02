<?php
require_once __DIR__ . '/../models/Customer.php';

class CustomerController {
    public function index() {
        $customerModel = new Customer();
        $customers = $customerModel->findAll();
        require_once __DIR__ . '/../views/customer/list.php';
    }

    // create, edit, delete... (similar lógica)
}
