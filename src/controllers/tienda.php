<?php

use RapiExpress\Models\Tienda;
use RapiExpress\Interface\ITiendaModel;





function tienda_index() {

    if (!isset($_SESSION['usuario'])) {
        header('Location: ' . APP_URL . 'index.php?c=auth&a=login');
        exit();
    }

    $tiendaModel = new Tienda();
    $tiendas = $tiendaModel->obtenerTodas();
    include __DIR__ . '/../views/tienda/tienda.php';
}

function tienda_registrar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $tiendaModel = new Tienda();

        $data = [
            'tracking' => trim($_POST['tracking']),
            'nombre_tienda' => trim($_POST['nombre_tienda']),
        ];

        $resultado = $tiendaModel->registrar($data);

        switch ($resultado) {
            case 'registro_exitoso':
                $_SESSION['toast_message'] = t('store_registered_successfully');
                $_SESSION['toast_type'] = 'success';
                break;
            case 'tracking_existente':
                $_SESSION['toast_message'] = t('error_tracking_code_exists');
                $_SESSION['toast_type'] = 'error';
                break;
            default:
                $_SESSION['toast_message'] = t('error_registering_store');
                $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=tienda');
        exit();
    }
}

function tienda_editar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $tiendaModel = new Tienda();

        $required = ['id_tienda', 'tracking', 'nombre_tienda'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['toast_message'] = sprintf(t('error_field_required_sprintf'), $field);
                $_SESSION['toast_type'] = 'error';
                header('Location: ' . APP_URL . 'index.php?c=tienda');
                exit();
            }
        }

        $data = [
            'id_tienda' => (int)$_POST['id_tienda'],
            'tracking' => trim($_POST['tracking']),
            'nombre_tienda' => trim($_POST['nombre_tienda'])
        ];

        $resultado = $tiendaModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['toast_message'] = t('store_updated_successfully');
            $_SESSION['toast_type'] = 'success';
        } elseif ($resultado === 'tracking_existente') {
            $_SESSION['toast_message'] = t('error_tracking_code_belongs_other_store');
            $_SESSION['toast_type'] = 'error';
        } else {
            $_SESSION['toast_message'] = t('error_updating_store');
            $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=tienda');
        exit();
    }
}

function tienda_eliminar() {
    session_start();

    if (isset($_POST['id_tienda'])) {
        $id = $_POST['id_tienda'];
        $tiendaModel = new Tienda();

        $eliminado = $tiendaModel->eliminar($id);

        if ($eliminado) {
            $_SESSION['toast_message'] = t('store_deleted_successfully');
            $_SESSION['toast_type'] = "success";
        } else {
            $_SESSION['toast_message'] = t('error_deleting_store');
            $_SESSION['toast_type'] = "error";
        }
    } else {
        $_SESSION['toast_message'] = t('error_store_id_not_provided');
        $_SESSION['toast_type'] = "error";
    }

    header("Location: " . APP_URL . "index.php?c=tienda");
    exit();
}

function tienda_obtenerTienda() {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $tiendaModel = new Tienda();

        $tienda = $tiendaModel->obtenerPorId($id);
        header('Content-Type: application/json');
        echo json_encode($tienda);
        exit();
    }
}
