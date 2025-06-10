<?php
namespace RapiExpress\Models;

use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\ICourierModel;



class Courier extends Conexion implements ICourierModel {
    public function registrar(array $data) {
        try {
            // Verificar si el código ya existe
            $stmtCheck = $this->db->prepare("SELECT id_courier FROM couriers WHERE codigo = ?");
            $stmtCheck->execute([$data['codigo']]);
            if ($stmtCheck->fetch()) return 'codigo_existente';

            // Insertar nuevo courier
            $stmt = $this->db->prepare("INSERT INTO couriers (codigo, nombre, direccion, tipo) VALUES (?, ?, ?, ?)");

            $resultado = $stmt->execute([
                $data['codigo'],
                $data['nombre'],
                $data['direccion'],
                $data['tipo']
            ]);

            return $resultado ? 'registro_exitoso' : 'error_registro';
        } catch (PDOException $e) {
            error_log("Error en registro de courier: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function obtenerTodos() {
        $stmt = $this->db->prepare("SELECT * FROM couriers ORDER BY id_courier DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM couriers WHERE id_courier = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function actualizar(array $data) {
        try {
            $stmt = $this->db->prepare("UPDATE couriers SET codigo = ?, nombre = ?, direccion = ?, tipo = ? WHERE id_courier = ?");
            return $stmt->execute([
                $data['codigo'],
                $data['nombre'],
                $data['direccion'],
                $data['tipo'],
                $data['id_courier']
            ]);
        } catch (PDOException $e) {
            error_log("Error en actualizar courier: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM couriers WHERE id_courier = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar courier: " . $e->getMessage());
            return false;
        }
    }
}
