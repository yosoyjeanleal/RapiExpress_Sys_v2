<?php

use RapiExpress\Models\Sucursal;
use RapiExpress\Interface\ISucursalModel;

function sucursal_index() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $sucursalModel = new Sucursal();
    $sucursales = $sucursalModel->obtenerTodas();
    include __DIR__ . '/../views/sucursal/sucursal.php';
}

function sucursal_registrar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $sucursalModel = new Sucursal();

        $data = [
            'codigo' => trim($_POST['codigo']),
            'nombre_sucursal' => trim($_POST['nombre_sucursal']),
            'direccion' => trim($_POST['direccion']),
            'telefono' => trim($_POST['telefono']),
        ];

        $resultado = $sucursalModel->registrar($data);

        switch ($resultado) {
            case 'registro_exitoso':
                $_SESSION['mensaje'] = t('branch_registered_successfully');
                $_SESSION['tipo_mensaje'] = 'success';
                break;
            case 'codigo_existente':
                $_SESSION['mensaje'] = t('error_code_exists');
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            default:
                $_SESSION['mensaje'] = t('error_registering_branch');
                $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=sucursal');
        exit();
    }
}

function sucursal_editar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $sucursalModel = new Sucursal();

        $required = ['id_sucursal', 'codigo', 'nombre_sucursal', 'direccion', 'telefono'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['mensaje'] = sprintf(t('error_field_required_sprintf'), $field);
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?c=sucursal');
                exit();
            }
        }

        $data = [
            'id_sucursal' => (int)$_POST['id_sucursal'],
            'codigo' => trim($_POST['codigo']),
            'nombre_sucursal' => trim($_POST['nombre_sucursal']),
            'direccion' => trim($_POST['direccion']),
            'telefono' => trim($_POST['telefono'])
        ];

        $resultado = $sucursalModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = t('branch_updated_successfully');
            $_SESSION['tipo_mensaje'] = 'success';
        } elseif ($resultado === 'codigo_existente') {
            $_SESSION['mensaje'] = t('error_code_belongs_other_branch');
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = t('error_updating_branch');
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=sucursal');
        exit();
    }
}

function sucursal_eliminar() {
    session_start();

    if (isset($_POST['id_sucursal'])) {
        $id = $_POST['id_sucursal'];
        $sucursalModel = new Sucursal();

        $eliminado = $sucursalModel->eliminar($id);

        if ($eliminado) {
            $_SESSION['mensaje'] = t('branch_deleted_successfully');
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = t('error_deleting_branch');
            $_SESSION['tipo_mensaje'] = "error"; // Changed danger to error for consistency with other error messages
        }
    } else {
        $_SESSION['mensaje'] = t('error_branch_id_not_provided');
        $_SESSION['tipo_mensaje'] = "error"; // Changed danger to error
    }

    header("Location: index.php?c=sucursal");
    exit();
}

function sucursal_obtenerSucursales() {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sucursalModel = new Sucursal();

        $sucursal = $sucursalModel->obtenerPorId($id);
        header('Content-Type: application/json');
        echo json_encode($sucursal);
        exit();
    }
}
