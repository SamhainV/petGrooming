
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Mascota</title>
</head>
<body>
    <h1>Editar Mascota</h1>

    <form action="index.php?controller=Pet&action=edit" method="POST">
        <input type="hidden" name="pet_id" value="<?= htmlspecialchars($pet->pet_id) ?>">

        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($pet->name) ?>" required>
        <br><br>

        <label for="age">Edad:</label>
        <input type="number" name="age" id="age" value="<?= htmlspecialchars($pet->age) ?>" required>
        <br><br>

        <label for="type">Tipo:</label>
        <select name="type" id="type" required>
            <option value="dog" <?= $pet->type === 'dog' ? 'selected' : '' ?>>Perro</option>
            <option value="cat" <?= $pet->type === 'cat' ? 'selected' : '' ?>>Gato</option>
        </select>
        <br><br>

        <label for="photo">Foto (URL):</label>
        <input type="text" name="photo" id="photo" value="<?= htmlspecialchars($pet->photo ?? '') ?>">
        <br><br>

        <button type="submit">Guardar Cambios</button>
    </form>

    <a href="index.php?controller=Pet&action=index&customer_id=<?= htmlspecialchars($pet->customer_id) ?>">Volver a la lista de mascotas</a>
</body>
</html>
