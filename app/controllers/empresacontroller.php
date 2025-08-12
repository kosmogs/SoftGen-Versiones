<?php
namespace App\Controllers;

// Importamos el modelo y la clase PDO para usarlos en este archivo.
use App\Models\EmpresaModel;
use PDO;

/**
 * Controlador para gestionar las interacciones relacionadas con las empresas.
 */
class EmpresaController {
    
    /**
     * @var EmpresaModel Instancia del modelo de empresa.
     */
    private $empresaModel;

    /**
     * Constructor del controlador.
     * Se encarga de crear una instancia del modelo.
     * * @param PDO $db Conexión a la base de datos.
     */
    public function __construct(PDO $db) {
        // Creamos una nueva instancia de EmpresaModel, pasándole la conexión a la BD.
        $this->empresaModel = new EmpresaModel($db);
    }

    /**
     * Acción para listar todas las empresas.
     * Obtiene los datos del modelo y los pasa a una vista para ser mostrados.
     */
    public function listar() {
        try {
            // 1. Obtener todas las empresas llamando al método del modelo.
            $empresas = $this->empresaModel->obtenerEmpresa();

            // 2. Cargar la vista.
            // La vista se encargará de renderizar los datos en HTML.
            // La variable $empresas estará disponible dentro del archivo de la vista.
            // En un framework real, esto se manejaría con un motor de plantillas (ej. Twig).
            // Para este ejemplo, simplemente incluimos el archivo PHP.
            require_once __DIR__ . '/../Views/empresas/lista.php';

        } catch (\Exception $e) {
            // Manejo básico de errores
            error_log($e->getMessage());
            echo "<h1>Error al cargar los datos de las empresas.</h1>";
        }
    }
}