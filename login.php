<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// login.php
session_start();
require_once 'config/database.php'; // Conexión a la base de datos.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $login_email = $_POST['login_email'] ?? '';
    $login_password = $_POST['login_password'] ?? '';

    // Conexión a la base de datos
    $db = new Database();
    $pdo = $db->getConnection();

    // Buscar el usuario por email
    $sql = "SELECT e.*, r.name AS role
            FROM employee e
            LEFT JOIN employee_role er ON e.employee_id = er.employee_id
            LEFT JOIN role r ON er.role_id = r.role_id
            WHERE e.email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $login_email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y la contraseña es correcta
    if ($user && password_verify($login_password, $user['password'])) {
        // Crear la sesión del usuario con el rol adecuado
        $_SESSION['employee'] = [
            'employee_id' => $user['employee_id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'role' => $user['role'] ?? 'employee' // Valor predeterminado si no tiene rol.
        ];
        header('Location: index.php');
        exit;
    } else {
        $error = "Email o contraseña incorrectos.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Pet Grooming DB</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <!-- Campo oculto para prevenir autocompletar nombres de usuario -->
        <input type="text" name="fake_username" id="fake_username" style="display: none;" autocomplete="username">

        <label for="login_email">Email:</label>
        <input type="email" name="login_email" id="login_email" placeholder="usuario@ejemplo.com" required autocomplete="email">
        <br><br>
        <label for="login_password">Contraseña:</label>
        <input type="password" name="login_password" id="login_password" required autocomplete="current-password">
        <br><br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
