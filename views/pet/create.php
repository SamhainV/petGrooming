<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Mascota</title>
</head>
<body>
    <h1>Añadir Mascota</h1>

    <form action="index.php?controller=Pet&action=create" method="POST">
        <input type="hidden" name="customer_id" value="<?= htmlspecialchars($_GET['customer_id']) ?>">

        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" required>
        <br>

        <label for="age">Edad:</label>
        <input type="number" name="age" id="age" required>
        <br>

        <label for="type">Tipo:</label>
        <select name="type" id="type" required>
            <option value="dog">Perro</option>
            <option value="cat">Gato</option>
        </select>
        <br>

        <label for="photo">Foto:</label>
        <input type="text" name="photo" id="photo">
        <br>

        <button type="submit">Añadir</button>
    </form>

    <a href="index.php?controller=Customer&action=index">Volver a la lista de clientes</a>
</body>
</html>
