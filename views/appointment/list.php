<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Citas</title>
</head>
<body>
    <h1>Lista de Citas</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mascota</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Empleado Asignado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment->appointment_id) ?></td>
                        <td><?= htmlspecialchars($appointment->pet_name) ?></td>
                        <td><?= htmlspecialchars($appointment->date) ?></td>
                        <td><?= htmlspecialchars($appointment->time) ?></td>
                        <td><?= htmlspecialchars($appointment->description) ?></td>
                        <td><?= htmlspecialchars($appointment->status) ?></td>
                        <td><?= htmlspecialchars($appointment->employee_name ?? 'No asignado') ?></td>
                        <td>
                            <a href="index.php?controller=Appointment&action=edit&appointment_id=<?= $appointment->appointment_id ?>">Editar</a>
                            |
                            <a href="index.php?controller=Appointment&action=delete&appointment_id=<?= $appointment->appointment_id ?>" onclick="return confirm('¿Estás seguro de eliminar esta cita?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No hay citas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php?controller=Appointment&action=create">Crear Cita</a>
</body>
</html>