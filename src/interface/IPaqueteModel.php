<?php
namespace RapiExpress\Interface;

interface IPaqueteModel  {
    public function registrar(array $data);
    public function obtenerTodos();
    public function obtenerPorId($id);
    public function actualizar(array $data);
    public function eliminar($id);
}