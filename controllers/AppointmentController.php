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
            $appointment->store_id = $_POST['store_id']; // Capturar el store_id desde el formulario
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
    
            $employeeModel = new Employee();
            $employees = $employeeModel->findAll();
    
            $storeModel = new Store(); // Añadir carga de tiendas
            $stores = $storeModel->findAll();
    
            require_once __DIR__ . '/../views/appointment/create.php';
        }
    }
    
    
    
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
