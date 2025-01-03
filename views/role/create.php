<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Rol</title>
</head>
<body>
    <h1>Crear Rol</h1>

    <form action="index.php?controller=Role&action=create" method="POST">
        <label for="name">Nombre del Rol:</label>
        <input type="text" name="name" id="name" required>
        <br><br>
        <button type="submit">Crear</button>
    </form>

    <a href="index.php?controller=Role&action=index">Volver a la lista de roles</a>
</body>
</html>
