<?php
// app/models/EmpresaModel.php

class EmpresaModel {
    private $db;

    public function __construct() {
        $this->db = getDbConnection();
    }

    /**
     * Obtiene todas las empresas de la base de datos.
     * @return array Una lista de todas las empresas.
     */
    public function obtenerTodas() {
        $stmt = $this->db->prepare("SELECT id_empresa, emp_razon_social FROM empresa ORDER BY emp_razon_social ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
}
