<?php

use RapiExpress\Models\Courier;

require_once __DIR__ . '/../interface/ICourierModel.php';
require_once __DIR__ . '/../models/Courier.php';



function courier_index() {
    $courierModel = new \RapiExpress\Models\Courier();
    if (!isset($_SESSION['usuario'])) {
        header('Location: ' . APP_URL . 'index.php?c=auth&a=login');
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
            $_SESSION['toast_message'] = t('courier_registered_successfully');
            $_SESSION['toast_type'] = 'success';
        } elseif ($resultado === 'codigo_existente') {
            $_SESSION['toast_message'] = t('error_code_exists'); // Reusing generic code exists error
            $_SESSION['toast_type'] = 'error';
        } else {
            $_SESSION['toast_message'] = t('error_unexpected_courier_registration');
            $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=courier');
        exit();
    }
    
}


function courier_editar() {
    $courierModel = new \RapiExpress\Models\Courier();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['id_courier', 'codigo', 'nombre', 'direccion', 'tipo'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['toast_message'] = sprintf(t('error_field_required_sprintf'), $field);
                $_SESSION['toast_type'] = 'error';
                header('Location: ' . APP_URL . 'index.php?c=courier');
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
            $_SESSION['toast_message'] = t('courier_updated_successfully');
            $_SESSION['toast_type'] = 'success';
        } else {
            // Consider if 'codigo_existente' can be returned by update, if so, handle it.
            // For now, a generic update error.
            $_SESSION['toast_message'] = t('error_updating_courier');
            $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=courier');
        exit();
    }
}

function courier_eliminar() {
    $courierModel = new \RapiExpress\Models\Courier();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        $resultado = $courierModel->eliminar($id);

        if ($resultado) {
            $_SESSION['toast_message'] = t('courier_deleted_successfully');
            $_SESSION['toast_type'] = 'success';
        } else {
            $_SESSION['toast_message'] = t('error_deleting_courier');
            $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=courier');
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
