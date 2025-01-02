<!DOCTYPE html>
<html>
<head>
    <title>Editar Tienda</title>
</head>
<body>
    <h1>Editar Tienda</h1>
    <form method="POST" action="index.php?controller=Store&action=edit">
        <input type="hidden" name="store_id" value="<?= $store->store_id ?>">
        <label>Nombre:
            <input type="text" name="name" value="<?= htmlspecialchars($store->name) ?>" required>
        </label><br>

        <label>NIF:
            <input type="text" name="nif" value="<?= htmlspecialchars($store->nif) ?>">
        </label><br>

        <label>Calle:
            <input type="text" name="street" value="<?= htmlspecialchars($store->street) ?>">
        </label><br>

        <label>Código Postal:
            <input type="text" name="postal_code" value="<?= htmlspecialchars($store->postal_code) ?>">
        </label><br>

        <label>Ciudad:
            <input type="text" name="city" value="<?= htmlspecialchars($store->city) ?>">
        </label><br>

        <label>Provincia:
            <input type="text" name="province" value="<?= htmlspecialchars($store->province) ?>">
        </label><br>

        <label>País:
            <input type="text" name="country" value="<?= htmlspecialchars($store->country) ?>">
        </label><br>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
