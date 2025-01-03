<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios y Roles</title>
</head>
<body>
    <h1>Usuarios y sus Roles</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= htmlspecialchars($employee->employee_id) ?></td>
                    <td><?= htmlspecialchars($employee->name) ?></td>
                    <td><?= htmlspecialchars($employee->email) ?></td>
                    <td>
                        <?php foreach ($employeeRoles[$employee->employee_id] ?? [] as $role): ?>
                            <?= htmlspecialchars($role->name) ?><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <a href="index.php?controller=EmployeeRole&action=assign&employee_id=<?= $employee->employee_id ?>">Asignar Rol</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php?controller=Employee&action=create">Crear Usuario</a>
</body>
</html>
