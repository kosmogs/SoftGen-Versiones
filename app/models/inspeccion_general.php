<?php
// ===== models/inspeccion_general.php =====
namespace App\Models;
use PDO;

class inspeccion_general {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function crear(array $data) {
        $query = "INSERT INTO inspeccion_general (id_servicio, ig_goteras, ig_gabinete, ig_filtro, ig_drenaje, ig_serpentina, ig_refrigerante, ig_vibracion, ig_tablero_electronico, ig_aislamiento_gabinete, ig_flujo_aire, ig_amperios, ig_voltaje, ig_temp_suministro, ig_temp_retorno) 
                  VALUES (:id_servicio, :ig_goteras, :ig_gabinete, :ig_filtro, :ig_drenaje, :ig_serpentina, :ig_refrigerante, :ig_vibracion, :ig_tablero_electronico, :ig_aislamiento_gabinete, :ig_flujo_aire, :ig_amperios, :ig_voltaje, :ig_temp_suministro, :ig_temp_retorno)";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id_servicio', $data['id_servicio'], PDO::PARAM_INT);
        $stmt->bindValue(':ig_goteras', isset($data['ig_goteras']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_gabinete', isset($data['ig_gabinete']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_filtro', isset($data['ig_filtro']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_drenaje', isset($data['ig_drenaje']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_serpentina', isset($data['ig_serpentina']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_refrigerante', isset($data['ig_refrigerante']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_vibracion', isset($data['ig_vibracion']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_tablero_electronico', isset($data['ig_tablero_electronico']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_aislamiento_gabinete', isset($data['ig_aislamiento_gabinete']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_flujo_aire', isset($data['ig_flujo_aire']) ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':ig_amperios', $data['ig_amperios']);
        $stmt->bindValue(':ig_voltaje', $data['ig_voltaje']);
        $stmt->bindValue(':ig_temp_suministro', $data['ig_temp_suministro']);
        $stmt->bindValue(':ig_temp_retorno', $data['ig_temp_retorno']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function obtenerPorServicioId(int $id_servicio) {
        $query = "SELECT * FROM inspeccion_general WHERE id_servicio = :id_servicio LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>