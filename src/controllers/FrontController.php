<?php
 namespace RapiExpress\Controllers;

class FrontController
{
    private array $specialControllers = [
        'auth'     => ['methods' => ['login', 'recoverPassword', 'logout'], 'default' => 'login'],
        'dashboard'=> ['methods' => ['index'], 'default' => 'index'],
        'cliente'  => ['methods' => ['index', 'registrar', 'editar', 'eliminar', 'obtenerCliente'], 'default' => 'index'],
        'tienda'   => ['methods' => ['index', 'registrar', 'editar', 'eliminar', 'obtenerTienda'], 'default' => 'index'],
        'courier'  => ['methods' => ['index', 'registrar', 'editar', 'eliminar', 'obtenerTienda'], 'default' => 'index'],
        'sucursal'  => ['methods' => ['index', 'registrar', 'editar', 'eliminar', 'obtenerTienda'], 'default' => 'index'],
        'paquete'  => ['methods' => ['index', 'registrar', 'editar', 'eliminar', 'obtenerTienda'], 'default' => 'index'],
        'usuario'  => ['methods' => ['index', 'registrar', 'editar', 'eliminar', 'obtenerUsuario'], 'default' => 'index']
    ];

    public function handle(string $controller, string $action): void
{
    try {
        if (!array_key_exists($controller, $this->specialControllers)) {
            throw new \Exception("Controlador no válido");
        }

        $config = $this->specialControllers[$controller];
        $methodToCall = in_array($action, $config['methods']) ? $action : $config['default'];
        $controllerFile = __DIR__ . "/../controllers/$controller.php";

        if (!file_exists($controllerFile)) {
            throw new \Exception("Controlador no encontrado");
        }

        require_once $controllerFile;
        $functionName = $controller . '_' . $methodToCall;

        if (!function_exists($functionName)) {
            throw new \Exception("Acción no válida");
        }

        call_user_func($functionName);
    } catch (\Exception $e) {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
        exit;
    }
}
}
