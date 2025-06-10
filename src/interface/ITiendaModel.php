<?php
namespace RapiExpress\Interface;

interface ITiendaModel {
    public function registrar(array $data): string;
    public function obtenerTodas(): array;
    public function obtenerPorId(int $id): ?array;
    public function actualizar(array $data): bool;
    public function eliminar(int $id): bool;
    public function getLastError(): string;  // esta es la que falta
}
