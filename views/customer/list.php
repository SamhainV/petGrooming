<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Clientes</title>
</head>
<body>
    <h1>Lista de Clientes</h1>
    <a href="index.php?controller=Customer&action=create">Crear nuevo cliente</a>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Tienda</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($customers)): ?>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= $customer->customer_id ?></td>
                        <td><?= htmlspecialchars($customer->name) ?></td>
                        <td>
                            <?= htmlspecialchars($customer->last_name) ?> 
                            <?= htmlspecialchars($customer->second_last_name) ?>
                        </td>
                        <td><?= htmlspecialchars($customer->address) ?></td>
                        <td><?= htmlspecialchars($customer->email) ?></td>
                        <td><?= htmlspecialchars($customer->store_id) ?></td>
                        <td>
                            <a href="index.php?controller=Customer&action=edit&customer_id=<?= $customer->customer_id ?>">
                                Editar
                            </a>
                            |
                            <a href="index.php?controller=Customer&action=delete&customer_id=<?= $customer->customer_id ?>"
                               onclick="return confirm('¿Estás seguro de eliminar este cliente?');">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay clientes disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
