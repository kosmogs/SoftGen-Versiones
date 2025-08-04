<?php
// ===== models/Tecnico.php =====
namespace App\Models;
use PDO;

class Tecnico {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function obtenerPorUsuario(int $usuario_id) {
        $stmt = $this->db->prepare("SELECT ID_tecnico FROM tecnico WHERE ID_usuario = :usuario_id");
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['ID_tecnico'] : null;
    }

    public function crearTecnico(int $usuario_id) {
        $stmt = $this->db->prepare("INSERT INTO tecnico (ID_usuario) VALUES (:usuario_id)");
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
    
    public function obtenerInfoCompleta(int $id_tecnico) {
        $query = "SELECT t.ID_tecnico, u.usu_nombre, u.usu_apellido, u.usu_correo 
                FROM tecnico t 
                JOIN usuario u ON t.ID_usuario = u.id_usuario 
                WHERE t.ID_tecnico = :id_tecnico";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_tecnico', $id_tecnico, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>