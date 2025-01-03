<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>

    <form action="index.php?controller=Employee&action=edit" method="POST">
        <input type="hidden" name="employee_id" value="<?= htmlspecialchars($employee->employee_id) ?>">

        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($employee->name) ?>" required>
        <br><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($employee->email) ?>" required>
        <br><br>

        <label for="password">Contraseña (deja en blanco para no cambiar):</label>
        <input type="password" name="password" id="password">
        <br><br>

        <button type="submit">Guardar Cambios</button>
    </form>

    <a href="index.php?controller=Employee&action=index">Volver a la lista de usuarios</a>
</body>
</html>
