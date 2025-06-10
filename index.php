<?php

require_once __DIR__ . '/vendor/autoload.php';


use RapiExpress\Controllers\FrontController;

$c = preg_replace('/[^a-z]/', '', strtolower($_GET['c'] ?? 'auth'));
$a = preg_replace('/[^a-zA-Z]/', '', ($_GET['a'] ?? 'login'));

$frontController = new FrontController();
$frontController->handle($c, $a);
