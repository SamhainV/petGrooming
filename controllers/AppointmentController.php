<?php
require_once __DIR__ . '/../models/Appointment.php';

class AppointmentController {
    // GET /appointment/index
    public function index() {
        $appointmentModel = new Appointment();
        $appointments = $appointmentModel->findAll();
        require_once __DIR__ . '/../views/appointment/list.php';
    }

    // GET|POST /appointment/create
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario
            $appointment = new Appointment();
            $appointment->pet_id = $_POST['pet_id'] ?? null;
            $appointment->date = $_POST['date'] ?? null;
            $appointment->time = $_POST['time'] ?? null;
            $appointment->description = $_POST['description'] ?? '';
            $appointment->store_id = $_POST['store_id'] ?? null;
            $appointment->status = $_POST['status'] ?? 'pending';
            $appointment->assigned_employee_id = $_POST['assigned_employee_id'] ?? null;

            if ($appointment->create()) {
                header('Location: index.php?controller=Appointment&action=index');
                exit;
            } else {
                echo "Error creando la cita (appointment).";
            }
        } else {
            // Mostrar formulario
            require_once __DIR__ . '/../views/appointment/create.php';
        }
    }

    // GET|POST /appointment/edit
    public function edit() {
        $appointmentModel = new Appointment();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Actualizar
            $appointment = $appointmentModel->findById($_POST['appointment_id']);
            if ($appointment) {
                $appointment->pet_id = $_POST['pet_id'] ?? $appointment->pet_id;
                $appointment->date = $_POST['date'] ?? $appointment->date;
                $appointment->time = $_POST['time'] ?? $appointment->time;
                $appointment->description = $_POST['description'] ?? $appointment->description;
                $appointment->store_id = $_POST['store_id'] ?? $appointment->store_id;
                $appointment->status = $_POST['status'] ?? $appointment->status;
                $appointment->assigned_employee_id = $_POST['assigned_employee_id'] ?? $appointment->assigned_employee_id;

                if ($appointment->update()) {
                    header('Location: index.php?controller=Appointment&action=index');
                    exit;
                } else {
                    echo "Error actualizando la cita (appointment).";
                }
            }
        } else {
            // Mostrar form con datos existentes
            $appointment_id = $_GET['appointment_id'] ?? null;
            $appointment = $appointmentModel->findById($appointment_id);
            require_once __DIR__ . '/../views/appointment/edit.php';
        }
    }

    // GET /appointment/delete
    public function delete() {
        if (isset($_GET['appointment_id'])) {
            $appointmentModel = new Appointment();
            $appointmentModel->delete($_GET['appointment_id']);
        }
        header('Location: index.php?controller=Appointment&action=index');
        exit;
    }
}
