<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Cita</title>
</head>

<body>
    <h1>Editar Cita</h1>

    <form action="index.php?controller=Appointment&action=edit&appointment_id=<?= htmlspecialchars($appointment->appointment_id) ?>" method="POST">
        <label for="store_id">Seleccionar Tienda:</label>
        <select name="store_id" id="store_id" required>
            <option value="">-- Seleccionar Tienda --</option>
            <?php foreach ($stores as $store): ?>
                <option value="<?= $store->store_id ?>" <?= $appointment->store_id == $store->store_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($store->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="pet_id">Seleccionar Mascota:</label>
        <select name="pet_id" id="pet_id" required>
            <?php foreach ($pets as $pet): ?>
                <option value="<?= $pet->pet_id ?>" <?= $appointment->pet_id == $pet->pet_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($pet->name) ?> (<?= htmlspecialchars($pet->owner_name ?? 'Dueño desconocido') ?>)
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

        <label for="assigned_employee_id">Empleado Asignado (opcional):</label>
        <select name="assigned_employee_id" id="assigned_employee_id">
            <option value="<?= htmlspecialchars($_SESSION['employee']['employee_id']) ?>" <?= $appointment->assigned_employee_id == $_SESSION['employee']['employee_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($_SESSION['employee']['name']) ?> (Tú)
            </option>
            <?php foreach ($employees as $employee): ?>
                <?php if ($employee->employee_id != $_SESSION['employee']['employee_id']): ?>
                    <option value="<?= $employee->employee_id ?>" <?= $appointment->assigned_employee_id == $employee->employee_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($employee->name) ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <br><br>

        <button type="submit">Guardar Cambios</button>
    </form>

    <br>
    <a href="index.php?controller=Appointment&action=index">Volver a la lista de citas</a>
</body>

</html>
