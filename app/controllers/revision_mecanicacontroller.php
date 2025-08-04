<?php
// ===== app/controllers/RevisionMecanicaController.php =====

namespace App\Controllers;

// Asegúrate de que las rutas sean correctas
require_once __DIR__.'/../models/RevisionMecanica.php';

use App\Models\RevisionMecanica;
use PDO;

// El nombre de la clase del controlador suele terminar en 'Controller'
class RevisionMecanicaController {
    private $revisionMecanicaModel; // Propiedad para guardar el objeto del modelo

    public function __construct(PDO $db){
        // Al crear el controlador, se instancia el modelo
        $this->revisionMecanicaModel = new RevisionMecanica($db);
    }

    /**
     * Muestra el formulario para crear una nueva revisión.
     */
    public function mostrarFormulario() {
        // Simplemente carga el archivo de la vista que contiene el HTML del formulario.
        // La ruta puede variar según la estructura de tu proyecto.
        require __DIR__ . '/../views/revision/formulario_revision.php';
    }

    /**
     * Procesa los datos enviados desde el formulario y los guarda.
     */
    public function guardarRevision() {
        // 1. Verifica que los datos se envíen por POST para seguridad
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Acceso no permitido.";
            return;
        }

        // 2. Llama al método 'crear' del modelo, pasándole todos los datos del formulario
        $nuevoId = $this->revisionMecanicaModel->crear($_POST);

        // 3. Comprueba el resultado y redirige al usuario
        if ($nuevoId) {
            // Si se guardó correctamente, puedes redirigir a una página de éxito
            echo "¡Revisión mecánica guardada con éxito con el ID: " . $nuevoId . "!";
            // header('Location: ?action=revision_exitosa');
        } else {
            // Si hubo un error, muestra un mensaje
            echo "Error al guardar la revisión mecánica.";
        }
    }
}