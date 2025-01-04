<?php
// index.php

// Puedes incluir aquí cualquier lógica de inicio de sesión o seguridad si fuera necesario

// Mostramos un menú básico para navegar por los distintos controladores/acciones
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pet Grooming DB - Panel Principal</title>
</head>

<body>
    <h1>Panel Principal</h1>

    <!-- Menú de navegación -->
    <nav>
        <ul>
            <li><a href="?controller=Store&action=index">Tiendas</a></li>
            <li><a href="?controller=Customer&action=index">Clientes</a></li>
            <!--<li><a href="?controller=Pet&action=index">Mascotas</a></li>-->
            <li><a href="?controller=Appointment&action=index">Citas</a></li>
            <li><a href="?controller=Employee&action=index">Empleados</a></li>
            <li><a href="?controller=Role&action=index">Roles</a></li>
            <li><a href="?controller=EmployeeRole&action=index">Gestión de Roles de Empleados</a></li>
        </ul>
    </nav>

    <hr>

    <?php
    // Parámetros para determinar el controlador y la acción
    $controllerName = $_GET['controller'] ?? 'Store';
    $action = $_GET['action'] ?? 'index';

    $controllerClass = $controllerName . 'Controller';
    $controllerFile = __DIR__ . '/controllers/' . $controllerClass . '.php';

    // Verificamos que el archivo del controlador exista
    if (file_exists($controllerFile)) {
        require_once $controllerFile;

        // Verificamos que la clase exista
        if (class_exists($controllerClass)) {
            $controllerObject = new $controllerClass();

            // Comprobamos que el método (acción) exista
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

</body>

</html>