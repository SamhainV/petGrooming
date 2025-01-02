<!DOCTYPE html>
<html>
<head>
    <title>Lista de Tiendas</title>
</head>
<body>
    <h1>Tiendas</h1>
    <a href="index.php?controller=Store&action=create">Crear nueva Tienda</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>NIF</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($stores as $store): ?>
        <tr>
            <td><?= $store->store_id ?></td>
            <td><?= htmlspecialchars($store->name) ?></td>
            <td><?= htmlspecialchars($store->nif) ?></td>
            <td>
                <a href="index.php?controller=Store&action=edit&store_id=<?= $store->store_id ?>">Editar</a> | 
                <a href="index.php?controller=Store&action=delete&store_id=<?= $store->store_id ?>"
                   onclick="return confirm('¿Eliminar esta tienda?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
