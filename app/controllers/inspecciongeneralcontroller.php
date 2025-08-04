<?php
// ===== app/controllers/inspecciongeneralcontroller.php =====
// Este controlador parece ser para una funcionalidad separada (ver detalles de una inspección).
// Se corrige para que sea funcional.
namespace app\controllers;

require_once __DIR__ . '/../models/inspeccion_general.php';
use App\models\inspeccion_general;
use PDO;

class inspecciongeneralcontroller {
    private $inspeccionModel;

    public function __construct(PDO $db) {
        // CORRECCIÓN: Se usa el $db inyectado, no una propiedad inexistente.
        $this->inspeccionModel = new inspeccion_general($db);
    }

    public function mostrarDetallesInspeccion(int $id_servicio) {
        $inspeccion = $this->inspeccionModel->obtenerPorServicioId($id_servicio);

        if ($inspeccion) {
            // CORRECCIÓN: La vista debe existir en esta ruta.
            // Se asume que tienes una vista para mostrar estos detalles.
            require __DIR__ . '/../../views/inspeccion/detalles.php';
        } else {
            echo "Inspección no encontrada para el servicio ID: $id_servicio";
        }
    }
}
?>