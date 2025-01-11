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
                    $customer_id = htmlspecialchars($customer->customer_id ?? '');
                    $name = htmlspecialchars($customer->name ?? '');
                    $last_name = htmlspecialchars($customer->last_name ?? '');
                    $second_last_name = htmlspecialchars($customer->second_last_name ?? '');
                    $address = htmlspecialchars($customer->address ?? '');
                    $email = htmlspecialchars($customer->email ?? '');
                    $store_id = htmlspecialchars($customer->store_id ?? '');
                    $phoneNumbers = implode(', ', array_column($customer->phones ?? [], 'phone_number'));
                    ?>
                    <tr>
                        <td><?= $customer_id ?></td>
                        <td><?= $name ?></td>
                        <td><?= $last_name ?> <?= $second_last_name ?></td>
                        <td><?= $address ?></td>
                        <td><?= $email ?></td>
                        <td><?= $store_id ?></td>
                        <td><?= htmlspecialchars($phoneNumbers) ?></td>
                        <td>
                            <a href="index.php?controller=Customer&action=edit&customer_id=<?= $customer_id ?>">
                                Editar
                            </a> |
                            <a href="index.php?controller=Customer&action=delete&customer_id=<?= $customer_id ?>"
                                onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                                Eliminar
                            </a> |
                            <a href="index.php?controller=Pet&action=create&customer_id=<?= $customer_id ?>">
                                Añadir Mascota
                            </a> |
                            <a href="index.php?controller=Pet&action=index&customer_id=<?= $customer_id ?>">
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

    <!-- Paginador -->
    <?php if ($totalPages > 1): ?>
    <div style="text-align: center; margin-top: 20px;">
        <strong>Página:</strong>

        <!-- Botón "Inicio" -->
        <?php if ($currentPage > 1): ?>
            <a href="index.php?controller=Customer&action=index&page=1" style="margin: 0 5px;">Inicio</a>
        <?php endif; ?>

        <!-- Botón "Anterior" -->
        <?php if ($currentPage > 1): ?>
            <a href="index.php?controller=Customer&action=index&page=<?= $currentPage - 1 ?>" style="margin: 0 5px;">&laquo; Anterior</a>
        <?php endif; ?>

        <!-- Mostrar solo un rango de páginas alrededor de la actual -->
        <?php 
        $range = 5; // Número de páginas a mostrar antes y después de la actual
        $start = max(1, $currentPage - $range);
        $end = min($totalPages, $currentPage + $range);
        ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <?php if ($i == $currentPage): ?>
                <strong style="margin: 0 5px;"><?= $i ?></strong>
            <?php else: ?>
                <a href="index.php?controller=Customer&action=index&page=<?= $i ?>" style="margin: 0 5px;"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <!-- Botón "Siguiente" -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="index.php?controller=Customer&action=index&page=<?= $currentPage + 1 ?>" style="margin: 0 5px;">Siguiente &raquo;</a>
        <?php endif; ?>

        <!-- Botón "Fin" -->
        <?php if ($currentPage < $totalPages): ?>
            <a href="index.php?controller=Customer&action=index&page=<?= $totalPages ?>" style="margin: 0 5px;">Fin</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>

</html>