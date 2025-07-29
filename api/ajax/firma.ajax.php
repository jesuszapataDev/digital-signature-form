<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once "../controladores/FirmaControlador.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? null;

    switch ($accion) {
case 'guardar_firma':
    $respuesta = FirmaControlador::guardarFirma($_POST);
    echo json_encode($respuesta);
    break;

        default:
            echo json_encode([
                'estado' => 'error',
                'mensaje' => 'Acción no válida'
            ]);
            break;
    }
} else {
    echo json_encode([
        'estado' => 'error',
        'mensaje' => 'Método no permitido'
    ]);
}
