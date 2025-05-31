<?php

/**
 * Controlador Frontal (Front Controller)
 *
 * Punto de entrada principal para la aplicación. 
 * Se encarga de gestionar las peticiones entrantes (parámetros por GET), 
 * cargar configuraciones necesarias y redirigir la ejecución al controlador y acción correspondientes.
 */

// Carga automática de clases de controladores
require_once './autoload.php';

// Carga de parámetros globales de configuración
require_once './config/parameters.php';

// Conexión a la base de datos
require_once './config/db.php';

// Funciones auxiliares (helpers)
require_once './helpers/Utils.php';
require_once './qdrant/QdrantClient.php';
require_once './qdrant/QdrantLogic.php';


// Inicia la sesión para poder manejar información persistente entre peticiones
session_start();

/**
 * Función que carga el controlador de errores por defecto
 *
 * @return void
 */

//TODO Controlar los errores del xDebug cuando cargue una clase que no existe
function showError()
{
	$error = new ErrorController();
	$error->index();
}

// Lógica para determinar qué controlador cargar

// Si se proporciona solo 'action' sin 'controller', mostramos un error
if (!isset($_GET['controller']) && isset($_GET['action'])) {
	showError();
	return;
}

// Si no se han definido ni 'controller' ni 'action', usamos el controlador por defecto
if (!isset($_GET['controller']) && !isset($_GET['action'])) {
	$nombre_controlador = CONTROLLER_DEFAULT;
}

// Si se proporciona el parámetro 'controller' por GET, lo usamos para construir el nombre de la clase
if (isset($_GET['controller'])) {
	$nombre_controlador = ucfirst($_GET['controller']) . 'Controller';
}

// Verificamos si el controlador existe
if (!class_exists($nombre_controlador)) {
	showError(); // Controlador no válido
	return;
}

// Instanciamos el controlador
$controlador = new $nombre_controlador();

// Obtenemos la acción si está definida
$action = $_GET['action'] ?? null;
$controllerSet = isset($_GET['controller']);

// Verificamos si se proporciona una acción válida y si existe el método
if ($action && method_exists($controlador, $action)) {
	$controlador->$action(); // Ejecutamos la acción
	return;
}

// Si no se ha proporcionado ningún controlador ni acción, usamos la acción por defecto
if (!$controllerSet && !$action) {
	$actionDefault = ACTION_DEFAULT;
	$controlador->$actionDefault(); // Ejecutamos la acción por defecto
	return;
}

showError(); // Acción no válida
