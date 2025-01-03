<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
</head>
<body>
    <h1>Lista de Usuarios</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($employees)): ?>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= htmlspecialchars($employee->employee_id) ?></td>
                        <td><?= htmlspecialchars($employee->name) ?></td>
                        <td><?= htmlspecialchars($employee->email) ?></td>
                        <td>
                            <a href="index.php?controller=Employee&action=edit&employee_id=<?= $employee->employee_id ?>">Editar</a>
                            |
                            <a href="index.php?controller=Employee&action=delete&employee_id=<?= $employee->employee_id ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php?controller=Employee&action=create">Crear Usuario</a>
</body>
</html>
