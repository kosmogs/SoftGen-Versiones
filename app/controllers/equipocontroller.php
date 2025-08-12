<?php
namespace App\Controllers;

require_once __DIR__ . '/../models/equipo.php';
require_once __DIR__. '/../../config';

use PDO;
class equipocontroller{

    public function __construct(PDO $db){
        $this->equipo = new equipo($db);
    }
    public function listarEquipos(){
        $database = new ();
        $db = $database->getConnection();

        $equipo = new equipo($db);

        $stmt = $equipo->leer();
        $num = $stmt->rowCount();

        if($num > 0){
            $equipo_arr = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $equipo_item = array(
                    "id_equipo" => $id,
                    "equi_tipo_equipo" => $equi_tipo_equipo,
                    "equi_marca" => $equi_marca,
                    "equi_modelo" => $equi_modelo,
                    "equi_serie" => $equi_serie,
                    "equi_cantidad" => $equi_cantidad

                );

                array_push($equipos_arr, $equi_item);
            }

            print_r($equipos_arr);
        }else{
            echo"No se encontraron equipo.";
        }
    }
}

$controller = new equipocontroller($db);
$controller->listarEquipos();
?>