/**
* bootstrap.php - Initialize the application
*/
<?php
// Define the root directory
define('ROOT_DIR', __DIR__);

// Autoload classes
spl_autoload_register(function ($className) {
    // Convert namespace to file path
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $className = str_replace('Api' . DIRECTORY_SEPARATOR, '', $className);

    $file = ROOT_DIR . DIRECTORY_SEPARATOR . $className . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Load configuration
require_once ROOT_DIR . '/config/Config.php';
