<?php
 namespace App\Models;
 require_once __DIR__ . '/../../config/config.php';

 use PDO;

 class equipo{
    private $id_equipo;
    private $equi_tipo_equipo;
    private $equi_marca;
    private $equi_modelo;
    private $equi_serie;
    private $equi_cantidad;
    private $db;
    private $conn;
    private $equipo;

    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function crear($equi_tipo_equipo, $equi_marca, $equi_modelo, $equi_serie, $equi_cantidad){
        $query = "insert into". $this->equipo ."(equi_tipo_equipo, equi_marca, equi_modelo, equi_serie, equi_cantidad) values (:equi_tipo_equipo, :equi_marca, :equi_modelo, :equi_serie, :equi_cantidad)";

        $stmt = $this->conn->prepare($query);
        //intección sql
        $equi_tipo_equipo = htmlspecialchars(strip_tags($equi_tipo_equipo));
        $equi_marca = htmlspecialchars(strip_tags($equi_marca));
        $equi_modelo = htmlspecialchars(strip_tags($equi_modelo));
        $equi_serie = htmlspecialchars(strip_tags($equi_serie));
        $equi_cantidad = htmlspecialchars(strip_tags($equi_cantidad));


        $stmt->bindParam(":equi_tipo_equipo", $equi_tipo_equipo);
        $stmt->bindParam(":equi_marca", $equi_marca);
        $stmt->bindParam(":equi_modelo", $equi_modelo);
        $stmt->bindParam(":equi_serie", $equi_serie);
        $stmt->bindParam(":equi_cantidad", $equi_cantidad);

        //ejecución

        if($stmt->execute()){
            return true;
        }

        return false;

    }

    public function obtenerPorId($id_equipo){
        $query = "SELECT equi_tipo_equipo, equi_marca, equi_serie". $this->equipo . "WHERE id_equipo = ? Limit 0.1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_equipo);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            $this->equi_tipo_equipo = $row['Tipo de equipo'];
            $this->equi_marca = $row['Marca'];
            $this->equi_serie = $row['Serie'];

        }
    }
}
?>