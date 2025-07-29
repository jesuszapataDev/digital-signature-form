<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Obtener la ruta solicitada desde el parámetro 'path' que definimos en .htaccess
$path = isset($_GET['path']) ? $_GET['path'] : '';
$uri_parts = explode('/', trim($path, '/'));

// -------------------------------------------------------------------
// DECISIÓN PRINCIPAL: ¿ES UNA LLAMADA A LA API O UNA VISTA?
// -------------------------------------------------------------------

if (isset($uri_parts[0]) && $uri_parts[0] == 'api') {

    /********************
     * MANEJAR API REST *
     ********************/

    // Configurar cabeceras para respuestas JSON
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Content-Type: application/json; charset=UTF-8");
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        exit(0);

    // Incluir los controladores
    require_once __DIR__ . '/api/controladores/UsuarioControlador.php';

    // Preparar el enrutamiento de la API
    array_shift($uri_parts); // Quita "api" de la ruta
    $recurso = array_shift($uri_parts) ?? '';
    $id = array_shift($uri_parts) ?? null;
    $metodo = $_SERVER['REQUEST_METHOD'];
    $datos_body = json_decode(file_get_contents("php://input"));

    // Enrutador de la API
    switch ($recurso) {
        case 'login':
            if ($metodo == 'POST') {
                $controller = new UsuarioControlador();
                $resultado = $controller->login($datos_body);
                responder($resultado);
            }
            break;
        case 'usuarios':
            if ($metodo == 'POST') {
                $admin_id_logueado = 1; // Simulación
                $controller = new UsuarioControlador();
                $resultado = $controller->crearUsuario($datos_body, $admin_id_logueado);
                responder($resultado);
            }
            break;
        default:
            responder(['error' => 'Recurso de API no encontrado', 'status' => 404]);
            break;
    }

} else {

    /******************
     * MOSTRAR VISTAS *
     ******************/

    // Determinar qué vista cargar. Si la ruta está vacía, carga 'index'.
    $view_name = !empty($uri_parts[0]) ? $uri_parts[0] : 'index';
    $view_file = __DIR__ . '/views/' . $view_name . '.php';

    if (file_exists($view_file)) {
        // Si el archivo de la vista existe, lo incluye y lo muestra.
        // Esto renderiza el HTML/PHP que contenga el archivo.
        include $view_file;
    } else {
        // Si no se encuentra la vista, muestra la página de error 404.
        http_response_code(404);
        include __DIR__ . '/views/404.php';
    }
}


/**
 * Función auxiliar para enviar respuestas de la API.
 */
function responder($respuesta)
{
    http_response_code($respuesta['status']);
    if (isset($respuesta['data'])) {
        echo json_encode($respuesta['data']);
    } else {
        echo json_encode(['error' => $respuesta['error']]);
    }
}