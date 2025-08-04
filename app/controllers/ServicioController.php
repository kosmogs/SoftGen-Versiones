<?php

namespace app\controllers;
require_once '../vendor/autoload.php';
require_once __DIR__ .'/../models/ServicioModel.php';
require_once __DIR__ .'/../models/Servicio.php';
// Es importante asegurarse de que los modelos necesarios se carguen en index.php
// require_once '../app/models/ServicioModel.php';

use App\models\Servicio;
use App\Models\ServicioModel;
use models\Informe;
use PDO;


class ServicioController {
    private $conn;
    private $servicio;

    public function __construct(PDO $db) {
        $this->servicio = new ServicioModel($db);
    }
    
    public function mostrarFormularioCrear() {
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /softGenn/public/index.php?action=login');
            exit();
        }
        require_once '../app/views/informes/crear_informe.php';
    }



    public function guardarInforme() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST;
            $uploadDir = '../public/uploads/';

            // Procesar firmas
            $datos['ser_firma_tecnico'] = $this->guardarFirma($datos['ser_firma_tecnico'], 'firma_tecnico_', $uploadDir . 'firmas/');
            $datos['ser_firma_cliente'] = $this->guardarFirma($datos['ser_firma_cliente'], 'firma_cliente_', $uploadDir . 'firmas/');
            
            // Procesar fotos y sus descripciones
            $rutasFotos = [];
            if (!empty($_FILES['fotos']['name'][0])) {
                $rutasFotos = $this->guardarFotos($_FILES['fotos'], $datos['foto_descripciones'] ?? [], $uploadDir . 'fotos/');
            }
            
            $nuevoServicioId = $this->servicio->guardarInformeCompleto($datos, $rutasFotos);

            if ($nuevoServicioId) {
                header('Location: /softGenn/public/index.php?action=generar_pdf&id=' . $nuevoServicioId);
            } else {
                header('Location: /softGenn/public/index.php?action=crear_informe&error=' . urlencode('Hubo un error al guardar. Revise los datos.'));
            }
            exit();
        }
    }

    public function generarPdf() {
        $id = $_GET['id'] ?? null;
        if (!$id) { die("ID de informe no especificado."); }

        $datosCompletos = $this->servicio->obtenerInformeCompletoPorId($id);
        if (!$datosCompletos) { die("Informe no encontrado."); }

        extract($datosCompletos); 

        ob_start();
        require_once '../app/views/informes/reporte_pdf.php';
        $html = ob_get_clean();

        try {
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output('Informe_Servicio_' . $id . '.pdf', 'I'); 
        } catch (\Mpdf\MpdfException $e) {
            die("Error al generar el PDF: " . $e->getMessage());
        }
    }
    
    private function guardarFirma($dataBase64, $prefix, $directorio) {
        if (empty($dataBase64) || !str_contains($dataBase64, 'base64')) return null;
        list(, $data) = explode(',', $dataBase64);
        $data = base64_decode($data);
        $nombreArchivo = $prefix . uniqid() . '.png';
        $rutaCompleta = $directorio . $nombreArchivo;
        if (!is_dir($directorio)) mkdir($directorio, 0777, true);
        file_put_contents($rutaCompleta, $data);
        return str_replace('../public/', '', $directorio) . $nombreArchivo;
    }

    private function guardarFotos($files, $descripciones, $directorio) {
        $rutas = [];
        if (!is_dir($directorio)) mkdir($directorio, 0777, true);
        foreach ($files['tmp_name'] as $key => $tmpName) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                $nombreArchivo = 'foto_' . uniqid() . '_' . basename($files['name'][$key]);
                $rutaCompleta = $directorio . $nombreArchivo;
                if (move_uploaded_file($tmpName, $rutaCompleta)) {
                    $rutas[] = [
                        'ruta' => str_replace('../public/', '', $directorio) . $nombreArchivo,
                        'descripcion' => $descripciones[$key] ?? ''
                    ];
                }
            }
        }
        return $rutas;
    }
}
