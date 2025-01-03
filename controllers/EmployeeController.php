<?php
require_once __DIR__ . '/../models/Employee.php';

class EmployeeController {
    // GET /employee/index
    public function index() {
        $employeeModel = new Employee();
        $employees = $employeeModel->findAll();
        require_once __DIR__ . '/../views/employee/list.php';
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employee = new Employee();
            $employee->name = $_POST['name'] ?? '';
            $employee->email = $_POST['email'] ?? '';
            $employee->password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT); // Usa hashing seguro para contraseñas
    
            if ($employee->create()) {
                header('Location: index.php?controller=Employee&action=index');
                exit;
            } else {
                echo "Error al crear el usuario.";
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
    
                // Solo actualizar contraseña si se proporcionó una nueva
                if (!empty($_POST['password'])) {
                    $employee->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }
    
                if ($employee->update()) {
                    header('Location: index.php?controller=Employee&action=index');
                    exit;
                } else {
                    echo "Error al actualizar el usuario.";
                }
            }
        } else {
            $employee_id = $_GET['employee_id'] ?? null;
            $employee = $employeeModel->findById($employee_id);
    
            if (!$employee) {
                echo "Usuario no encontrado.";
                exit;
            }
    
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
