<?php
class Database
{
    public static function connect()
    {
        try {
            // Incluyo la configuración de la conexión
            $config = include __DIR__ . '/../config/conf.env';

            // Creo la conexión PDO

            $db = new PDO($dsn, $usuario, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
            ]);

            return $db;
        } catch (PDOException $e) {
            // Manejo de errores (en producción deberías loguear este error)
            error_log('Error de conexión a BD: ' . $e->getMessage());
            throw new Exception('Error al conectar con la base de datos. Por favor, inténtelo más tarde.');
        }
    }
}
