DROP DATABASE IF EXISTS pet_grooming_db;
CREATE DATABASE IF NOT EXISTS pet_grooming_db;
USE pet_grooming_db;

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
    FOREIGN KEY (store_id) REFERENCES store(store_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    last_name VARCHAR(25) NOT NULL,
    second_last_name VARCHAR(25) NOT NULL,
    address VARCHAR(100),
    email VARCHAR(100) NOT NULL UNIQUE,
    store_id INT NOT NULL,
    FOREIGN KEY (store_id) REFERENCES store(store_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS customer_phone (
    customer_phone_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pet (
    pet_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    age INT NOT NULL,
    customer_id INT NOT NULL,
    type ENUM('dog', 'cat') NOT NULL,
    photo VARCHAR(255),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS dog (
    pet_id INT PRIMARY KEY,
    breed VARCHAR(50) NOT NULL,
    size VARCHAR(20) NOT NULL,
    temperament VARCHAR(50),
    FOREIGN KEY (pet_id) REFERENCES pet(pet_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS cat (
    pet_id INT PRIMARY KEY,
    fur_color VARCHAR(50) NOT NULL,
    temperament VARCHAR(50),
    breed VARCHAR(50),
    FOREIGN KEY (pet_id) REFERENCES pet(pet_id)
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
    FOREIGN KEY (employee_id) REFERENCES employee(employee_id),
    FOREIGN KEY (role_id) REFERENCES role(role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS employee_store (
    employee_store_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    store_id INT NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES employee(employee_id),
    FOREIGN KEY (store_id) REFERENCES store(store_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS appointment (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    description VARCHAR(255),
    store_id INT NOT NULL,
    status ENUM('pending', 'completed', 'canceled') DEFAULT 'pending',
    assigned_employee_id INT,
    FOREIGN KEY (pet_id) REFERENCES pet(pet_id),
    FOREIGN KEY (store_id) REFERENCES store(store_id),
    FOREIGN KEY (assigned_employee_id) REFERENCES employee(employee_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Insertar roles iniciales
INSERT INTO role (name) 
VALUES ('admin'), ('employee')
ON DUPLICATE KEY UPDATE name = name;

-- Obtener los IDs de los roles
SET @admin_role_id = (SELECT role_id FROM role WHERE name = 'admin');
SET @user_role_id = (SELECT role_id FROM role WHERE name = 'employee');

-- Insertar una store para poder referenciarla (ahora con province y country)
INSERT INTO store (name, nif, street, postal_code, city, province, country)
VALUES ('Mowgli', '12345678A', 'Calle el Almendro', '28001', 'Córdoba', 'Córdoba', 'España');

-- Obtener el último store_id insertado
SET @last_store_id = LAST_INSERT_ID();

-- Insertar dos números de teléfono en la tabla store_phone
INSERT INTO store_phone (store_id, phone_number)
VALUES (@last_store_id, '957342187'),
       (@last_store_id, '957348712');

-- Insertar un customer llamado María Martínez
INSERT INTO customer (name, last_name, second_last_name, address, email, store_id)
VALUES ('María', 'Martínez', 'Palos', 'Calle Albeniz 12', 'maria@gmail.com', @last_store_id);

-- Obtener el último customer_id insertado
SET @last_customer_id = LAST_INSERT_ID();

-- Insertar dos números de teléfono en la tabla customer_phone
INSERT INTO customer_phone (customer_id, phone_number)
VALUES (@last_customer_id, '957232792'),
       (@last_customer_id, '604189945');

-- Insertar varias pets (todas "cat" en este ejemplo)
INSERT INTO pet (name, age, customer_id, type, photo)
VALUES ('Debo', 2, @last_customer_id, 'cat', NULL),
       ('Bruno', 3, @last_customer_id, 'cat', NULL),
       ('Jackie', 4, @last_customer_id, 'cat', NULL);

-- Obtener los IDs de las pets recién insertadas
SET @pet_id1 = LAST_INSERT_ID();
SET @pet_id2 = @pet_id1 + 1;
SET @pet_id3 = @pet_id2 + 1;

-- Insertar detalles en la tabla cat
INSERT INTO cat (pet_id, fur_color, temperament, breed)
VALUES (@pet_id1, 'Blanca y negra', 'Nervioso', 'Comun europeo'),
       (@pet_id2, 'Gris', 'Tranquilo', 'Comun europeo'),
       (@pet_id3, 'Negro', 'Agresivo', 'Comun europeo');

-- Insertar una cita (appointment) para Debo
-- Agregamos los campos 'status' y 'assigned_employee_id' (en este caso, NULL para assigned_employee_id)
INSERT INTO appointment (pet_id, date, time, description, store_id, status, assigned_employee_id)
VALUES (@pet_id1, '2024-07-15', '10:40:00', 'bañarla', @last_store_id, 'pending', NULL);

-- Insertar el empleado Admin (ahora con campo 'email')
INSERT INTO employee (name, email, password)
VALUES ('Admin', 'admin@gmail.com', '$2y$10$73G0DGZZFkHPUHMtL85VUOHLz3K7Fj9jrJrdH/XXd8epLW8ncpIVe');

-- Obtener el ID del empleado Admin recién insertado
SET @admin_employee_id = LAST_INSERT_ID();

-- Asignar el rol de admin al empleado Admin
INSERT INTO employee_role (employee_id, role_id)
VALUES (@admin_employee_id, @admin_role_id);

-- Asignar el empleado Admin a la tienda
INSERT INTO employee_store (employee_id, store_id)
VALUES (@admin_employee_id, @last_store_id);

-- Insertar el empleado Antonio (ahora con campo 'email')
INSERT INTO employee (name, email, password)
VALUES ('Antonio', 'antoniomartinezramirez@gmail.com', '$2y$10$T3gtnF9bO3kSFib3AG0B8.EbJBAoUb.IN.tNr9zX/yFfk7EuYcNBO');

-- Obtener el ID del empleado Antonio
SET @antonio_employee_id = LAST_INSERT_ID();

-- Asignar el rol de user a Antonio
INSERT INTO employee_role (employee_id, role_id)
VALUES (@antonio_employee_id, @user_role_id);

-- Asignar el empleado Antonio a la tienda
INSERT INTO employee_store (employee_id, store_id)
VALUES (@antonio_employee_id, @last_store_id);

