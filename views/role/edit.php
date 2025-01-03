<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Rol</title>
</head>
<body>
    <h1>Editar Rol</h1>

    <form action="index.php?controller=Role&action=edit" method="POST">
        <input type="hidden" name="role_id" value="<?= htmlspecialchars($role->role_id) ?>">

        <label for="name">Nombre del Rol:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($role->name) ?>" required>
        <br><br>
        <button type="submit">Guardar</button>
    </form>

    <a href="index.php?controller=Role&action=index">Volver a la lista de roles</a>
</body>
</html>
