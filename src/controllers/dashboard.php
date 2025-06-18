<?php
// src/controllers/dashboard.php

use RapiExpress\models\Usuario;
use RapiExpress\models\Cliente;
use RapiExpress\models\Tienda;
use RapiExpress\models\Courier;

function dashboard_index() {
 

    if (!isset($_SESSION['usuario'])) {
        header('Location: ' . APP_URL . 'index.php?c=auth&a=login');
        exit();
    }

    try {
       $usuarios = obtenerTodosUsuarios();
$totalUsuarios = count($usuarios);

        $clienteModel = new Cliente();
        $clientes = $clienteModel->obtenerTodos();
        $totalClientes = count($clientes);

        $tiendaModel = new Tienda();
        $tiendas = $tiendaModel->obtenerTodas();
        $totalTiendas = count($tiendas);

        $courierModel = new Courier();
        $couriers = $courierModel->obtenerTodos();
        $totalCouriers = count($couriers);

        include __DIR__ . '/../views/dashboard.php';

    } catch (\Throwable $e) {
        error_log("Error en Dashboard: " . $e->getMessage());
        header('Location: ' . APP_URL . 'index.php?c=auth&a=login');
        exit();
    }
}
