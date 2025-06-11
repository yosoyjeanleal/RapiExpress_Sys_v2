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
                $_SESSION['mensaje'] = 'Sucursal registrada exitosamente';
                $_SESSION['tipo_mensaje'] = 'success';
                break;
            case 'codigo_existente':
                $_SESSION['mensaje'] = 'El código ya está registrado';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            default:
                $_SESSION['mensaje'] = 'Error al registrar la sucursal';
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
                $_SESSION['mensaje'] = "Error: El campo $field es requerido";
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
            $_SESSION['mensaje'] = 'Sucursal actualizada exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } elseif ($resultado === 'codigo_existente') {
            $_SESSION['mensaje'] = 'El código ya pertenece a otra sucursal';
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar la sucursal';
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
            $_SESSION['mensaje'] = "Sucursal eliminada correctamente.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar la sucursal.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "ID de sucursal no proporcionado.";
        $_SESSION['tipo_mensaje'] = "danger";
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
