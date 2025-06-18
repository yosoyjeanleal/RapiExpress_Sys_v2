<?php
// src/controllers/usuario.php

use RapiExpress\Models\Usuario;
use RapiExpress\Config\Conexion;

function usuario_index() {
   
    if (!isset($_SESSION['usuario'])) {
        header('Location: ' . APP_URL . 'index.php?c=auth&a=login');
        exit();
    }

    $usuarios = obtenerTodosUsuarios();
    include __DIR__ . '/../views/usuario/usuario.php';
}

function usuario_registrar() {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'documento' => trim($_POST['documento']),
            'username' => trim($_POST['username']),
            'nombres' => trim($_POST['nombres']),
            'apellidos' => trim($_POST['apellidos']),
            'email' => trim($_POST['email']),
            'telefono' => trim($_POST['telefono']),
            'sucursal' => trim($_POST['sucursal']),
            'cargo' => trim($_POST['cargo']),
            'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT)
        ];

        if (empty($data['documento']) || empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            $_SESSION['toast_message'] = t('error_all_fields_mandatory');
            $_SESSION['toast_type'] = 'error';
            header('Location: ' . APP_URL . 'index.php?c=usuario');
            exit();
        }

        $usuario = new Usuario($data);
        $resultado = $usuario->registrar();

        switch ($resultado) {
            case 'registro_exitoso':
                $_SESSION['toast_message'] = t('user_registered_successfully');
                $_SESSION['toast_type'] = 'success';
                break;
            case 'documento_existente':
                $_SESSION['toast_message'] = t('error_document_already_exists'); // Reusing generic key
                $_SESSION['toast_type'] = 'error';
                break;
            case 'email_existente':
                $_SESSION['toast_message'] = t('error_email_already_registered'); // Reusing generic key
                $_SESSION['toast_type'] = 'error';
                break;
            case 'username_existente':
                $_SESSION['toast_message'] = t('error_username_already_registered'); // Reusing generic key
                $_SESSION['toast_type'] = 'error';
                break;
            default:
                $_SESSION['toast_message'] = t('error_unexpected_user_registration');
                $_SESSION['toast_type'] = 'error';
                break;
        }

        header('Location: ' . APP_URL . 'index.php?c=usuario');
        exit();
    }
}

function usuario_editar() {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['id', 'documento', 'username', 'nombres', 'apellidos', 'email', 'telefono', 'sucursal', 'cargo'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['toast_message'] = sprintf(t('error_field_required_sprintf'), $field);
                $_SESSION['toast_type'] = 'error';
                header('Location: ' . APP_URL . 'index.php?c=usuario');
                exit();
            }
        }

        $data = [
            'id' => (int)$_POST['id'],
            'documento' => trim($_POST['documento']),
            'username' => trim($_POST['username']),
            'nombres' => trim($_POST['nombres']),
            'apellidos' => trim($_POST['apellidos']),
            'email' => trim($_POST['email']),
            'telefono' => trim($_POST['telefono']),
            'sucursal' => trim($_POST['sucursal']),
            'cargo' => trim($_POST['cargo']),
        ];

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['toast_message'] = t('error_invalid_email_format');
            $_SESSION['toast_type'] = 'error';
            header('Location: ' . APP_URL . 'index.php?c=usuario');
            exit();
        }

        $usuario = new Usuario();
        $resultado = $usuario->actualizar($data);

        if ($resultado === true) {
            $_SESSION['toast_message'] = t('user_updated_successfully');
            $_SESSION['toast_type'] = 'success';
        } else {
            $_SESSION['toast_message'] = t('error_updating_user');
            $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=usuario');
        exit();
    } else {
        header('Location: ' . APP_URL . 'index.php?c=usuario');
        exit();
    }
}

function usuario_eliminar() {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $usuarioActual = $_SESSION['usuario']; // Obtener el usuario actual de la sesión

        // Verificar si el usuario que se intenta eliminar es el mismo que tiene la sesión activa
       $usuarioModel = new Usuario();
$usuarioAEliminar = $usuarioModel->obtenerPorId($id);

        if ($usuarioAEliminar && $usuarioAEliminar['username'] === $usuarioActual) {
            $_SESSION['toast_message'] = t('error_cannot_delete_own_account');
            $_SESSION['toast_type'] = 'error';
            header('Location: ' . APP_URL . 'index.php?c=usuario');
            exit();
        }

        $usuario = new Usuario();
        $resultado = $usuario->eliminar($id);

        if ($resultado) {
            $_SESSION['toast_message'] = t('user_deleted_successfully');
            $_SESSION['toast_type'] = 'success';
        } else {
            $_SESSION['toast_message'] = t('error_deleting_user');
            $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=usuario');
        exit();
    }
}
function obtenerTodosUsuarios() {
    $usuarioModel = new Usuario();
    return $usuarioModel->obtenerTodos();
}

