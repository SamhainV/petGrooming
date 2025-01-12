<?php

/*
    Traspasa datos de la tabla 'clientes' de la base de datos 's01f7025_peluqueria' a la base de datos 'pet_grooming_db'.
    Antes de iniciar, elimina y recrea la base de datos 'pet_grooming_db' para empezar desde cero.
*/

// Configuración de conexión al servidor de bases de datos
try {
    $db = new PDO('mysql:host=localhost;charset=utf8', 'root', 'A29xxRamones', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error al conectar con el servidor de bases de datos: " . $e->getMessage() . PHP_EOL);
}

// Eliminar y recrear la base de datos 'pet_grooming_db'
try {
    $db->exec("DROP DATABASE IF EXISTS pet_grooming_db");
    $db->exec("CREATE DATABASE pet_grooming_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "La base de datos 'pet_grooming_db' ha sido recreada correctamente." . PHP_EOL;
} catch (PDOException $e) {
    die("Error al recrear la base de datos 'pet_grooming_db': " . $e->getMessage() . PHP_EOL);
}

// Conectar a la base de datos 'pet_grooming_db'
try {
    $pet_grooming_db = new PDO('mysql:host=localhost;dbname=pet_grooming_db;charset=utf8mb4', 'root', 'A29xxRamones', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos 'pet_grooming_db': " . $e->getMessage() . PHP_EOL);
}

// Crear las tablas necesarias en 'pet_grooming_db' e insertar datos iniciales
try {
    $pet_grooming_db->exec(<<<SQL
CREATE TABLE IF NOT EXISTS store (
    store_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    nif VARCHAR(20) NOT NULL,
    street VARCHAR(50),
    postal_code VARCHAR(10),
    city VARCHAR(50),
    province VARCHAR(50),
    country VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS store_phone (
    store_phone_id INT AUTO_INCREMENT PRIMARY KEY,
    store_id INT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    FOREIGN KEY (store_id) REFERENCES store(store_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    last_name VARCHAR(25) NOT NULL,
    second_last_name VARCHAR(25) NOT NULL,
    address VARCHAR(100),
    email VARCHAR(100) DEFAULT NULL,
    store_id INT NOT NULL,
    FOREIGN KEY (store_id) REFERENCES store(store_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS customer_phone (
    customer_phone_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pet (
    pet_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    age INT NOT NULL,
    customer_id INT NOT NULL,
    type ENUM('dog', 'cat') NOT NULL,
    photo VARCHAR(255),
    sex ENUM('male', 'female') NOT NULL,
    quality VARCHAR(50) NOT NULL DEFAULT 'standard',
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS dog (
    pet_id INT PRIMARY KEY,
    breed VARCHAR(50) NOT NULL,
    size VARCHAR(20) NOT NULL,
    temperament VARCHAR(50),
    FOREIGN KEY (pet_id) REFERENCES pet(pet_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS cat (
    pet_id INT PRIMARY KEY,
    fur_color VARCHAR(50) NOT NULL,
    temperament VARCHAR(50),
    breed VARCHAR(50),
    FOREIGN KEY (pet_id) REFERENCES pet(pet_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS role (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS employee (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS employee_role (
    employee_role_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES employee(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES role(role_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS employee_store (
    employee_store_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    store_id INT NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES employee(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (store_id) REFERENCES store(store_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS appointment (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    description TEXT,
    store_id INT NOT NULL,
    status ENUM('pending', 'completed', 'canceled') DEFAULT 'pending',
    assigned_employee_id INT,
    FOREIGN KEY (pet_id) REFERENCES pet(pet_id) ON DELETE CASCADE,
    FOREIGN KEY (store_id) REFERENCES store(store_id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_employee_id) REFERENCES employee(employee_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar roles iniciales
INSERT INTO role (name) 
VALUES ('admin'), ('employee')
ON DUPLICATE KEY UPDATE name = name;

-- Insertar una tienda inicial
INSERT INTO store (name, nif, street, postal_code, city, province, country)
VALUES ('Mowgli', '12345678A', 'Calle Almendro', '14001', 'Córdoba', 'Córdoba', 'España');
SQL
    );
    echo "Tablas creadas e inicializadas correctamente en 'pet_grooming_db'." . PHP_EOL;
} catch (PDOException $e) {
    die("Error al crear las tablas en 'pet_grooming_db': " . $e->getMessage() . PHP_EOL);
}

// Conectar a la base de datos 's01f7025_peluqueria'
try {
    $peluqueria_db = new PDO('mysql:host=localhost;dbname=s01f7025_peluqueria;charset=utf8', 'root', 'A29xxRamones', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos 's01f7025_peluqueria': " . $e->getMessage() . PHP_EOL);
}

// Migrar datos desde 's01f7025_peluqueria'
try {
    $clientes = $peluqueria_db->query("SELECT * FROM clientes")->fetchAll();
    foreach ($clientes as $cliente) {
        $pet_grooming_db->beginTransaction();

        // Insertar cliente
        $insertCustomer = $pet_grooming_db->prepare("
            INSERT INTO customer (name, last_name, second_last_name, address, email, store_id)
            VALUES (:name, :last_name, :second_last_name, :address, :email, :store_id)
        ");
        $insertCustomer->execute([
            ':name' => $cliente['Dueno'] ?? 'Desconocido',
            ':last_name' => '',
            ':second_last_name' => '',
            ':address' => '',
            ':email' => null,
            ':store_id' => 1
        ]);
        $customerId = $pet_grooming_db->lastInsertId();

        // Insertar teléfonos
        $telefonos = [
            $cliente['Telefono'],
            $cliente['Telefono2'],
            $cliente['Telefono3'],
            $cliente['Telefono4']
        ];
        foreach ($telefonos as $telefono) {
            if (!empty($telefono) && $telefono != '0') {
                $pet_grooming_db->prepare("
                    INSERT INTO customer_phone (customer_id, phone_number)
                    VALUES (:customer_id, :phone_number)
                ")->execute([
                    ':customer_id' => $customerId,
                    ':phone_number' => $telefono
                ]);
            }
        }

        // Insertar mascota
        $insertPet = $pet_grooming_db->prepare("
            INSERT INTO pet (name, age, customer_id, type, photo, sex, quality)
            VALUES (:name, :age, :customer_id, :type, :photo, :sex, :quality)
        ");
        $insertPet->execute([
            ':name' => $cliente['NombreMascota'] ?? 'Sin Nombre',
            ':age' => 0,
            ':customer_id' => $customerId,
            ':type' => 'dog',
            ':photo' => $cliente['foto'] ?? null,
            ':sex' => $cliente['sexo'] == '1' ? 'male' : 'female',
            ':quality' => $cliente['Calidad'] ?? 'standard'
        ]);
        $petId = $pet_grooming_db->lastInsertId();

        // Insertar cita
        $insertAppointment = $pet_grooming_db->prepare("
            INSERT INTO appointment (pet_id, date, time, description, store_id, status)
            VALUES (:pet_id, :date, :time, :description, :store_id, :status)
        ");
        $insertAppointment->execute([
            ':pet_id' => $petId,
            ':date' => date('Y-m-d'),
            ':time' => date('H:i:s'),
            ':description' => $cliente['Observaciones'] ?? '',
            ':store_id' => 1,
            ':status' => 'pending'
        ]);

        $pet_grooming_db->commit();
        echo "Cliente ID {$cliente['Id']} migrado correctamente." . PHP_EOL;
    }
    echo "Migración completada." . PHP_EOL;
} catch (PDOException $e) {
    die("Error al migrar datos: " . $e->getMessage() . PHP_EOL);
}
