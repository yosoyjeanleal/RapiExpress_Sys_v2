<?php
namespace RapiExpress\Models;

use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\ISucursalModel;

class Sucursal extends Conexion implements ISucursalModel
{
    private string $lastError = '';

    public function registrar(array $data): string
    {
        try {
            if ($this->existeCodigo($data['codigo'])) {
                return 'codigo_existente';
            }

            $stmt = $this->db->prepare("INSERT INTO sucursales (codigo, nombre_sucursal) VALUES (?, ?)");
            $resultado = $stmt->execute([
                $data['codigo'],
                $data['nombre_sucursal']
            ]);

            return $resultado ? 'registro_exitoso' : 'error_registro';

        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error en registro sucursal: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function obtenerTodas(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM sucursales ORDER BY id_sucursal DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM sucursales WHERE id_sucursal = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function actualizar(array $data): bool
    {
        try {
            if ($this->existeCodigoEnOtraSucursal($data['codigo'], $data['id_sucursal'])) {
                return false;
            }

            $stmt = $this->db->prepare("UPDATE sucursales SET codigo = ?, nombre_sucursal = ? WHERE id_sucursal = ?");
            return $stmt->execute([
                $data['codigo'],
                $data['nombre_sucursal'],
                $data['id_sucursal']
            ]);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al actualizar sucursal: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar(int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM sucursales WHERE id_sucursal = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al eliminar sucursal: " . $e->getMessage());
            return false;
        }
    }

    private function existeCodigo(string $codigo): bool
    {
        $stmt = $this->db->prepare("SELECT id_sucursal FROM sucursales WHERE codigo = ?");
        $stmt->execute([$codigo]);
        return (bool)$stmt->fetch();
    }

    private function existeCodigoEnOtraSucursal(string $codigo, int $idSucursalActual): bool
    {
        $stmt = $this->db->prepare("SELECT id_sucursal FROM sucursales WHERE codigo = ? AND id_sucursal != ?");
        $stmt->execute([$codigo, $idSucursalActual]);
        return (bool)$stmt->fetch();
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }
}
