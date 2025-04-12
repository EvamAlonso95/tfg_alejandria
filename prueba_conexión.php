<?php
    require_once __DIR__ . '/../../models/db.php';

    try {
        $connection = Database::connect();
        echo "✅ Conexión exitosa a la base de datos\n";

        // Prueba adicional: Obtener versión de MySQL
        $version = $connection->query('SELECT version()')->fetchColumn();
        echo "🛠 Versión del servidor MySQL: " . $version . "\n";

        // Prueba con tu base de datos específica
        $dbName = $connection->query('SELECT DATABASE()')->fetchColumn();
        echo "📦 Base de datos conectada: " . $dbName . "\n";
    } catch (Exception $e) {
        echo "❌ Error de conexión: " . $e->getMessage() . "\n";
        echo "🔍 Detalles técnicos (revisa tu conf.env):\n";
        echo "- DSN: " . ($dsn ?? 'No definido') . "\n";
        echo "- Usuario: " . ($usuario ?? 'No definido') . "\n";
    }
    ?>