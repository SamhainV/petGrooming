<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Cliente</title>
</head>
<body>
    <h1>Crear Cliente</h1>
    <form method="POST" action="index.php?controller=Customer&action=create">
        <label>Nombre:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Apellido:</label><br>
        <input type="text" name="last_name" required><br><br>

        <label>Segundo Apellido:</label><br>
        <input type="text" name="second_last_name"><br><br>

        <label>Dirección:</label><br>
        <input type="text" name="address"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Tienda (ID):</label><br>
        <input type="number" name="store_id" min="1" required><br><br>

        <!-- SECCIÓN DE TELÉFONOS -->
        <label>Teléfonos:</label><br>
        <div id="phones-wrapper">
            <input type="text" name="phone_numbers[]" placeholder="Teléfono"><br>
        </div>
        <button type="button" onclick="addPhoneField()">Añadir otro teléfono</button>
        <br><br>

        <input type="submit" value="Guardar">
    </form>

    <script>
        function addPhoneField() {
            const container = document.getElementById('phones-wrapper');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'phone_numbers[]';
            input.placeholder = 'Teléfono';
            container.appendChild(input);
            container.appendChild(document.createElement('br'));
        }
    </script>
</body>
</html>
