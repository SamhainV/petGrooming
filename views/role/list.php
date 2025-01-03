<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Roles</title>
</head>
<body>
    <h1>Lista de Roles</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($roles)): ?>
                <?php foreach ($roles as $role): ?>
                    <tr>
                        <td><?= htmlspecialchars($role->role_id) ?></td>
                        <td><?= htmlspecialchars($role->name) ?></td>
                        <td>
                            <a href="index.php?controller=Role&action=edit&role_id=<?= $role->role_id ?>">Editar</a>
                            |
                            <a href="index.php?controller=Role&action=delete&role_id=<?= $role->role_id ?>" onclick="return confirm('¿Estás seguro de eliminar este rol?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay roles registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php?controller=Role&action=create">Crear Rol</a>
</body>
</html>
