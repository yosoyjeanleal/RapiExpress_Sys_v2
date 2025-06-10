<?php

use RapiExpress\Models\Courier;

require_once __DIR__ . '/../interface/ICourierModel.php';
require_once __DIR__ . '/../models/Courier.php';



function courier_index() {
    $courierModel = new \RapiExpress\Models\Courier();
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }
    $couriers = $courierModel->obtenerTodos();
    include __DIR__ . '/../views/courier/courier.php';
}

function courier_registrar() {
    $courierModel = new \RapiExpress\Models\Courier();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'codigo' => trim($_POST['codigo']),
            'nombre' => trim($_POST['nombre']),
            'direccion' => trim($_POST['direccion']),
            'tipo' => trim($_POST['tipo'])
        ];

        $resultado = $courierModel->registrar($data);

        if ($resultado === 'registro_exitoso') {
            $_SESSION['mensaje'] = 'Courier registrado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } elseif ($resultado === 'codigo_existente') {
            $_SESSION['mensaje'] = 'Error: El código ya está registrado';
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = 'Error inesperado al registrar el courier';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=courier');
        exit();
    }
    
}


function courier_editar() {
    $courierModel = new \RapiExpress\Models\Courier();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['id_courier', 'codigo', 'nombre', 'direccion', 'tipo'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['mensaje'] = "Error: El campo $field es requerido";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?c=courier');
                exit();
            }
        }

        $data = [
            'id_courier' => (int)$_POST['id_courier'],
            'codigo' => trim($_POST['codigo']),
            'nombre' => trim($_POST['nombre']),
            'direccion' => trim($_POST['direccion']),
            'tipo' => trim($_POST['tipo'])
        ];

        $resultado = $courierModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Courier actualizado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar el courier';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=courier');
        exit();
    }
}

function courier_eliminar() {
    $courierModel = new \RapiExpress\Models\Courier();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        $resultado = $courierModel->eliminar($id);

        if ($resultado) {
            $_SESSION['mensaje'] = 'Courier eliminado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar el courier';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=courier');
        exit();
    }
}

function courier_obtenerCourier() {
    $courierModel = new \RapiExpress\Models\Courier();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $courier = $courierModel->obtenerPorId($id);

        header('Content-Type: application/json');
        echo json_encode($courier);
        exit();
    }
}
