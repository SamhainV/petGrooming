<?php
session_start();

/*echo "<pre>";
print_r($_SESSION) ;
echo "<pre>";*/

// Verificar si el usuario está autenticado
if (!isset($_SESSION['employee'])) {
    header('Location: login.php');
    exit;
}

// Obtener rol del usuario logueado
$user = $_SESSION['employee']['name'];
$role = $_SESSION['employee']['role'];

//echo "valores de user y role: " . $user . " " . $role . "<br>";

// Mapear roles a los controladores permitidos
$permissions = [
    'admin' => ['Store', 'Customer', 'Appointment', 'Employee', 'Role', 'EmployeeRole'],
    'employee' => ['Customer', 'Appointment', 'Pet']
];


// Determinar el controlador y acción predeterminados según el rol
$defaultController = $role === 'admin' ? 'Store' : 'Customer';
// Obtener el controlador y la acción de la URL
$controllerName = $_GET['controller'] ?? $defaultController;
$action = $_GET['action'] ?? 'index';

//echo "valores de controllerName y action: " . $controllerName . " " . $action;  

//echo "<h1>Controlador: $controllerName, acción: $action</h1>";
//var_dump ($permissions[$role]);
//exit;

// Verificar si el controlador está permitido para el rol del usuario
if (!isset($permissions[$role]) || !in_array($controllerName, $permissions[$role])) {
    echo "<h1>Acceso denegado</h1>";
    exit;
}
/*// Verificar si el controlador está permitido para el rol del usuario
if (!in_array($controllerName, $permissions[$role] ?? [])) {
    echo "<h1>Acceso denegado</h1>";
    exit;
}*/

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
