<?php

use RapiExpress\Models\Usuario;
use RapiExpress\Config\Conexion;


session_start();

function auth_login() {
    $error = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->autenticar($username, $password);

            if ($usuario) {
                $_SESSION['usuario'] = $usuario['username'];
                $_SESSION['nombre_completo'] = $usuario['nombres'] . ' ' . $usuario['apellidos'];
                header('Location: index.php?c=dashboard&a=index');
                exit();
            } else {
                $error = "Credenciales inválidas.";
            }
        } else {
            $error = "Por favor, completa todos los campos.";
        }
    }

    include __DIR__ . '/../views/auth/login.php';
}

function auth_register() {
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'documento' => trim($_POST['documento']),
            'username' => trim($_POST['username']),
            'nombres' => trim($_POST['nombres']),
            'apellidos' => trim($_POST['apellidos']),
            'telefono' => trim($_POST['telefono']),
            'email' => trim($_POST['email']),
            'sucursal' => trim($_POST['sucursal']),
            'cargo' => trim($_POST['cargo']),
            'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT)
        ];

        if (empty($data['documento']) || empty($data['email']) || empty($data['username'])) {
            $error = "Todos los campos obligatorios deben ser completados.";
        } else {
            $usuarioModel = new Usuario($data);
            $resultado = $usuarioModel->registrar();

            switch ($resultado) {
                case 'registro_exitoso':
                    $_SESSION['registro_exitoso'] = true;
                    header('Location: index.php?c=auth&a=login&registro=exitoso');
                    exit();

                case 'documento_existente':
                    $error = "La cédula ya está registrada.";
                    break;

                case 'email_existente':
                    $error = "El correo electrónico ya está registrado.";
                    break;

                case 'username_existente':
                    $error = "El nombre de usuario ya está en uso.";
                    break;

                default:
                    $error = "Error al registrar. Intenta nuevamente.";
                    break;
            }
        }
    }

    include __DIR__ . '/../views/auth/register.php';
}

function auth_recoverPassword() {
    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $newPassword = trim($_POST['password'] ?? '');

        if (!empty($username) && !empty($newPassword)) {
            try {
                $conexionWrapper = new \RapiExpress\Config\ConexionWrapper();
$pdo = $conexionWrapper->getDb();

                
                $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
                $stmt->execute(['username' => $username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updateStmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE username = :username");
                    $updateStmt->execute([
                        'password' => $hashedPassword,
                        'username' => $username
                    ]);

                    $success = "Contraseña actualizada correctamente. Puedes iniciar sesión con tu nueva contraseña.";
                } else {
                    $error = "Usuario no encontrado.";
                }
            } catch (PDOException $e) {
                $error = "Error al conectar con la base de datos.";
            }
        } else {
            $error = "Por favor, completa todos los campos.";
        }
    }

    include __DIR__ . '/../views/auth/recoverpassword.php';
}

function auth_logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: index.php?c=auth&a=login');
    exit();
}
