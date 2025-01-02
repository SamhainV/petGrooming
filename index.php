<?php
// project/index.php

// Parámetros para determinar el controlador y la acción
$controllerName = $_GET['controller'] ?? 'Store';
$action = $_GET['action'] ?? 'index';

$controllerClass = $controllerName . 'Controller';
$controllerFile = __DIR__ . '/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClass)) {
        $controllerObject = new $controllerClass();
        if (method_exists($controllerObject, $action)) {
            $controllerObject->$action();
        } else {
            echo "La acción '$action' no existe en el controlador '$controllerClass'.";
        }
    } else {
        echo "No se encuentra la clase del controlador '$controllerClass'.";
    }
} else {
    echo "El controlador '$controllerClass' no está definido.";
}
