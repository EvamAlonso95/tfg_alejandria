<?php
/**
 * Controlador Frontal (Front Controller)
 *
 * Punto de entrada principal para la aplicación. 
 * Se encarga de gestionar las peticiones entrantes (parámetros por GET), 
 * cargar configuraciones necesarias y redirigir la ejecución al controlador y acción correspondientes.
 */

// Carga automática de clases de controladores
require_once 'autoload.php';

// Carga de parámetros globales de configuración
require_once 'config/parameters.php';

// Conexión a la base de datos
require_once 'config/db.php';

// Funciones auxiliares (helpers)
require_once 'helpers/Utils.php';


// Inicia la sesión para poder manejar información persistente entre peticiones
session_start();

// Cargamos el modelo user porque es un elemento presente en todas las páginas (header)
require_once 'models/user.php';

/**
 * Función que carga el controlador de errores por defecto
 *
 * @return void
 */
function showError()
{
    $error = new errorController();
    $error->index();
}

// Lógica para determinar qué controlador cargar

// Si se proporciona el parámetro 'controller' por GET, lo usamos para construir el nombre de la clase
if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'] . 'Controller';

    // Si no se han definido ni 'controller' ni 'action', usamos los valores por defecto
} elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $nombre_controlador = controller_default;

    // Si se proporciona solo uno de los dos o algo incorrecto, mostramos error
} else {
    showError();
    exit();
}

// Verificamos si el controlador existe y ejecutamos la acción

if (class_exists($nombre_controlador)) {
    // Instanciamos el controlador
    $controlador = new $nombre_controlador();

    // Verificamos si se proporciona una acción válida y si existe el método
    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();

        // Si no se ha proporcionado ninguna acción, usamos la acción por defecto
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $action_default = action_default;
        $controlador->$action_default();
    } else {
        showError(); // Acción no válida
    }

} else {
    showError(); // Controlador no válido
}
