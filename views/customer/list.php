<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>
<body>
    <h1>Lista de Clientes</h1>

    <a href="index.php?controller=Customer&action=create">Crear nuevo cliente</a>
    <br><br>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Tienda</th>
                <th>Teléfonos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($customers)): ?>
                <?php foreach ($customers as $customer): ?>
                    <?php 
                    // Con $customer->phones ya no necesitas volver a llamar a métodos de tu modelo.
                    // Convierte la lista de arrays en un simple array de strings de teléfono.
                    $phoneNumbers = array_column($customer->phones, 'phone_number');
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($customer->customer_id) ?></td>
                        <td><?= htmlspecialchars($customer->name) ?></td>
                        <td><?= htmlspecialchars($customer->last_name) ?> <?= htmlspecialchars($customer->second_last_name) ?></td>
                        <td><?= htmlspecialchars($customer->address) ?></td>
                        <td><?= htmlspecialchars($customer->email) ?></td>
                        <td><?= htmlspecialchars($customer->store_id) ?></td>
                        <td><?= implode(', ', $phoneNumbers) ?></td>
                        <td>
                            <a href="index.php?controller=Customer&action=edit&customer_id=<?= $customer->customer_id ?>">
                                Editar
                            </a> |
                            <a href="index.php?controller=Customer&action=delete&customer_id=<?= $customer->customer_id ?>" 
                               onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                                Eliminar
                            </a> |
                            <a href="index.php?controller=Pet&action=create&customer_id=<?= $customer->customer_id ?>">
                                Añadir Mascota
                            </a> |
                            <a href="index.php?controller=Pet&action=index&customer_id=<?= $customer->customer_id ?>">
                                Editar Mascotas
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No hay clientes registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
