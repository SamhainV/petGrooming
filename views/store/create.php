<!DOCTYPE html>
<html>
<head>
    <title>Crear Tienda</title>
</head>
<body>
    <h1>Crear Tienda</h1>
    <form method="POST" action="index.php?controller=Store&action=create">
        <label>Nombre:
            <input type="text" name="name" required>
        </label><br>
        
        <label>NIF:
            <input type="text" name="nif">
        </label><br>

        <label>Calle:
            <input type="text" name="street">
        </label><br>

        <label>Código Postal:
            <input type="text" name="postal_code">
        </label><br>

        <label>Ciudad:
            <input type="text" name="city">
        </label><br>

        <label>Provincia:
            <input type="text" name="province">
        </label><br>

        <label>País:
            <input type="text" name="country">
        </label><br>

        <input type="submit" value="Guardar">
    </form>
</body>
</html>
