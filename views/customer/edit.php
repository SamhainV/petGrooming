<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Cliente</title>
</head>
<body>
    <h1>Editar Cliente</h1>

    <?php if (isset($customer)): ?>
        <form method="POST" action="index.php?controller=Customer&action=edit">
            <input type="hidden" name="customer_id" value="<?= htmlspecialchars($customer->customer_id ?? '') ?>">

            <label>Nombre:</label><br>
            <input type="text" name="name" 
                   value="<?= htmlspecialchars($customer->name ?? '') ?>" 
                   required><br><br>

            <label>Apellido:</label><br>
            <input type="text" name="last_name" 
                   value="<?= htmlspecialchars($customer->last_name ?? '') ?>" 
                   required><br><br>

            <label>Segundo Apellido:</label><br>
            <input type="text" name="second_last_name" 
                   value="<?= htmlspecialchars($customer->second_last_name ?? '') ?>"><br><br>

            <label>Dirección:</label><br>
            <input type="text" name="address" 
                   value="<?= htmlspecialchars($customer->address ?? '') ?>"><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" 
                   value="<?= htmlspecialchars($customer->email ?? '') ?>" 
                   required><br><br>

            <label>Tienda (ID):</label><br>
            <input type="number" name="store_id" min="1" 
                   value="<?= htmlspecialchars($customer->store_id ?? '') ?>" 
                   required><br><br>

            <!-- SECCIÓN TELÉFONOS -->
            <label>Teléfonos:</label><br>
            <div id="phones-wrapper">
                <?php if (!empty($phones)): ?>
                    <?php foreach ($phones as $p): ?>
                        <input type="text" name="phone_numbers[]" value="<?= htmlspecialchars($p['phone_number'] ?? '') ?>"><br>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Si no hay teléfonos, al menos un campo vacío -->
                    <input type="text" name="phone_numbers[]" placeholder="Teléfono"><br>
                <?php endif; ?>
            </div>
            <button type="button" onclick="addPhoneField()">Añadir otro teléfono</button>
            <br><br>

            <input type="submit" value="Actualizar">
        </form>

    <?php else: ?>
        <p>No se encontró el cliente para editar.</p>
    <?php endif; ?>

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
