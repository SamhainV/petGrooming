<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Rol</title>
</head>
<body>
    <h1>Asignar Rol a Usuario</h1>

    <form action="index.php?controller=EmployeeRole&action=assign" method="POST">
        <input type="hidden" name="employee_id" value="<?= htmlspecialchars($employee->employee_id) ?>">

        <p>Asignar rol a: <strong><?= htmlspecialchars($employee->name) ?></strong></p>

        <label for="role_id">Selecciona un Rol:</label>
        <select name="role_id" id="role_id" required>
            <option value="">-- Selecciona un rol --</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?= htmlspecialchars($role->role_id) ?>"><?= htmlspecialchars($role->name) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Asignar</button>
    </form>

    <a href="index.php?controller=EmployeeRole&action=index">Volver a la lista de usuarios</a>
</body>
</html>
