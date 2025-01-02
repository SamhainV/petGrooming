#!/bin/bash

# Crear subdirectorios
mkdir -p config
mkdir -p models
mkdir -p controllers
mkdir -p views
mkdir -p views/store
mkdir -p views/customer
mkdir -p views/pet
mkdir -p views/appointment
mkdir -p views/employee
mkdir -p views/role

# Crear archivos en config
touch config/database.php

# Crear archivos en models
touch models/Store.php
touch models/Customer.php
touch models/Pet.php
touch models/Appointment.php
touch models/Employee.php
touch models/Role.php

# Crear archivos en controllers
touch controllers/StoreController.php
touch controllers/CustomerController.php
touch controllers/PetController.php
touch controllers/AppointmentController.php
touch controllers/EmployeeController.php
touch controllers/RoleController.php

# Crear archivos en views/store
touch views/store/list.php
touch views/store/create.php
touch views/store/edit.php

# Para las demás vistas, creamos un archivo "placeholder" si lo deseas
touch views/customer/.gitkeep
touch views/pet/.gitkeep
touch views/appointment/.gitkeep
touch views/employee/.gitkeep
touch views/role/.gitkeep

# Crear archivo index.php en la raíz
touch index.php

echo "¡Estructura de directorios y archivos creada con éxito en la carpeta actual!"
