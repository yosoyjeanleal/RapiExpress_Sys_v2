<?php
namespace RapiExpress\Models;
use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\ITiendaModel;


class Tienda extends Conexion implements ITiendaModel
{
    
    public function registrar(array $data): string
    {
        try {
            if ($this->existeTracking($data['tracking'])) {
                return 'tracking_existente';
            }

            $stmt = $this->db->prepare("INSERT INTO tiendas (tracking, nombre_tienda) VALUES (?, ?)");
            $resultado = $stmt->execute([
                $data['tracking'],
                $data['nombre_tienda']
            ]);

            return $resultado ? 'registro_exitoso' : 'error_registro';

        } catch (PDOException $e) {
            error_log("Error en registro tienda: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function obtenerTodas(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM tiendas ORDER BY id_tienda DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM tiendas WHERE id_tienda = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function actualizar(array $data): bool
    {
        try {
            if ($this->existeTrackingEnOtraTienda($data['tracking'], $data['id_tienda'])) {
                return false;
            }

            $stmt = $this->db->prepare("UPDATE tiendas SET tracking = ?, nombre_tienda = ? WHERE id_tienda = ?");
            return $stmt->execute([
                $data['tracking'],
                $data['nombre_tienda'],
                $data['id_tienda']
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar tienda: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar(int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM tiendas WHERE id_tienda = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar tienda: " . $e->getMessage());
            return false;
        }
    }

    private function existeTracking(string $tracking): bool
    {
        $stmt = $this->db->prepare("SELECT id_tienda FROM tiendas WHERE tracking = ?");
        $stmt->execute([$tracking]);
        return (bool)$stmt->fetch();
    }

    private function existeTrackingEnOtraTienda(string $tracking, int $idTiendaActual): bool
    {
        $stmt = $this->db->prepare("SELECT id_tienda FROM tiendas WHERE tracking = ? AND id_tienda != ?");
        $stmt->execute([$tracking, $idTiendaActual]);
        return (bool)$stmt->fetch();
    }

    private string $lastError = '';

public function getLastError(): string
{
    return $this->lastError;
}

}
