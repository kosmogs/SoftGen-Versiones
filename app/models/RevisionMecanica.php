<?php

namespace App\Models;
use PDO;

class RevisionMecanica {
    private $conn;

    public function __construct(PDO $db){
        $this->conn = $db;
    }


    /**
     * @param  array $datos $name
     * @return string|false 
     */

    public function crear (array $datos){
        $query = "INSERT INTO revision_mecanica (rm_ejes, rm_rodamientos, rm_chumaceras, rm_poleas, rm_correas, rm_ductos, rm_rejillas, rm_pintura)values
        (:rm_ejes, :rm_rodamientos, :rm_chumaceras, :rm_poleas, :rm_correas, :rm_ductos, :rm_rejillas, :rm_pintura)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':rm_ejes', $datos['rm_ejes'], PDO::PARAM_INT);
        $stmt->bindValue(':rm_rodamientos', $datos['rm_rodamientos'], PDO::PARAM_INT);
        $stmt->bindValue(':rm_chumaceras', $datos['rm_chumaceras'], PDO::PARAM_INT);
        $stmt->bindValue(':rm_poleas', $datos['rm_poleas'], PDO::PARAM_INT);
        $stmt->bindValue(':rm_correas', $datos['rm_correas'], PDO::PARAM_INT);
        $stmt->bindValue(':rm_ductos', $datos['rm_ductos'], PDO::PARAM_INT);
        $stmt->bindValue(':rm_rejillas', $datos['rm_rejillas'], PDO::PARAM_INT);
        $stmt->bindValue(':rm_pintura', $datos['rm_pintura'], PDO::PARAM_INT);

        if($stmt->execute()) {

            return $this->conn->lastInsertId();
        }

        return false;
    }
}