<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
</head>
<body>
    <h1>Crear Usuario</h1>

    <form action="index.php?controller=Employee&action=create" method="POST">
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" required>
        <br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required>
        <br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br>

        <button type="submit">Crear</button>
    </form>

    <a href="index.php?controller=Employee&action=index">Volver a la lista de usuarios</a>
</body>
</html>
