<?php

// Initialize Internationalization
require_once __DIR__ . '/config/i18n.php';
initializeLocalization(); // Detects lang from URL or session

require_once __DIR__ . '/vendor/autoload.php';

// Define Base URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$script_name = $_SERVER['SCRIPT_NAME']; // Path of the current script

// If index.php is in the root, dirname will be '/', otherwise it's the subdirectory path
$base_path = dirname($script_name);
if ($base_path === '/' || $base_path === '\\') { // Handle root case
    $base_path = '';
}

define('APP_URL', $protocol . $host . $base_path . '/');

use RapiExpress\Controllers\FrontController;

$c = preg_replace('/[^a-z]/', '', strtolower($_GET['c'] ?? 'auth'));
$a = preg_replace('/[^a-zA-Z]/', '', ($_GET['a'] ?? 'login'));

$frontController = new FrontController();
$frontController->handle($c, $a);
