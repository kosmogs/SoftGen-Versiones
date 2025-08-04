<?php
// ===== models/Ubicacion.php (VERSIÓN FINAL CORREGIDA) =====
namespace App\Models;
use PDO;

class Ubicacion {
    private $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    /**
     * Extrae y devuelve los valores posibles de la columna ENUM 'ubi_departamento'.
     * @return array Lista de nombres de departamentos.
     */
    public function getDepartamentos(): array {
        // Consulta para obtener la definición de la columna ENUM
        $query = "SHOW COLUMNS FROM ubicacion WHERE Field = 'ubi_departamento'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // El resultado será algo como "enum('Santander','Cundinamarca','Antioquia')"
            // Necesitamos limpiar y convertir esa cadena en un array
            $enumList = str_replace("'", "", substr($row['Type'], 5, -1));
            return explode(',', $enumList);
        }

        return []; // Devuelve un array vacío si falla
    }

    public function crear(array $data) {
        $query = "INSERT INTO ubicacion (ubi_sitio, ubi_ciudad, ubi_departamento, ubi_barrio, ubi_localidad, ubi_calle, ubi_numero)
                VALUES (:sitio, :ciudad, :departamento, :barrio, :localidad, :calle, :numero)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":sitio", $data['ubi_sitio']);
        $stmt->bindValue(":ciudad", $data['ubi_ciudad']);
        $stmt->bindValue(":departamento", $data['ubi_departamento']);
        $stmt->bindValue(":localidad", $data['ubi_localidad']);
        $stmt->bindValue(":barrio", $data['ubi_barrio']);
        $stmt->bindValue(":calle", $data['ubi_calle']);
        $stmt->bindValue(":numero", $data['ubi_numero'] ?? '');

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function readOne(int $id) {
        $query = "SELECT * FROM ubicacion WHERE id_ubicacion = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>