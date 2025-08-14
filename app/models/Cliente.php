<?php
// ===== models/Cliente.php =====
namespace App\Models;
use PDO;

class Cliente {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }
    
    public function getClientes() {
        $query = "SELECT c.id_cliente, c.razon_social AS razon_social
                FROM cliente c
                /*JOIN usuario u ON c.id_usuario = u.id_usuario*/
                ORDER BY c.razon_social ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClienteById(int $id) {
        $query = "SELECT c.*, u.usu_nombre AS razon_social, u.usu_apellido, u.usu_correo
                FROM cliente c
                JOIN usuario u ON c.id_usuario = u.id_usuario
                WHERE c.id_cliente = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function crear(array $data) {
        $stmt = $this->db->prepare("SELECT id_cliente FROM cliente WHERE cli_nit = ?");
        $stmt->execute([$data['nit'] ?? null]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cliente) {
            return $cliente['id_cliente'];
        }
        $query = "INSERT INTO cliente (razon_social, cli_nit, contacto_nombre, contacto_correo, contacto_telefono, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$data['razon_social'] ?? '', $data['codigo'] ?? '', $data['nit'] ?? '', $data['direccion'] ?? '', $data['ciudad'] ?? '', $data['telefono'] ?? '', $data['id_usuario'] ?? null]);
        return $this->db->lastInsertId();
    }
}
?>