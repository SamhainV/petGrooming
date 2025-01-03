<?php
require_once __DIR__ . '/../models/EmployeeRole.php';
require_once __DIR__ . '/../models/Role.php';
require_once __DIR__ . '/../models/Employee.php';

class EmployeeRoleController {
    // GET /employeeRole/index
    public function index() {
        $employeeModel = new Employee();
        $employeeRoleModel = new EmployeeRole();
    
        // Recupera todos los empleados
        $employees = $employeeModel->findAll();
    
        // Asocia roles a cada empleado
        $employeeRoles = [];
        foreach ($employees as $employee) {
            $employeeRoles[$employee->employee_id] = $employeeRoleModel->findRolesByEmployee($employee->employee_id);
        }
    
        // Carga la vista y pasa las variables
        require_once __DIR__ . '/../views/employeeRole/list.php';
    }
    public function assign() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeRole = new EmployeeRole();
            $employeeRole->employee_id = $_POST['employee_id'] ?? null;
            $employeeRole->role_id = $_POST['role_id'] ?? null;
    
            if ($employeeRole->create()) {
                header('Location: index.php?controller=EmployeeRole&action=index');
                exit;
            } else {
                echo "Error asignando el rol.";
            }
        } else {
            $roleModel = new Role();
            $employeeModel = new Employee();
    
            $roles = $roleModel->findAll();
    
            // Recuperar el empleado seleccionado
            $employee_id = $_GET['employee_id'] ?? null;
            $employee = $employeeModel->findById($employee_id);
    
            // Verificar si el empleado existe
            if (!$employee) {
                echo "Empleado no encontrado.";
                exit;
            }
    
            require_once __DIR__ . '/../views/employeeRole/assign.php';
        }
    }
    
    
    // GET /employeeRole/delete
    public function delete() {
        if (isset($_GET['employee_role_id'])) {
            $employeeRoleModel = new EmployeeRole();
            $employeeRoleModel->delete($_GET['employee_role_id']);
        }
        header('Location: index.php?controller=EmployeeRole&action=index');
        exit;
    }
}
