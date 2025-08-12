<?php
namespace App\Models;
// app/models/EmpresaModel.php
use PDO;
class EmpresaModel {
    private $db;
    private $conn;

    public function __construct( PDO $db) {
        $this->db = $db;
    }

    /**
     * Obtiene todas las empresas de la base de datos.
     * @return array Una lista de todas las empresas.
     */
    public function obtenerEmpresa() {
        $query = "SELECT e.id_empresa, e.emp_razon_social AS razon_social
            FROM empresa e
            ORDER BY e.emp_razon_social ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
}
