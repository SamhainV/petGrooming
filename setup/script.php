<?php

/*
    Traspasa datos de la tabla 'clientes' de la base de datos 's01f7025_peluqueria' a la base de datos 'pet_grooming_db'.
*/

// Configuración de conexión a las bases de datos
try {
    $peluqueria_db = new PDO('mysql:host=localhost;dbname=s01f7025_peluqueria;charset=utf8', 'root', 'A29xxRamones', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $pet_grooming_db = new PDO('mysql:host=localhost;dbname=pet_grooming_db;charset=utf8mb4', 'root', 'A29xxRamones', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error al conectar con las bases de datos: " . $e->getMessage() . PHP_EOL);
}

// Obtener el ID de la tienda 'Mowgli'
try {
    $query = $pet_grooming_db->query("SELECT store_id FROM store WHERE name = 'Mowgli' LIMIT 1");
    $store = $query->fetch();
    if (!$store) {
        die("Error: La tienda 'Mowgli' no existe en la base de datos 'pet_grooming_db'." . PHP_EOL);
    }
    $store_id = $store['store_id'];
} catch (PDOException $e) {
    die("Error al obtener el ID de la tienda: " . $e->getMessage() . PHP_EOL);
}

// Obtener los datos de la tabla 'clientes' de la base de datos 's01f7025_peluqueria'
try {
    $query = $peluqueria_db->query("SELECT * FROM clientes");
    $clientes = $query->fetchAll();
    if (empty($clientes)) {
        die("No se encontraron datos en la tabla 'clientes'." . PHP_EOL);
    }
} catch (PDOException $e) {
    die("Error al obtener los datos de 'clientes': " . $e->getMessage() . PHP_EOL);
}

foreach ($clientes as $cliente) {
    try {
        // Iniciar una transacción
        $pet_grooming_db->beginTransaction();

        // Insertar datos en la tabla 'customer'
        $insertCustomer = $pet_grooming_db->prepare("
            INSERT INTO customer (name, last_name, second_last_name, address, email, store_id)
            VALUES (:name, :last_name, :second_last_name, :address, :email, :store_id)
        ");
        $insertCustomer->execute([
            ':name' => $cliente['Dueno'] ?? 'Desconocido',
            ':last_name' => '',
            ':second_last_name' => '',
            ':address' => '',
            ':email' => null, // Asignar NULL si no hay un correo disponible
            ':store_id' => $store_id
        ]);
        $customerId = $pet_grooming_db->lastInsertId();

        // Insertar teléfonos en 'customer_phone'
        $telefonos = [
            $cliente['Telefono'],
            $cliente['Telefono2'],
            $cliente['Telefono3'],
            $cliente['Telefono4']
        ];
        $insertPhone = $pet_grooming_db->prepare("
            INSERT INTO customer_phone (customer_id, phone_number)
            VALUES (:customer_id, :phone_number)
        ");
        foreach ($telefonos as $telefono) {
            if (!empty($telefono) && $telefono != '0') {
                $insertPhone->execute([
                    ':customer_id' => $customerId,
                    ':phone_number' => $telefono
                ]);
            }
        }

        // Insertar mascota en 'pet'
        $insertPet = $pet_grooming_db->prepare("
            INSERT INTO pet (name, age, customer_id, type, photo, sex, quality)
            VALUES (:name, :age, :customer_id, :type, :photo, :sex, :quality)
        ");
        $insertPet->execute([
            ':name' => $cliente['NombreMascota'] ?? 'Sin Nombre',
            ':age' => 0, // Edad no disponible
            ':customer_id' => $customerId,
            ':type' => strtolower($cliente['Raza'] ?? '') === 'cat' ? 'cat' : 'dog',
            ':photo' => $cliente['foto'] ?? null,
            ':sex' => $cliente['sexo'] == '1' ? 'male' : 'female',
            ':quality' => $cliente['Calidad'] ?? 'standard'
        ]);
        $petId = $pet_grooming_db->lastInsertId();

        // Insertar datos específicos de perro o gato en 'dog' o 'cat'
        if (strtolower($cliente['Raza'] ?? '') === 'cat') {
            $insertCat = $pet_grooming_db->prepare("
                INSERT INTO cat (pet_id, fur_color, temperament, breed)
                VALUES (:pet_id, :fur_color, :temperament, :breed)
            ");
            $insertCat->execute([
                ':pet_id' => $petId,
                ':fur_color' => '', // No disponible
                ':temperament' => $cliente['Caracter'] ?? '',
                ':breed' => $cliente['Raza'] ?? ''
            ]);
        } else {
            $insertDog = $pet_grooming_db->prepare("
                INSERT INTO dog (pet_id, breed, size, temperament)
                VALUES (:pet_id, :breed, :size, :temperament)
            ");
            $insertDog->execute([
                ':pet_id' => $petId,
                ':breed' => $cliente['Raza'] ?? '',
                ':size' => '', // No disponible
                ':temperament' => $cliente['Caracter'] ?? ''
            ]);
        }

        // Confirmar la transacción
        $pet_grooming_db->commit();
        echo "Cliente ID {$cliente['Id']} migrado correctamente." . PHP_EOL;

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $pet_grooming_db->rollBack();
        echo "Error al migrar el cliente ID {$cliente['Id']}: " . $e->getMessage() . PHP_EOL;
    }
}

echo "Migración completada." . PHP_EOL;
