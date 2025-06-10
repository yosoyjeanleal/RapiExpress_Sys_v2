<?php
namespace RapiExpress\Interface;

interface IConexionModel {

    public function inicializarConexion();
    public function verificarEstructura(): bool;
}
