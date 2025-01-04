<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Mascotas</title>
</head>
<body>
    <h1>Lista de Mascotas</h1>

    <!-- Enlace para añadir una nueva mascota -->
    <a href="index.php?controller=Pet&action=create&customer_id=<?= htmlspecialchars($_GET['customer_id']) ?>">Añadir Mascota</a>
    <br><br>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Dueño</th>
                <th>Tipo</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pets)): ?>
                <?php foreach ($pets as $pet): ?>
                    <tr>
                        <td><?= htmlspecialchars($pet->pet_id) ?></td>
                        <td><?= htmlspecialchars($pet->name) ?></td>
                        <td><?= htmlspecialchars($pet->age) ?> años</td>
                        <td><?= htmlspecialchars($pet->owner_name) ?></td>
                        <td><?= htmlspecialchars($pet->type) ?></td>
                        <td>
                            <?= $pet->photo 
                                ? '<img src="' . htmlspecialchars($pet->photo) . '" alt="Foto de ' . htmlspecialchars($pet->name) . '" width="50">' 
                                : 'Sin foto' ?>
                        </td>
                        <td>
                            <a href="index.php?controller=Pet&action=edit&pet_id=<?= $pet->pet_id ?>">Editar</a> |
                            <a href="index.php?controller=Pet&action=delete&pet_id=<?= $pet->pet_id ?>&customer_id=<?= htmlspecialchars($_GET['customer_id']) ?>" onclick="return confirm('¿Estás seguro de eliminar esta mascota?')">Eliminar</a> |
                            <a href="index.php?controller=Appointment&action=create&pet_id=<?= $pet->pet_id ?>">Añadir Cita</a> |
                            <a href="index.php?controller=Appointment&action=index&pet_id=<?= $pet->pet_id ?>">Editar Citas</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay mascotas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php?controller=Customer&action=index">Volver a la lista de clientes</a>
</body>
</html>
