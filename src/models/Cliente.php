<?php
namespace RapiExpress\Models;

use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\IClienteModel;

class Cliente extends Conexion implements IClienteModel {
    public function registrar(array $data) {
        try {

            // Verificar si la cédula ya existe
            $stmtCheck = $this->db->prepare("SELECT id_cliente FROM clientes WHERE cedula = ?");
            $stmtCheck->execute([$data['cedula']]);
            if ($stmtCheck->fetch()) return 'cedula_existente';

            // Verificar si el email ya existe
            $stmtCheck = $this->db->prepare("SELECT id_cliente FROM clientes WHERE email = ?");
            $stmtCheck->execute([$data['email']]);
            if ($stmtCheck->fetch()) return 'email_existente';

            // Insertar nuevo cliente
            $stmt = $this->db->prepare("INSERT INTO clientes 
                (cedula, nombre, apellido, email, telefono, direccion, estado, fecha_registro) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

            $resultado = $stmt->execute([
                $data['cedula'],
                $data['nombre'],
                $data['apellido'],
                $data['email'],
                $data['telefono'],
                $data['direccion'],
                $data['estado']
            ]);

            return $resultado ? 'registro_exitoso' : 'error_registro';
        } catch (PDOException $e) {
            error_log("Error en registro cliente: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function obtenerTodos() {
                    
        $stmt = $this->db->prepare("SELECT * FROM clientes ORDER BY fecha_registro DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar(array $data) {
        try {
            $stmtCheck = $this->db->prepare("SELECT id_cliente FROM clientes WHERE cedula = ? AND id_cliente != ?");
            $stmtCheck->execute([$data['cedula'], $data['id_cliente']]);
            if ($stmtCheck->fetch()) return 'cedula_existente';

            $stmtCheck = $this->db->prepare("SELECT id_cliente FROM clientes WHERE email = ? AND id_cliente != ?");
            $stmtCheck->execute([$data['email'], $data['id_cliente']]);
            if ($stmtCheck->fetch()) return 'email_existente';

            $stmt = $this->db->prepare("UPDATE clientes SET 
                cedula = ?, nombre = ?, apellido = ?, email = ?, 
                telefono = ?, direccion = ?, estado = ?
                WHERE id_cliente = ?");

            return $stmt->execute([
                $data['cedula'],
                $data['nombre'],
                $data['apellido'],
                $data['email'],
                $data['telefono'],
                $data['direccion'],
                $data['estado'],
                $data['id_cliente']
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar cliente: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM clientes WHERE id_cliente = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar cliente: " . $e->getMessage());
            return false;
        }
    }
}
