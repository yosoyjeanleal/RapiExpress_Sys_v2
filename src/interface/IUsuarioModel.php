<?php
namespace RapiExpress\Interface;

interface IUsuarioModel
{
    public function registrar();
    public function actualizar(array $data);
    public function eliminar($id);
    public  function obtenerTodos();
    public function obtenerPorId($id);
    public function autenticar($username, $password);
}
