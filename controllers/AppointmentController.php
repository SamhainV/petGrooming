<?php
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/Employee.php';
require_once __DIR__ . '/../models/Store.php';


class AppointmentController {
    
    public function index() {
        $appointmentModel = new Appointment();
    
        // Si no se pasa un contexto específico (pet_id o customer_id)
        if (!isset($_GET['pet_id']) && !isset($_GET['customer_id'])) {
            $appointments = $appointmentModel->findAll();
        } elseif (isset($_GET['pet_id'])) {
            $appointments = $appointmentModel->findByPetId($_GET['pet_id']);
        } else {
            // Aquí puedes manejar citas filtradas por cliente si lo necesitas
            echo "Especifica un contexto para ver citas.";
            exit;
        }
    
        require_once __DIR__ . '/../views/appointment/list.php';
    }


    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment = new Appointment();
            $appointment->pet_id = $_POST['pet_id'];
            $appointment->store_id = $_POST['store_id'];
            $appointment->date = $_POST['date'];
            $appointment->time = $_POST['time'];
            $appointment->description = $_POST['description'];
            $appointment->status = $_POST['status'];
            $appointment->assigned_employee_id = $_POST['assigned_employee_id'] ?? null;
    
            if ($appointment->create()) {
                header('Location: index.php?controller=Appointment&action=index');
                exit;
            } else {
                echo "Error al crear la cita.";
            }
        } else {
            $petModel = new Pet();
            $pets = $petModel->findAll();
            $selectedPet = isset($_GET['pet_id']) ? $petModel->findById($_GET['pet_id']) : null;
    
            $employeeModel = new Employee();
            $employees = $employeeModel->findAll();
    
            $storeModel = new Store();
            $stores = $storeModel->findAll();
    
            // Obtener al empleado logueado desde la sesión
            if (isset($_SESSION['employee']['email'])) {
                $loggedInUserEmail = $_SESSION['employee']['email'];
                $loggedInEmployee = $employeeModel->findByEmail($loggedInUserEmail);
    
                // Validar si el empleado fue encontrado
                if (!$loggedInEmployee) {
                    echo "Empleado no encontrado.";
                    exit;
                }
    
                // Obtener la tienda asociada al empleado logueado
                $employeeStore = $storeModel->findByEmployeeId($loggedInEmployee->employee_id);
            } else {
                echo "Usuario no autenticado.";
                exit;
            }
    
            require_once __DIR__ . '/../views/appointment/create.php';
        }
    }
    
    public function edit() {
        $appointment_id = $_GET['appointment_id'] ?? null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar la edición de la cita
            $appointment = new Appointment();
            $appointment->appointment_id = $appointment_id;
            $appointment->store_id = $_POST['store_id'];
            $appointment->pet_id = $_POST['pet_id'];
            $appointment->date = $_POST['date'];
            $appointment->time = $_POST['time'];
            $appointment->description = $_POST['description'];
            $appointment->status = $_POST['status'];
            $appointment->assigned_employee_id = $_POST['assigned_employee_id'] ?? null;
    
            if ($appointment->update()) {
                header('Location: index.php?controller=Appointment&action=index');
                exit;
            } else {
                echo "Error al actualizar la cita.";
            }
        } else {
            // Obtener los datos necesarios para la vista
            $storeModel = new Store();
            $stores = $storeModel->findAll();
    
            $petModel = new Pet();
            $pets = $petModel->findAll();
    
            $appointmentModel = new Appointment();
            $appointment = $appointmentModel->findById($appointment_id);
    
            $employeeModel = new Employee();
            $employees = $employeeModel->findAllExcludingAdmin();
    
            require_once __DIR__ . '/../views/appointment/edit.php';
        }
    }
/*    
    public function edit() {
        $appointmentModel = new Appointment();
        $petModel = new Pet();
        $employeeModel = new Employee();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment = $appointmentModel->findById($_POST['appointment_id']);
            if ($appointment) {
                $appointment->pet_id = $_POST['pet_id'];
                $appointment->date = $_POST['date'];
                $appointment->time = $_POST['time'];
                $appointment->description = $_POST['description'];
                $appointment->status = $_POST['status'];
                $appointment->assigned_employee_id = $_POST['assigned_employee_id'] ?? null;

                if ($appointment->update()) {
                    header('Location: index.php?controller=Appointment&action=index');
                    exit;
                } else {
                    echo "Error al actualizar la cita.";
                }
            }
        } else {
            $appointment_id = $_GET['appointment_id'] ?? null;
            $appointment = $appointmentModel->findById($appointment_id);

            if (!$appointment) {
                echo "Cita no encontrada.";
                exit;
            }

            $pets = $petModel->findAll();
            $employees = $employeeModel->findAll();

            require_once __DIR__ . '/../views/appointment/edit.php';
        }
    }
*/
    public function delete() {
        $appointmentModel = new Appointment();

        if (isset($_GET['appointment_id'])) {
            if ($appointmentModel->delete($_GET['appointment_id'])) {
                header('Location: index.php?controller=Appointment&action=index');
                exit;
            } else {
                echo "Error al eliminar la cita.";
            }
        } else {
            echo "Cita no encontrada.";
        }
    }
}
