<?php

class Database
{
    private static ?PDO $instance = null;

    private function __construct()
    {
        // Constructor privado para evitar la instanciación directa
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                // Incluyo la configuración de la conexión
                include __DIR__ . '/../config/conf.env';

                self::$instance = new PDO($dsn, $usuario, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
                ]);
            } catch (PDOException $e) {
                error_log('Error de conexión a BD: ' . $e->getMessage());
                throw new Exception('Error al conectar con la base de datos. Por favor, inténtelo más tarde.');
            }
        }

        return self::$instance;
    }

    private function __clone() {}
    public  function __wakeup() {}
}
