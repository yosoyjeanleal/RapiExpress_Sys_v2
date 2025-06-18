<?php

use RapiExpress\Models\Usuario;
use RapiExpress\Config\Conexion;


session_start();

// --- Funciones CSRF ---
function generate_csrf_token() {
    // session_start() ya está al inicio del archivo
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token_from_form) {
    // session_start() ya está al inicio del archivo
    if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token_from_form)) {
        // Token válido, eliminarlo para prevenir reutilización
        unset($_SESSION['csrf_token']);
        return true;
    }
    // Si el token no es válido, también es buena idea eliminarlo si existe,
    // aunque en este caso, si no coincide, es probable que sea un intento malicioso
    // o una sesión expirada.
    if (isset($_SESSION['csrf_token'])){
        unset($_SESSION['csrf_token']);
    }
    return false;
}
// --- Fin Funciones CSRF ---

function auth_login() {
    $error = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar token CSRF primero
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            $error = t('error_validation_csrf');
            // Generar un nuevo token para el siguiente intento del formulario
            $csrf_token = generate_csrf_token();
            include __DIR__ . '/../views/auth/login.php';
            return; // Usar return en lugar de exit() para consistencia si esto es parte de un framework más grande.
        }

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->autenticar($username, $password);

            if ($usuario) {
                $_SESSION['usuario'] = $usuario['username'];
                $_SESSION['nombre_completo'] = $usuario['nombres'] . ' ' . $usuario['apellidos'];
                header('Location: ' . APP_URL . 'index.php?c=dashboard&a=index');
                exit();
            } else {
                $error = t('error_invalid_credentials');
            }
        } else {
            $error = t('error_please_complete_all_fields');
        }
    }

    // Generar token CSRF para mostrar en el formulario
    $csrf_token = generate_csrf_token();
    include __DIR__ . '/../views/auth/login.php';
}

function auth_register() {
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Verificar token CSRF primero
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            $error = t('error_validation_csrf');
            $csrf_token = generate_csrf_token(); // Regenerar token para el siguiente intento
            include __DIR__ . '/../views/auth/register.php';
            return;
        }

        // 2. Verificar confirmación de contraseña
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        if ($password !== $confirm_password) {
            $error = t('error_passwords_no_match');
            $csrf_token = generate_csrf_token(); // Regenerar token
            include __DIR__ . '/../views/auth/register.php';
            return;
        }

        // Continuar con la lógica de registro si todo está bien
        $data = [
            'documento' => trim($_POST['documento']),
            'username' => trim($_POST['username']),
            'nombres' => trim($_POST['nombres']),
            'apellidos' => trim($_POST['apellidos']),
            'telefono' => trim($_POST['telefono']),
            'email' => trim($_POST['email']),
            'sucursal' => trim($_POST['sucursal']),
            'cargo' => trim($_POST['cargo']),
            'password' => password_hash($password, PASSWORD_DEFAULT) // Usar la variable $password ya saneada
        ];

        // Validar campos obligatorios (se pueden añadir más validaciones aquí)
        if (empty($data['documento']) || empty($data['username']) || empty($data['nombres']) || empty($data['apellidos']) || empty($data['email']) || empty($password)) {
            $error = t('error_all_fields_required');
            // No es necesario regenerar CSRF token aquí si la validación de campos falla,
            // ya que el token original (si era válido) no se ha consumido.
            // Pero si se quiere ser extra cauto o si el flujo pudiera consumir el token antes, se regeneraría.
            // Por ahora, asumimos que verify_csrf_token es lo primero que se ejecuta y consume el token.
            // Para mantener la consistencia con los otros manejos de error que muestran el formulario, generamos uno nuevo.
            $csrf_token = generate_csrf_token();
        } else {
            $usuarioModel = new Usuario($data);
            $resultado = $usuarioModel->registrar();

            switch ($resultado) {
                case 'registro_exitoso':
                    $_SESSION['toast_message'] = t('registration_successful_notice');
                    $_SESSION['toast_type'] = 'success';
                    header('Location: ' . APP_URL . 'index.php?c=auth&a=login');
                    exit();

                case 'documento_existente':
                    $error = t('error_document_exists');
                    break;

                case 'email_existente':
                    $error = t('error_email_exists');
                    break;

                case 'username_existente':
                    $error = t('error_username_exists');
                    break;

                default: // Incluye 'error_bd' y cualquier otro caso no específico
                    $error = t('error_registration_failed'); // O podría ser t('error_generic_db') si es más apropiado
                    break;
            }
        }
    }

    // Generar token CSRF para mostrar en el formulario (GET request o si POST falla antes de redirect)
    $csrf_token = generate_csrf_token();
    include __DIR__ . '/../views/auth/register.php';
}

function auth_recoverPassword() {
    // $error and $success local variables are no longer strictly needed here if all POST paths redirect.
    // However, they are kept for the case where the view is re-rendered on CSRF error.
    $error = '';
    // $success = ''; // Success always redirects with a toast

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar token CSRF primero
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            $error = t('error_validation_csrf'); // This error will be shown on the re-rendered page
            $csrf_token = generate_csrf_token();
            include __DIR__ . '/../views/auth/recoverpassword.php';
            return;
        }

        $username = trim($_POST['username'] ?? '');
        $newPassword = trim($_POST['password'] ?? '');

        if (!empty($username) && !empty($newPassword)) {
            $usuarioModel = new Usuario();
            $updateResult = $usuarioModel->updatePasswordByUsername($username, $newPassword);

            if ($updateResult) {
                $_SESSION['toast_message'] = t('success_password_updated');
                $_SESSION['toast_type'] = 'success';
                header('Location: ' . APP_URL . 'index.php?c=auth&a=login');
                exit();
            } else {
                $_SESSION['toast_message'] = t('error_updating_password');
                $_SESSION['toast_type'] = 'error';
                header('Location: ' . APP_URL . 'index.php?c=auth&a=recoverPassword');
                exit();
            }
        } else {
            $_SESSION['toast_message'] = t('error_please_complete_all_fields');
            $_SESSION['toast_type'] = 'error';
            header('Location: ' . APP_URL . 'index.php?c=auth&a=recoverPassword');
            exit();
        }
    }

    // Generar token CSRF para mostrar en el formulario (GET request or CSRF error)
    $csrf_token = generate_csrf_token();
    include __DIR__ . '/../views/auth/recoverpassword.php';
}

function auth_logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: ' . APP_URL . 'index.php?c=auth&a=login');
    exit();
}
