<?php
require_once __DIR__ . '/../models/Role.php';

class RoleController {
    // GET /role/index
    public function index() {
        $roleModel = new Role();
        $roles = $roleModel->findAll();
        require_once __DIR__ . '/../views/role/list.php';
    }

    // GET|POST /role/create
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = new Role();
            $role->name = $_POST['name'] ?? '';

            if ($role->create()) {
                header('Location: index.php?controller=Role&action=index');
                exit;
            } else {
                echo "Error creando el rol.";
            }
        } else {
            require_once __DIR__ . '/../views/role/create.php';
        }
    }

    public function edit() {
        $roleModel = new Role();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $roleModel->findById($_POST['role_id']);
            if ($role) {
                $role->name = $_POST['name'] ?? $role->name;
    
                if ($role->update()) {
                    header('Location: index.php?controller=Role&action=index');
                    exit;
                } else {
                    echo "Error actualizando el rol.";
                }
            }
        } else {
            $role_id = $_GET['role_id'] ?? null;
            $role = $roleModel->findById($role_id);
    
            if (!$role) {
                echo "Rol no encontrado.";
                exit;
            }
    
            require_once __DIR__ . '/../views/role/edit.php';
        }
    }
    

    // GET /role/delete
    public function delete() {
        if (isset($_GET['role_id'])) {
            $roleModel = new Role();
            $roleModel->delete($_GET['role_id']);
        }
        header('Location: index.php?controller=Role&action=index');
        exit;
    }
}
