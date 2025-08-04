<?php
// app/models/DashboardModel.php
namespace App\Models;
use PDO;
class DashboardModel {
    private $db;

    public function __construct() {
        $this->db = getDbConnection();
    }

    /**
     * Obtiene un conjunto completo de estadísticas para el panel de administración.
     * @return array Un array con todas las métricas.
     */
    public function getAdminStatistics() {
        $stats = [];

        // Contadores para las tarjetas de estadísticas
        $stats['total_informes'] = $this->db->query("SELECT COUNT(*) FROM servicio")->fetchColumn();
        $stats['total_tecnicos'] = $this->db->query("SELECT COUNT(*) FROM tecnico")->fetchColumn();
        $stats['total_clientes'] = $this->db->query("SELECT COUNT(*) FROM cliente")->fetchColumn();
        
        $stmtPendientes = $this->db->prepare("SELECT COUNT(*) FROM servicio WHERE ser_estado = ?");
        $stmtPendientes->execute(['Pendiente']);
        $stats['informes_pendientes'] = $stmtPendientes->fetchColumn();
        
        // --- NUEVO: DATOS PARA GRÁFICOS ---

        // Contar informes por tipo de servicio
        $stmtTipos = $this->db->query("
            SELECT ser_tipo_servicio, COUNT(*) as total
            FROM servicio
            WHERE ser_tipo_servicio IS NOT NULL AND ser_tipo_servicio != ''
            GROUP BY ser_tipo_servicio
        ");
        // fetchAll con FETCH_KEY_PAIR crea un array asociativo: ['Tipo' => 'Total']
        $stats['informes_por_tipo'] = $stmtTipos->fetchAll(PDO::FETCH_KEY_PAIR);

        // Contar informes por estado
        $stmtEstados = $this->db->query("
            SELECT ser_estado, COUNT(*) as total
            FROM servicio
            GROUP BY ser_estado
        ");
        $stats['informes_por_estado'] = $stmtEstados->fetchAll(PDO::FETCH_KEY_PAIR);

        return $stats;
    }

    /**
     * Obtiene los últimos servicios registrados para el feed de actividad.
     * @param int $limit El número de actividades a obtener.
     * @return array Una lista de las actividades recientes.
     */
    public function getRecentActivity($limit = 5) {
        $sql = "SELECT 
                    s.id_servicio,
                    s.ser_fecha,
                    s.ser_estado, -- Añadido para mostrar el estado en la tabla
                    c.razon_social AS nombre_cliente,
                    u.usu_nombre,
                    u.usu_apellido
                FROM servicio s
                LEFT JOIN cliente c ON s.id_cliente = c.id_cliente
                LEFT JOIN tecnico t ON s.id_tecnico = t.id_tecnico
                LEFT JOIN usuario u ON t.id_usuario = u.id_usuario
                ORDER BY s.ser_fecha DESC, s.id_servicio DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getTechnicianStatistics($id_usuario) {
        $stats = [];
        
        // Primero, encontramos el id_tecnico correspondiente al id_usuario
        $stmtTecnicoId = $this->db->prepare("SELECT id_tecnico FROM tecnico WHERE id_usuario = ?");
        $stmtTecnicoId->execute([$id_usuario]);
        $id_tecnico = $stmtTecnicoId->fetchColumn();

        if (!$id_tecnico) {
            return ['total_informes' => 0, 'informes_pendientes' => 0];
        }

        // Contar informes totales del técnico
        $stmtTotal = $this->db->prepare("SELECT COUNT(*) FROM servicio WHERE id_tecnico = ?");
        $stmtTotal->execute([$id_tecnico]);
        $stats['total_informes'] = $stmtTotal->fetchColumn();

        // Contar informes pendientes del técnico
        $stmtPendientes = $this->db->prepare("SELECT COUNT(*) FROM servicio WHERE id_tecnico = ? AND ser_estado = 'Pendiente'");
        $stmtPendientes->execute([$id_tecnico]);
        $stats['informes_pendientes'] = $stmtPendientes->fetchColumn();

        return $stats;
    }

    /**
     * Obtiene los últimos informes de un técnico específico.
     * @param int $id_usuario El ID del usuario (técnico) logueado.
     * @param int $limit El número de informes a obtener.
     * @return array Una lista de los informes recientes del técnico.
     */
    public function getRecentActivityForTechnician($id_usuario, $limit = 5) {
        $stmtTecnicoId = $this->db->prepare("SELECT id_tecnico FROM tecnico WHERE id_usuario = ?");
        $stmtTecnicoId->execute([$id_usuario]);
        $id_tecnico = $stmtTecnicoId->fetchColumn();

        if (!$id_tecnico) {
            return [];
        }

        $sql = "SELECT 
                    s.id_servicio,
                    s.ser_fecha,
                    s.ser_estado,
                    c.razon_social AS nombre_cliente
                FROM servicio s
                LEFT JOIN cliente c ON s.id_cliente = c.id_cliente
                WHERE s.id_tecnico = ?
                ORDER BY s.ser_fecha DESC, s.id_servicio DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_tecnico, $limit]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
