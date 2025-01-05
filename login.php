<?php
session_start();
require_once 'config/database.php'; // Asegúrate de tener acceso a la conexión de la base de datos.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Conexión a la base de datos
    $db = new Database();
    $pdo = $db->getConnection();

    // Buscar el usuario por email
    $sql = "SELECT * FROM employee WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) {
        // Crear la sesión del usuario
        $_SESSION['user'] = [
            'email' => $user['email'],
            'role' => $user['role'] ?? 'employee' // Ajustar según tu tabla
        ];
        header('Location: dashboard.php');
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
    <form method="POST" action="login.php" autocomplete="off">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="usuario@ejemplo.com" required>
        <br><br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
