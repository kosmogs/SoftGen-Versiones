<?php
// app/controllers/DashboardController.php
namespace App\Controllers;

use App\Models\DashboardModel;

require_once __DIR__.'/../models/DashboardModel.php';
class DashboardController {

    private $dashboardModel;

    public function __construct() {
    $this->dashboardModel = new DashboardModel();
    }

    public function showAdminDashboard() {
        // Medida de seguridad
        if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
            header('Location: /softGenn/public/index.php?action=login&error=' . urlencode('Acceso denegado.'));
            exit();
        }

        // Instanciamos el modelo
        $dashboardModel = new DashboardModel();
        
        // Obtenemos TODOS los datos necesarios con una sola llamada al modelo
        $estadisticas = $dashboardModel->getAdminStatistics();
        $actividadReciente = $dashboardModel->getRecentActivity();

        // Pasamos los datos a la vista. La vista tendrá acceso a las variables
        // $estadisticas y $actividadReciente.
        require_once '../app/views/dashboard/admin_dashboard.php';
    }

    public function showTecnicoDashboard() {
        // Medida de seguridad
        if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 2) {
            header('Location: /softGenn/public/index.php?action=login&error=' . urlencode('Acceso denegado.'));
            exit();
        }

        // Obtenemos los datos específicos del técnico desde el modelo
        $estadisticas = $this->dashboardModel->getTechnicianStatistics($_SESSION['id_usuario']);
        $actividadReciente = $this->dashboardModel->getRecentActivityForTechnician($_SESSION['id_usuario']);

        // Pasamos los datos a la vista del técnico
        require_once '../app/views/dashboard/tecnico_dashboard.php';
    }

    
}
