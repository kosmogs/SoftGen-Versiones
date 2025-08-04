<?php
// config/config.php

// --- Configuración de Credenciales de la Base de Datos ---
define('DB_HOST', '127.0.0.1'); 
define('DB_NAME', 'bd_sofgen777');
define('DB_USER', 'root'); // Asegúrate de que este sea tu usuario de MySQL
define('DB_PASS', '123456789'); // Asegúrate de que esta sea tu contraseña

// El juego de caracteres para la conexión
define('DB_CHARSET', 'utf8mb4');


// --- Conexión a la base de datos usando PDO ---
// Usamos las constantes aquí
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

// Opciones para la conexión PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en caso de errores SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve los resultados como arrays asociativos
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Usa preparaciones de consultas nativas del driver
];

try {
    // Intentamos crear la instancia de PDO.
    $db = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
    // Si la conexión falla, detenemos la aplicación y mostramos un error.
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

/**
 * Función para obtener una conexión a la base de datos usando PDO.
 * Esta función es ahora redundante si $db se define en el mismo archivo.
 * Puedes eliminarla o usarla en su lugar si la prefieres.
 * Si usas esta función, tendrás que llamar a getDbConnection() en tu index.php
 * para obtener la conexión y no depender de la variable global $db.
 */
function getDbConnection() {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}
?>