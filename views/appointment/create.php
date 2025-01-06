<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Cita</title>
</head>

<body>
    <h1>Crear Cita</h1>

    <form action="index.php?controller=Appointment&action=create" method="POST">

        <label for="store_id">Seleccionar Tienda:</label>
        <select name="store_id" id="store_id" required>
            <!-- Mostrar la tienda asociada al empleado logueado como opción seleccionada por defecto -->
            <?php if (isset($employeeStore)): ?>
                <option value="<?= htmlspecialchars($employeeStore->store_id) ?>" selected>
                    <?= htmlspecialchars($employeeStore->name) ?> (Tu tienda)
                </option>
            <?php endif; ?>

            <!-- Mostrar las demás tiendas -->
            <?php foreach ($stores as $store): ?>
                <?php if (!isset($employeeStore) || $store->store_id !== $employeeStore->store_id): ?>
                    <option value="<?= htmlspecialchars($store->store_id) ?>">
                        <?= htmlspecialchars($store->name) ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <br><br>


        <label for="pet_id">Seleccionar Mascota:</label>
        <select name="pet_id" id="pet_id" required>
            <?php if (isset($selectedPet)): ?>
                <option value="<?= htmlspecialchars($selectedPet->pet_id) ?>" selected>
                    <?= htmlspecialchars($selectedPet->name) ?> (<?= htmlspecialchars($selectedPet->owner_name ?? 'Dueño desconocido') ?>)
                </option>
            <?php else: ?>
                <option value="">-- Selecciona una mascota --</option>
                <?php foreach ($pets as $pet): ?>
                    <option value="<?= htmlspecialchars($pet->pet_id) ?>">
                        <?= htmlspecialchars($pet->name) ?> (<?= htmlspecialchars($pet->owner_name ?? 'Dueño desconocido') ?>)
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
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

        <label for="status">Estado:</label>
        <select name="status" id="status" required>
            <option value="pending">Pendiente</option>
            <option value="completed">Completada</option>
            <option value="canceled">Cancelada</option>
        </select>
        <br><br>

        <label for="assigned_employee_id">Empleado Asignado (opcional):</label>
        <select name="assigned_employee_id" id="assigned_employee_id">
            <!-- Mostrar al empleado logueado como opción seleccionada por defecto -->
            <?php if (isset($loggedInEmployee)): ?>
                <option value="<?= htmlspecialchars($loggedInEmployee->employee_id) ?>" selected>
                    <?= htmlspecialchars($loggedInEmployee->name) ?> (Tú)
                </option>
            <?php endif; ?>

            <!-- Mostrar a los demás empleados excepto el admin -->
            <?php foreach ($employees as $employee): ?>
                <?php if ($employee->role !== 'admin' && $employee->employee_id !== $loggedInEmployee->employee_id): ?>
                    <option value="<?= htmlspecialchars($employee->employee_id) ?>">
                        <?= htmlspecialchars($employee->name) ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <br><br>


        <button type="submit">Crear Cita</button>
    </form>

    <br>
    <a href="index.php?controller=Appointment&action=index">Volver a la lista de citas</a>
</body>

</html>