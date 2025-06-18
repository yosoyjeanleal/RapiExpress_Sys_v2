<?php
require_once __DIR__ . '/../models/Cliente.php';




function cliente_index() {
    $clienteModel = new \RapiExpress\Models\Cliente();
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }
    $clientes = $clienteModel->obtenerTodos();
    include __DIR__ . '/../views/cliente/cliente.php';
}

function cliente_registrar() {
    $clienteModel = new \RapiExpress\Models\Cliente();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'cedula' => trim($_POST['cedula']),
            'nombre' => trim($_POST['nombre']),
            'apellido' => trim($_POST['apellido']),
            'email' => trim($_POST['email']),
            'telefono' => trim($_POST['telefono']),
            'direccion' => trim($_POST['direccion']),
            'estado' => 'activo'
        ];

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mensaje'] = t('error_invalid_email_format');
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=cliente');
            exit();
        }

        $resultado = $clienteModel->registrar($data);

        if ($resultado === 'registro_exitoso') {
            $_SESSION['mensaje'] = t('client_registered_successfully');
            $_SESSION['tipo_mensaje'] = 'success';
        } elseif ($resultado === 'cedula_existente') {
            $_SESSION['mensaje'] = t('error_id_card_exists');
            $_SESSION['tipo_mensaje'] = 'error';
        } elseif ($resultado === 'email_existente') {
            $_SESSION['mensaje'] = t('error_email_already_exists'); // or use generic 'error_email_exists'
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = t('error_unexpected_client_registration');
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=cliente');
        exit();
    }
}

function cliente_editar() {
    $clienteModel = new \RapiExpress\Models\Cliente();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['id_cliente', 'cedula', 'nombre', 'apellido', 'email', 'telefono', 'direccion', 'estado'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                // It's better to translate the field name if possible, or use a generic message.
                // For now, using the raw field name as per the plan.
                $_SESSION['mensaje'] = sprintf(t('error_field_required_sprintf'), $field);
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?c=cliente');
                exit();
            }
        }

        $data = [
            'id_cliente' => (int)$_POST['id_cliente'],
            'cedula' => trim($_POST['cedula']),
            'nombre' => trim($_POST['nombre']),
            'apellido' => trim($_POST['apellido']),
            'email' => trim($_POST['email']),
            'telefono' => trim($_POST['telefono']),
            'direccion' => trim($_POST['direccion']),
            'estado' => trim($_POST['estado'])
        ];

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mensaje'] = t('error_invalid_email_format');
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=cliente');
            exit();
        }

        $resultado = $clienteModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = t('client_updated_successfully');
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = t('error_updating_client');
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=cliente');
        exit();
    }
}

function cliente_eliminar() {
    $clienteModel = new \RapiExpress\Models\Cliente();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        $resultado = $clienteModel->eliminar($id);

        if ($resultado) {
            $_SESSION['mensaje'] = t('client_deleted_successfully');
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = t('error_deleting_client');
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=cliente');
        exit();
    }
}

function cliente_obtenerCliente() {
    $clienteModel = new \RapiExpress\Models\Cliente();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $cliente = $clienteModel->obtenerPorId($id);

        header('Content-Type: application/json');
        echo json_encode($cliente);
        exit();
    }
}
