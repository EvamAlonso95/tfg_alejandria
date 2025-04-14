<?php
// Controlador frontal
// Recoger parámetros GET
// Llevará a los controllers (función autoload que al coger los parámetros GET carge un controlador concreto- investigar)
require_once 'autoload.php';
require_once 'config/parameters.php';
require_once 'config/db.php';
require_once 'helpers/Utils.php';
session_start(); // Iniciamos la sesión para poder usarla en el controlador frontal
// require_once 'views/layout/header.php';

function showError()
{

    $error = new errorController();
    $error->index();
}


// Controla a que controlador va
//Si existe la variable GET generamos una variable
if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'] . 'Controller';

    //Si no esta definido los parametros controller y action -> la variable nombre controlador será el valor por defecto
} elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $nombre_controlador = controller_default;
} else {
    showError();
    exit();
}

//Si existe esa clase, ese controlador, creo el objeto
if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();

    // Compruebo si existe la acción y el método e invocó ese método
    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();

        // Cargamos la action como default si no existen las variables GET
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $action_default = action_default;
        $controlador->$action_default();
    } else {
        showError();
    }
} else {
    showError();
}

// require_once 'views/layout/sidebar.php';
// require_once 'views/layout/footer.php';
