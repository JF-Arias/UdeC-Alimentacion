// Backend/config.php
<?php
// Cargar el archivo .env
require_once 'vendor/autoload.php';  // Si usas Composer

Dotenv\Dotenv::createImmutable(__DIR__)->load();

// Otras configuraciones globales
