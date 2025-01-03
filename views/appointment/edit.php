<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
</head>
<body>
    <h1>Editar Cita</h1>

    <form action="index.php?controller=Appointment&action=edit" method="POST">
        <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment->appointment_id) ?>">

        <label for="pet_id">Mascota:</label>
        <select name="pet_id" id="pet_id" required>
            <?php foreach ($pets as $pet): ?>
                <option value="<?= htmlspecialchars($pet->pet_id) ?>" <?= $pet->pet_id == $appointment->pet_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($pet->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="date">Fecha:</label>
        <input type="date" name="date" id="date" value="<?= htmlspecialchars($appointment->date) ?>" required>
        <br><br>

        <label for="time">Hora:</label>
        <input type="time" name="time" id="time" value="<?= htmlspecialchars($appointment->time) ?>" required>
        <br><br>

        <label for="description">Descripción:</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($appointment->description) ?></textarea>
        <br><br>

        <label for="status">Estado:</label>
        <select name="status" id="status" required>
            <option value="pending" <?= $appointment->status == 'pending' ? 'selected' : '' ?>>Pendiente</option>
            <option value="completed" <?= $appointment->status == 'completed' ? 'selected' : '' ?>>Completada</option>
            <option value="canceled" <?= $appointment->status == 'canceled' ? 'selected' : '' ?>>Cancelada</option>
        </select>
        <br><br>

        <label for="assigned_employee_id">Empleado Asignado:</label>
        <select name="assigned_employee_id" id="assigned_employee_id">
            <option value="">-- Sin asignar --</option>
            <?php foreach ($employees as $employee): ?>
                <option value="<?= htmlspecialchars($employee->employee_id) ?>" <?= $employee->employee_id == $appointment->assigned_employee_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($employee->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <button type="submit">Guardar Cambios</button>
    </form>

    <a href="index.php?controller=Appointment&action=index">Volver a la lista de citas</a>
</body>
</html>
