<?php
namespace RapiExpress\Models;

use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\IPaqueteModel;


class Paquete extends Conexion implements IPaqueteModel {

    public function registrar(array $data) {
        try {
            $stmt = $this->db->prepare("INSERT INTO paquetes (
                tracking_tienda, nuevo_tracking, id_tienda, id_courier, categoria, 
                peso_libra, peso_kilogramo, cantidad_piezas, id_cliente, id_cliente_receptor, 
                nombre_receptor, apellido_receptor, descripcion, sede, estado, fecha_registro
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

            return $stmt->execute([
                $data['tracking_tienda'],
                $data['nuevo_tracking'],
                $data['id_tienda'],
                $data['id_courier'],
                $data['categoria'],
                $data['peso_libra'],
                $data['peso_kilogramo'],
                $data['cantidad_piezas'],
                $data['id_cliente'],
                $data['id_cliente_receptor'],
                $data['nombre_receptor'],
                $data['apellido_receptor'],
                $data['descripcion'],
                $data['sede'],
                $data['estado']
            ]);
        } catch (PDOException $e) {
            error_log("Error al registrar paquete: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerTodos() {
        $stmt = $this->db->prepare("SELECT * FROM paquetes ORDER BY fecha_registro DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id_paquete) {
        $stmt = $this->db->prepare("SELECT * FROM paquetes WHERE id_paquete = ?");
        $stmt->execute([$id_paquete]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function actualizar(array $data) {
        try {
            $stmt = $this->db->prepare("UPDATE paquetes SET 
                tracking_tienda = ?, nuevo_tracking = ?, id_tienda = ?, id_courier = ?, 
                categoria = ?, peso_libra = ?, peso_kilogramo = ?, cantidad_piezas = ?, 
                id_cliente = ?, id_cliente_receptor = ?, nombre_receptor = ?, 
                apellido_receptor = ?, descripcion = ?, sede = ?, estado = ?
                WHERE id_paquete = ?");

            return $stmt->execute([
                $data['tracking_tienda'],
                $data['nuevo_tracking'],
                $data['id_tienda'],
                $data['id_courier'],
                $data['categoria'],
                $data['peso_libra'],
                $data['peso_kilogramo'],
                $data['cantidad_piezas'],
                $data['id_cliente'],
                $data['id_cliente_receptor'],
                $data['nombre_receptor'],
                $data['apellido_receptor'],
                $data['descripcion'],
                $data['sede'],
                $data['estado'],
                $data['id_paquete']
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar paquete: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id_paquete) {
        try {
            $stmt = $this->db->prepare("DELETE FROM paquetes WHERE id_paquete = ?");
            return $stmt->execute([$id_paquete]);
        } catch (PDOException $e) {
            error_log("Error al eliminar paquete: " . $e->getMessage());
            return false;
        }
    }
}
