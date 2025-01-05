<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Obtener datos del usuario logueado
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal - Pet Grooming DB</title>
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($user['email']) ?></h1>
    <p>Rol: <?= htmlspecialchars($user['role']) ?></p>

    <!-- Incluir el menú -->
    <?php include __DIR__ . '/views/partials/menu.php'; ?>

    <hr>

    <p>Selecciona una opción del menú para comenzar.</p>

    <br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
