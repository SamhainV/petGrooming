<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Mascotas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Lista de Mascotas</h1>

    <?php if (!empty($pets)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Cliente ID</th>
                    <th>Tipo</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pets as $pet): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pet->pet_id); ?></td>
                        <td><?php echo htmlspecialchars($pet->name); ?></td>
                        <td><?php echo htmlspecialchars($pet->age); ?> años</td>
                        <td><?php echo htmlspecialchars($pet->customer_id); ?></td>
                        <td><?php echo htmlspecialchars($pet->type === 'dog' ? 'Perro' : 'Gato'); ?></td>
                        <td>
                            <?php if (!empty($pet->photo)): ?>
                                <img src="<?php echo htmlspecialchars($pet->photo); ?>" alt="Foto de <?php echo htmlspecialchars($pet->name); ?>" style="width: 50px; height: 50px;">
                            <?php else: ?>
                                Sin foto
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay mascotas registradas.</p>
    <?php endif; ?>

    <a href="index.php">Volver al inicio</a>
</body>
</html>
