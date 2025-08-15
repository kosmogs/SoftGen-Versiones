<?php
namespace App\Controllers;

require_once __DIR__ . '/../models/equipo.php';
use app\Models\equipo;


use PDO;
class equipocontroller{
    private $equipo;


    public function __construct(PDO $db){
        $this->equipo = new equipo($db);
    }
    public function listarEquipos(){
        $stmt = $this->equipo->listar();
        $num = $stmt->rowCount();


        if($num > 0){
            //$equipos_arr = array();
           // $equipos_arr["records"] = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $equipo_item = array(
                    "id_equipo" => $id_equipo,
                    "equi_tipo_equipo" => $equi_tipo_equipo,
                    "equi_marca" => $equi_marca,
                    "equi_modelo" => $equi_modelo,
                    "equi_serie" => $equi_serie,
                    "equi_cantidad" => $equi_cantidad

                );

                //array_push($equipos_arr["records"], $equipo_item);
            }

            http_response_code(200);
            //echo json_encode($equipos_arr);

        }else{
            http_response_code(404);
            echo json_encode(
                array ( "No se encontraron equipos.")
            );
        }
    }
}

$controller = new equipocontroller($db);
$controller->listarEquipos();
?>