<?php




function paquete_index() {
    $paqueteModel = new \RapiExpress\Models\Paquete();
    if (!isset($_SESSION['usuario'])) {
        header('Location: ' . APP_URL . 'index.php?c=auth&a=login');
        exit();
    }
    $paquetes = $paqueteModel->obtenerTodos();
    include __DIR__ . '/../views/paquete/paquete.php';
}

function paquete_registrar() {
    $paqueteModel = new \RapiExpress\Models\Paquete();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'tracking_tienda' => trim($_POST['tracking_tienda']),
            'nuevo_tracking' => trim($_POST['nuevo_tracking']),
            'id_tienda' => !empty($_POST['id_tienda']) ? (int)$_POST['id_tienda'] : null,
            'id_courier' => (int)$_POST['id_courier'],
            'categoria' => $_POST['categoria'],
            'peso_libra' => (float)$_POST['peso_libra'],
            'peso_kilogramo' => (float)$_POST['peso_kilogramo'],
            'cantidad_piezas' => (int)$_POST['cantidad_piezas'],
            'id_cliente' => (int)$_POST['id_cliente'],
            'id_cliente_receptor' => (int)$_POST['id_cliente_receptor'],
            'nombre_receptor' => trim($_POST['nombre_receptor']),
            'apellido_receptor' => trim($_POST['apellido_receptor']),
            'descripcion' => trim($_POST['descripcion']),
            'sede' => $_POST['sede'],
            'estado' => $_POST['estado'] ?? 'entrada'
        ];

        $resultado = $paqueteModel->registrar($data);

        if ($resultado === true) {
            $_SESSION['toast_message'] = t('package_registered_successfully');
            $_SESSION['toast_type'] = 'success';
        } else {
            $_SESSION['toast_message'] = t('error_registering_package');
            $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=paquete');
        exit();
    }
}

function paquete_editar() {
    $paqueteModel = new \RapiExpress\Models\Paquete();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'id_paquete' => (int)$_POST['id_paquete'],
            'tracking_tienda' => trim($_POST['tracking_tienda']),
            'nuevo_tracking' => trim($_POST['nuevo_tracking']),
            'id_tienda' => !empty($_POST['id_tienda']) ? (int)$_POST['id_tienda'] : null,
            'id_courier' => (int)$_POST['id_courier'],
            'categoria' => $_POST['categoria'],
            'peso_libra' => (float)$_POST['peso_libra'],
            'peso_kilogramo' => (float)$_POST['peso_kilogramo'],
            'cantidad_piezas' => (int)$_POST['cantidad_piezas'],
            'id_cliente' => (int)$_POST['id_cliente'],
            'id_cliente_receptor' => (int)$_POST['id_cliente_receptor'],
            'nombre_receptor' => trim($_POST['nombre_receptor']),
            'apellido_receptor' => trim($_POST['apellido_receptor']),
            'descripcion' => trim($_POST['descripcion']),
            'sede' => $_POST['sede'],
            'estado' => $_POST['estado']
        ];

        $resultado = $paqueteModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['toast_message'] = t('package_updated_successfully');
            $_SESSION['toast_type'] = 'success';
        } else {
            $_SESSION['toast_message'] = t('error_updating_package');
            $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=paquete');
        exit();
    }
}

function paquete_eliminar() {
    $paqueteModel = new \RapiExpress\Models\Paquete();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int)$_POST['id_paquete'];

        $resultado = $paqueteModel->eliminar($id);

        if ($resultado) {
            $_SESSION['toast_message'] = t('package_deleted_successfully');
            $_SESSION['toast_type'] = 'success';
        } else {
            $_SESSION['toast_message'] = t('error_deleting_package');
            $_SESSION['toast_type'] = 'error';
        }

        header('Location: ' . APP_URL . 'index.php?c=paquete');
        exit();
    }
}

function paquete_obtenerPaquete() {
    $paqueteModel = new \RapiExpress\Models\Paquete();

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $paquete = $paqueteModel->obtenerPorId($id);

        header('Content-Type: application/json');
        echo json_encode($paquete);
        exit();
    }
}
