<?php
/**
 * Registra una función de autocarga para incluir automáticamente archivos de controladores.
 *
 * Esta función permite cargar clases de controladores ubicadas en la carpeta 'controllers'
 * sin necesidad de hacer `include` manualmente cada vez que se utiliza una clase.
 *
 * PHPDoc: El uso de spl_autoload_register() permite registrar una función de carga automática
 * que se invoca automáticamente cuando se intenta utilizar una clase que aún no ha sido definida.
 */

/**
 * Carga automáticamente el archivo PHP correspondiente a una clase de controlador.
 *
 * @param string $classname El nombre de la clase a cargar.
 * 
 * @return void
 */
function controller_autoload($classname)
{
    include 'controllers/' . $classname . '.php';
}

// Registra la función de autocarga definida anteriormente
spl_autoload_register('controller_autoload');
