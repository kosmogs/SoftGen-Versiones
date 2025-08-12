<?php

// ===== app/controllers/InformeController.php =====
// ESTE ES EL CONTROLADOR MÁS IMPORTANTE.
// Unifica el guardado de datos y la generación del PDF.
namespace app\controllers;

// CORRECCIÓN: Se incluyen todos los modelos necesarios y Dompdf.
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Ubicacion.php';
require_once __DIR__ . '/../models/Servicio.php';
require_once __DIR__ . '/../models/UsuarioModel.php';
require_once __DIR__ . '/../models/inspeccion_general.php';
require_once __DIR__ . '/../models/Informe.php';
require_once __DIR__ . '/../models/Tecnico.php';
require_once __DIR__.  '/../models/EmpresaModel.php';
require_once __DIR__ . '/../models/ServicioModel.php';
//require_once __DIR__ . '/../../vendor/autoload.php';
//require_once __DIR__ . '/../../vendor/mpdf/mpdf';

use App\Models\Cliente;
use App\Models\Ubicacion;
use App\models\Servicio;
use App\Models\UsuarioModel;
use App\models\inspeccion_general;
use App\Models\Informe;
use App\Models\Tecnico;
use App\Models\ServicioModel;
use App\Models\EmpresaModel;
use Composer\Autoload;
use Mpdf\Mpdf;
use PDO;

class InformeController {
    private $conn;
    private $clienteModel, $servicio, $ubicacionModel, $servicioModel, $informeModel, $tecnicoModel, $inspeccionGeneralModel, $EmpresaModel;
    

    public function __construct(PDO $db) {
        $this->conn = $db;
        $this->clienteModel = new Cliente($this->conn);
        $this->ubicacionModel = new Ubicacion($this->conn);
        $this->servicioModel = new ServicioModel($this->conn);
        $this->servicio = new servicio($this->conn);
        $this->informeModel = new Informe($this->conn);
        $this->tecnicoModel = new Tecnico($this->conn);
        $this->inspeccionGeneralModel = new inspeccion_general($this->conn);
        $this->EmpresaModel = new EmpresaModel($this->conn);
    }

