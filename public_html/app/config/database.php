<?php
class EnvLoader {
    public static function load($path) {
        if (!file_exists($path)) {
            throw new Exception("El archivo .env no existe en: " . $path);
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0) continue;
            
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                $_ENV[$name] = $value;
            }
        }
    }
}

// Detectar ambiente y cargar .env
if (file_exists(__DIR__ . '/../../.env')) {
    // Desarrollo local: /app/config -> raíz del proyecto
    EnvLoader::load(__DIR__ . '/../../.env');
} elseif (file_exists(__DIR__ . '/../../../.env')) {
    // Producción: /public_html/app/config -> fuera de public_html
    EnvLoader::load(__DIR__ . '/../../../.env');
} else {
    throw new Exception("No se encontró el archivo .env en ninguna ubicación");
}

// Definir constantes
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);?>
