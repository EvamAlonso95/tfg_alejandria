<?php
//Carga los controladores
//Accede a la carperta de los controladores y hace un include

function controller_autoload($classname)
{
    include 'controllers/' . $classname . '.php';
}
spl_autoload_register('controller_autoload');
