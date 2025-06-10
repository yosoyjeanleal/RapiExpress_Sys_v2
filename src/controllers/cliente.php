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
            $_SESSION['mensaje'] = 'Formato de email inválido.';
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=cliente');
            exit();
        }

        $resultado = $clienteModel->registrar($data);

        if ($resultado === 'registro_exitoso') {
            $_SESSION['mensaje'] = 'Cliente registrado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } elseif ($resultado === 'cedula_existente') {
            $_SESSION['mensaje'] = 'Error: La cédula ya está registrada';
            $_SESSION['tipo_mensaje'] = 'error';
        } elseif ($resultado === 'email_existente') {
            $_SESSION['mensaje'] = 'Error: El email ya está registrado';
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = 'Error inesperado al registrar el cliente';
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
                $_SESSION['mensaje'] = "Error: El campo $field es requerido";
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
            $_SESSION['mensaje'] = 'Formato de email inválido';
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=cliente');
            exit();
        }

        $resultado = $clienteModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Cliente actualizado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar el cliente';
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
            $_SESSION['mensaje'] = 'Cliente eliminado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar el cliente';
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
