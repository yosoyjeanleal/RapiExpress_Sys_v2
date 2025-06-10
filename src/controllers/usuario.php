<?php
// src/controllers/usuario.php

use RapiExpress\Models\Usuario;
use RapiExpress\Config\Conexion;

function usuario_index() {
   
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
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
            $_SESSION['mensaje'] = 'Todos los campos son obligatorios.';
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }

        $usuario = new Usuario($data);
        $resultado = $usuario->registrar();

        switch ($resultado) {
            case 'registro_exitoso':
                $_SESSION['mensaje'] = 'Usuario registrado exitosamente.';
                $_SESSION['tipo_mensaje'] = 'success';
                break;
            case 'documento_existente':
                $_SESSION['mensaje'] = 'El documento ya está registrado.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            case 'email_existente':
                $_SESSION['mensaje'] = 'El correo electrónico ya está registrado.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            case 'username_existente':
                $_SESSION['mensaje'] = 'El nombre de usuario ya está registrado.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            default:
                $_SESSION['mensaje'] = 'Error inesperado al registrar el usuario.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
        }

        header('Location: index.php?c=usuario');
        exit();
    }
}

function usuario_editar() {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['id', 'documento', 'username', 'nombres', 'apellidos', 'email', 'telefono', 'sucursal', 'cargo'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['mensaje'] = "Error: El campo $field es requerido";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?c=usuario');
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
            $_SESSION['mensaje'] = 'Formato de email inválido';
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }

        $usuario = new Usuario();
        $resultado = $usuario->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Usuario actualizado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar el usuario';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=usuario');
        exit();
    } else {
        header('Location: index.php?c=usuario');
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
            $_SESSION['mensaje'] = 'No puedes eliminar tu propia cuenta mientras estás logueado.';
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }

        $usuario = new Usuario();
        $resultado = $usuario->eliminar($id);

        if ($resultado) {
            $_SESSION['mensaje'] = 'Usuario eliminado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar el usuario';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=usuario');
        exit();
    }
}
function obtenerTodosUsuarios() {
    $usuarioModel = new Usuario();
    return $usuarioModel->obtenerTodos();
}

