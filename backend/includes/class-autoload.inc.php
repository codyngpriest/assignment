<?php
spl_autoload_register('myAutoLoader');

function myAutoLoader($className) {
    // Use __DIR__ to get the directory of the autoloader script
    $path = __DIR__ . '/../classes/';
    $extension = '.class.php';
    $fullPath = $path . $className . $extension;

    if (file_exists($fullPath)) {
        require_once $fullPath;
    } else {
        echo "File not found: $fullPath"; // Debugging
    }
}

