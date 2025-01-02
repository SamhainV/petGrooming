<?php
require_once __DIR__ . '/../models/Employee.php';

class EmployeeController {
    // GET /employee/index
    public function index() {
        $employeeModel = new Employee();
        $employees = $employeeModel->findAll();
        require_once __DIR__ . '/../views/employee/list.php';
    }

    // GET|POST /employee/create
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employee = new Employee();
            $employee->name = $_POST['name'] ?? null;
            $employee->email = $_POST['email'] ?? null;
            // En un proyecto real, harías un hash de la contraseña
            $employee->password = $_POST['password'] ?? '';

            if ($employee->create()) {
                header('Location: index.php?controller=Employee&action=index');
                exit;
            } else {
                echo "Error creando el empleado.";
            }
        } else {
            require_once __DIR__ . '/../views/employee/create.php';
        }
    }

    // GET|POST /employee/edit
    public function edit() {
        $employeeModel = new Employee();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employee = $employeeModel->findById($_POST['employee_id']);
            if ($employee) {
                $employee->name = $_POST['name'] ?? $employee->name;
                $employee->email = $_POST['email'] ?? $employee->email;
                if (!empty($_POST['password'])) {
                    // Nuevamente, en un proyecto real, aplicarías un hash
                    $employee->password = $_POST['password'];
                }
                if ($employee->update()) {
                    header('Location: index.php?controller=Employee&action=index');
                    exit;
                } else {
                    echo "Error actualizando el empleado.";
                }
            }
        } else {
            $employee_id = $_GET['employee_id'] ?? null;
            $employee = $employeeModel->findById($employee_id);
            require_once __DIR__ . '/../views/employee/edit.php';
        }
    }

    // GET /employee/delete
    public function delete() {
        if (isset($_GET['employee_id'])) {
            $employeeModel = new Employee();
            $employeeModel->delete($_GET['employee_id']);
        }
        header('Location: index.php?controller=Employee&action=index');
        exit;
    }
}
