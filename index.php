<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Aquí puedes continuar con el contenido del panel
// Obtener datos del usuario logueado
$user = $_SESSION['user'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pet Grooming DB - Panel Principal</title>
</head>
<body>
    <h1>Panel Principal</h1>

    <h1>Bienvenido, <?= htmlspecialchars($user['email']) ?></h1>
    <p>Rol: <?= htmlspecialchars($user['role']) ?></p>
    
    <!-- Menú -->
    <?php include __DIR__ . '/views/partials/menu.php'; ?>

    <hr>

    <?php
    // Parámetros para determinar el controlador y la acción
    $controllerName = $_GET['controller'] ?? 'Store';
    $action = $_GET['action'] ?? 'index';

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
</body>
</html>
