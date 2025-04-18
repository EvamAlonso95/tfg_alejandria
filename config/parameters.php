<?php

/**
 * Archivo de configuración de parámetros globales
 *
 * Define constantes que serán utilizadas en toda la aplicación para facilitar la generación de URLs
 * y definir el comportamiento por defecto del enrutador frontal (Front Controller).
 */

/**
 * URL base del proyecto
 *
 * Se utiliza como raíz para generar rutas absolutas dentro de la aplicación.
 * Asegúrate de cambiar este valor cuando subas el proyecto a un servidor diferente.
 */
define("base_url", "http://localhost/alejandria/");

/**
 * Controlador por defecto
 *
 * Controlador que se cargará si no se especifica ninguno a través de la URL.
 */
define("controller_default", "landingController");

/**
 * Acción por defecto
 *
 * Método dentro del controlador por defecto que se ejecutará si no se especifica ninguno en la URL.
 */
define("action_default", "index");
