<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Obtener rol del usuario logueado
$user = $_SESSION['user'];
$role = $user['role'];

// Mapear roles a los controladores permitidos
$permissions = [
    'admin' => ['Store', 'Customer', 'Appointment', 'Employee', 'Role', 'EmployeeRole'],
    'employee' => ['Customer', 'Appointment', 'Pet']
];

// Obtener el controlador y la acción de la URL
$controllerName = $_GET['controller'] ?? 'Store';
$action = $_GET['action'] ?? 'index';


echo "<h1>Controlador: $controllerName, acción: $action</h1>";
var_dump ($permissions[$role]);

// Verificar si el controlador está permitido para el rol del usuario
if (!in_array($controllerName, $permissions[$role] ?? [])) {
    echo "<h1>Acceso denegado</h1>";
    exit;
}

// Continuar con la lógica habitual de carga del controlador
$controllerClass = $controllerName . 'Controller';
$controllerFile = __DIR__ . '/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerClass)) {
        $controllerObject = new $controllerClass();

        if (method_exists($controllerObject, $action)) {
            $controllerObject->$action();
        } else {
            echo "<p style='color:red;'>La acción '$action' no existe en el controlador '$controllerClass'.</p>";
        }
    } else {
        echo "<p style='color:red;'>No se encuentra la clase del controlador '$controllerClass'.</p>";
    }
} else {
    echo "<p style='color:red;'>El controlador '$controllerClass' no está definido.</p>";
}
?>
