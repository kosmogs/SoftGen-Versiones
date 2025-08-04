<?php
// ===== models/Informe.php =====
namespace App\Models;
use PDO;

class Informe {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function crear(array $data) {
        $query = "INSERT INTO informe (id_servicio, info_contenido, info_ruta_pdf, created_at, updated_at) 
                VALUES (:id_servicio, :info_contenido, :info_ruta_pdf, NOW(), NOW())";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":id_servicio", $data['id_servicio'], PDO::PARAM_INT);
        $stmt->bindValue(":info_contenido", $data['info_contenido']);
        $stmt->bindValue(":info_ruta_pdf", $data['info_ruta_pdf']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function obtenerPorServicioId(int $id_servicio) {
        $query = "SELECT * FROM informe WHERE id_servicio = :id_servicio ORDER BY id_informe DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>