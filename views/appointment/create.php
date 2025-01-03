<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Cita</title>
</head>
<body>
    <h1>Crear Nueva Cita</h1>

    <form action="index.php?controller=Appointment&action=create" method="POST">
        <label for="pet_id">Mascota:</label>
        <select name="pet_id" id="pet_id" required>
            <option value="">-- Selecciona una mascota --</option>
            <?php foreach ($pets as $pet): ?>
                <option value="<?= htmlspecialchars($pet->pet_id) ?>">
                    <?= htmlspecialchars($pet->name) ?> (<?= htmlspecialchars($pet->owner_name) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="date">Fecha:</label>
        <input type="date" name="date" id="date" required>
        <br><br>

        <label for="time">Hora:</label>
        <input type="time" name="time" id="time" required>
        <br><br>

        <label for="description">Descripción:</label>
        <textarea name="description" id="description" required></textarea>
        <br><br>
        

        <label for="store_id">Tienda:</label>
        <select name="store_id" id="store_id" required>
            <option value="">-- Selecciona una tienda --</option>
            <?php foreach ($stores as $store): ?>
                <option value="<?= htmlspecialchars($store->store_id) ?>">
                    <?= htmlspecialchars($store->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="status">Estado:</label>
        <select name="status" id="status" required>
            <option value="pending">Pendiente</option>
            <option value="completed">Completada</option>
            <option value="canceled">Cancelada</option>
        </select>
        <br><br>

        <label for="assigned_employee_id">Empleado Asignado:</label>
        <select name="assigned_employee_id" id="assigned_employee_id">
            <option value="">-- Sin asignar --</option>
            <?php foreach ($employees as $employee): ?>
                <option value="<?= htmlspecialchars($employee->employee_id) ?>">
                    <?= htmlspecialchars($employee->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <button type="submit">Crear Cita</button>
    </form>

    <a href="index.php?controller=Appointment&action=index">Volver a la lista de citas</a>
</body>
</html>
