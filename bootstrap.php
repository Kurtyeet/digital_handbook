<?php
/**
 * Autoloader for Employee Leave Management Portal
 * Simple class autoloader for development without Composer
 */

spl_autoload_register(function ($className) {
    // Convert namespace to directory path
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $className = str_replace('EmployeeLeave' . DIRECTORY_SEPARATOR, '', $className);
    
    // Look for class files in includes directory
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $className . '.php';
    
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    
    return false;
});

// Load configuration
require_once __DIR__ . '/config/config.php';

// Initialize error handling
set_error_handler('customErrorHandler');
set_exception_handler('customExceptionHandler');

function customErrorHandler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    
    error_log("Error: $message in $file on line $line");
    
    if ($severity === E_ERROR || $severity === E_USER_ERROR) {
        die("Fatal error occurred. Please check error logs.");
    }
    
    return true;
}

function customExceptionHandler($exception) {
    error_log("Uncaught exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());
    die("Application error occurred. Please try again later.");
}
?>