    public function mostrarFormulario() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        //echo "Depurando la sesión en InformeController...<br>";
        //echo "<pre>";
        //var_dump($_SESSION);
        //echo "</pre>";
        //die("--- Fin de la depuración. El script se ha detenido intencionadamente. ---");
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 2) {
            header('location: /softgenn/public/index.php?action=login');
            exit;
           // header('Location: ?url=login'); exit;

        }


        // Lógica correcta:
        // 1. Obtener la lista de clientes.
        $clientes = $this->clienteModel->getClientes();
    
        // 2. Obtener la lista de departamentos DESDE EL MODELO.
        $departamentos = $this->ubicacionModel->getDepartamentos();

        //mostrar tipo de servicio select crear informe
        $tipo_servicio = $this->servicioModel->mostrarTipoServicio();

        //mostrar tipo de informe select crear informe
        $tipo_informe = $this->servicioModel->mostrarTipoInforme();

        //mostrar empresa selecr crear informe
        $empresas = $this->EmpresaModel->obtenerEmpresa();



        // 3. Cargar la vista con las variables correctas ($clientes y $departamentos).
        require __DIR__ . '/../views/informes/crear_informe.php';
    }


    public function showCreateForm() {
        // --- AQUÍ ESTÁ LA LÓGICA CLAVE ---
        // 1. Obtener la lista de departamentos desde el modelo
        $departamentos = $this->ubicacionModel->getDepartamentos();

        // 2. Obtener otros datos necesarios para el formulario (como clientes, tipos de servicio, etc.)
        // $clientes = $this->clienteModel->readAll();
        // $tipo_servicio = $this->servicioModel->getTipos();
        
        // 3. Cargar la vista y pasarle las variables
        // La vista 'crear_informe.php' ahora tendrá acceso a la variable $departamentos.
        require __DIR__ . '/../../views/reportes/crear_informe.php';
    }

    public function procesarYGuardarReporte() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['rol']) || $_SESSION['rol'] != 2) {
            die("Acceso no autorizado.");
        }

        $this->conn->beginTransaction();
        try {
            $ubicacionId = $this->ubicacionModel->crear($_POST);
            $tecnicoId = $this->tecnicoModel->obtenerPorUsuario($_SESSION['ID_usuario']) ?? $this->tecnicoModel->crearTecnico($_SESSION['ID_usuario']);
            
            $servicioData = ['id_cliente' => $_POST['cliente_id'], 'id_tecnico' => $tecnicoId, 'id_ubicacion' => $ubicacionId, 'ser_tipo_servicio' => 'Mantenimiento', 'fecha_servicio' => date('Y-m-d H:i:s')];
            $servicioId = $this->servicioModel->crear($servicioData);

            $_POST['id_servicio'] = $servicioId; // Añadir id_servicio para el modelo de inspección
            $this->inspeccionGeneralModel->crear($_POST);
            
            $informeData = ['id_servicio' => $servicioId, 'info_contenido' => $_POST['observaciones'], 'info_ruta_pdf' => 'generado_en_vivo'];
            $this->informeModel->crear($informeData);

            $this->conn->commit();
            header('Location: ?url=ver_pdf&id=' . $servicioId);
            exit();
        } catch (\Exception $e) {
            $this->conn->rollBack();
            error_log("Error al procesar reporte: " . $e->getMessage());
            die("Hubo un error crítico al guardar el reporte. Detalles: " . $e->getMessage());
        }
    }

    public function mostrarPdfDeServicio() {
        if (!isset($_GET['id'])) die("ID de servicio no especificado.");
        $servicioId = (int)$_GET['id'];
        
        $servicio = $this->servicioModel->obtenerPorId($servicioId);
        if (!$servicio) die("Servicio no encontrado.");
        
        $cliente = $this->clienteModel->getClienteById($servicio['id_cliente']);
        $ubicacion = $this->ubicacionModel->readOne($servicio['id_ubicacion']);
        $inspeccion = $this->inspeccionGeneralModel->obtenerPorServicioId($servicioId);
        $informe = $this->informeModel->obtenerPorServicioId($servicioId);
        $tecnico = $this->tecnicoModel->obtenerInfoCompleta($servicio['id_tecnico']);

        $datosParaPdf = array_merge($servicio, $cliente, $ubicacion, $inspeccion, ['observaciones' => $informe['info_contenido'] ?? ''], ['tecnico_nombre' => $tecnico['usu_nombre'] ?? 'N/A'], ['fecha_generacion' => date('d/m/Y')]);
        
        $this->generarPDF($datosParaPdf);
    }

    private function generarPDF(array $datos) {
      //  extract($datos, EXTR_SKIP);
      //  ob_start();
      //   CORRECCIÓN: Asegúrate que esta ruta a la plantilla es correcta.
      //  require __DIR__ . '/../../views/plantilla_pdf.php';
      //  $html = ob_get_clean();
      //  $mpdf = new \Mpdf\Mpdf(['MODE'=> 'UTF8', 'format' => A4-P]);

      //  $mpdf->writeHTML($html);
      //  $nombreArchivo = "reporte_servicio_" .($datos['id_servicio'] ?? time()). ".pdf";
      //  $mpdf->Output($nombreArchivo, 'I');

       // $options = new Options();
      //  $options->set('isHtml5ParserEnabled', true);
       // $options->set('isRemoteEnabled', true);
       // $dompdf = new Dompdf($options);
      //  $dompdf->loadHtml($html);
      //  $dompdf->setPaper('A4', 'portrait');
      //  $dompdf->render();
      //  $nombreArchivo = "reporte_servicio_" . ($datos['id_servicio'] ?? time()) . ".pdf";
      //  $dompdf->stream($nombreArchivo, ["Attachment" => false]);
      //  exit();
    }
}
?>