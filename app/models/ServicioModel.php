<?php
// app/models/ServicioModel.php
namespace App\Models;
use PDO;

use function PHPSTORM_META\type;

class ServicioModel {
    private $db;
    private $conn;

    public function __construct(PDO $db) {
        //$this->db = getDbConnection();
        $this->db = $db;
    }

    /**
     * Guarda un informe de servicio completo usando una transacción.
     * Este es el método principal para guardar toda la información del formulario.
     *
     * @param array $datos Los datos del formulario ($_POST).
     * @param array $rutasFotos Un array con las rutas de las fotos guardadas.
     * @return int|false El ID del nuevo servicio creado, o false si la transacción falla.
     */

    public function crear(array $data) {
        $query = "INSERT INTO servicio (id_cliente, id_tecnico, id_ubicacion, ser_tipo_servicio, ser_tipo_informe, ser_observaciones, fecha_servicio, ser_hora_entrada, ser_hora_salida) 
                  VALUES (:id_cliente, :id_tecnico, :id_ubicacion, :ser_tipo_servicio, :ser_tipo_informe, :ser_observaciones, :fecha_servicio, :ser_hora_entrada, :ser_hora_salida)";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":id_cliente", $data['id_cliente'], PDO::PARAM_INT);
        $stmt->bindValue(":id_tecnico", $data['id_tecnico'], PDO::PARAM_INT);
        $stmt->bindValue(":id_ubicacion", $data['id_ubicacion'], PDO::PARAM_INT);
        $stmt->bindValue(":ser_tipo_servicio", $data['ser_tipo_servicio']);
        $stmt->bindValue(":ser_tipo_informe", $data['ser_tipo_informe']);
        $stmt->bindValue(":ser_observaciones", $data['ser_observaciones']);
        $stmt->bindValue(":ser_hora_entrada", $data['ser_hora_entrada']);
        $stmt->bindValue(":ser_hora_salida", $data['ser_hora_salida']);
        $stmt->bindValue(":fecha_servicio", $data['fecha_servicio']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }return false;
    }  
    public function obtenerPorId(int $id): ?array {
        $query = "SELECT * FROM servicio WHERE id_servicio = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function mostrarTipoServicio(): array{
        $query = "SHOW COLUMNS from servicio WHERE Field = 'ser_tipo_servicio'";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row){
            $enumList = str_replace("'", "", substr($row['Type'], 5, -1));
            return explode( ',', $enumList);
        }
        return [];
    }

    public function mostrarTipoInforme(): array{
        $query = "SHOw COLUMNS from servicio WHERE Field = 'ser_tipo_informe'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            $enumList = str_replace("'", "", substr($row['Type'], 5, -1 ));
            return explode(',', $enumList);
        }
        return[];
    }
    public function guardarInformeCompleto($datos, $rutasFotos) {
        try {
            // 1. Iniciar la transacción para asegurar la integridad de los datos.
            $this->db->beginTransaction();

            // 2. Crear la ubicación del servicio.
            $stmtUbicacion = $this->db->prepare("INSERT INTO ubicacion (ubi_sitio) VALUES (?)");
            $stmtUbicacion->execute([$datos['cliente']['direccion'] ?? 'N/A']);
            $ubicacionId = $this->db->lastInsertId();

            // 3. Crear el cliente, vinculándolo a la ubicación recién creada.
            $cliente = $datos['cliente'];
            $stmtCliente = $this->db->prepare("INSERT INTO cliente (razon_social, nit, correo, telefono, id_ubicacion, contacto_nombre) VALUES (?, ?, ?, ?, ?, ?)");
            $stmtCliente->execute([
                $cliente['razon_social'], $cliente['nit'], $cliente['correo'],
                $cliente['contacto_telefono'], $ubicacionId, $cliente['contacto_nombre']
            ]);
            $clienteId = $this->db->lastInsertId();

            // 4. Crear el registro de inspección general (checklist).
            $inspeccion = $datos['inspeccion_general'] ?? [];
            $stmtInspeccion = $this->db->prepare(
                "INSERT INTO inspeccion_general (ig_amperios, ig_voltaje, ig_temp_suministro, ig_temp_retorno, ig_goteos, ig_gabinete, ig_filtro, ig_drenaje, ig_serpentin, ig_vibracion, ig_tablero_electrico, ig_aislamiento_gabinete, ig_flujo_aire) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmtInspeccion->execute([
                $inspeccion['ig_amperios'] ?? null, $inspeccion['ig_voltaje'] ?? null,
                $inspeccion['ig_temp_suministro'] ?? null, $inspeccion['ig_temp_retorno'] ?? null,
                isset($inspeccion['goteos']) ? 1 : 0, isset($inspeccion['gabinete']) ? 1 : 0,
                isset($inspeccion['filtro']) ? 1 : 0, isset($inspeccion['drenaje']) ? 1 : 0,
                isset($inspeccion['serpentin']) ? 1 : 0, isset($inspeccion['vibracion']) ? 1 : 0,
                isset($inspeccion['tablero_electrico']) ? 1 : 0, isset($inspeccion['aislamiento_gabinete']) ? 1 : 0,
                isset($inspeccion['flujo_aire']) ? 1 : 0
            ]);
            $inspeccionId = $this->db->lastInsertId();

            // 5. Obtener ID del técnico a partir del usuario de la sesión.
            $stmtTecnicoId = $this->db->prepare("SELECT id_tecnico FROM tecnico WHERE id_usuario = ?");
            $stmtTecnicoId->execute([$_SESSION['id_usuario']]);
            $tecnicoId = $stmtTecnicoId->fetchColumn();
            if (!$tecnicoId) { 
                throw new Exception("El usuario actual no es un técnico registrado en la tabla 'tecnico'."); 
            }

            // 6. Crear el registro principal del servicio.
            // Se combinan fecha y hora para el formato DATETIME de la BD.
            $hora_entrada = $datos['ser_fecha'] . ' ' . $datos['ser_hora_entrada'];
            $hora_salida = $datos['ser_fecha'] . ' ' . $datos['ser_hora_salida'];
            $stmtServicio = $this->db->prepare(
                "INSERT INTO servicio (id_cliente, id_tecnico, id_ubicacion, id_inspeccion_general, tipo_informe, ser_tipo_servicio, ser_observaciones, ser_estado, ser_firma_cliente, ser_firma_tecnico, ser_fecha, ser_hora_entrada, ser_hora_salida) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, 'Pendiente', ?, ?, ?, ?, ?)"
            );
            $stmtServicio->execute([
                $clienteId, $tecnicoId, $ubicacionId, $inspeccionId,
                $datos['tipo_informe'], $datos['ser_tipo_servicio'],
                $datos['ser_observaciones'], $datos['ser_firma_tecnico'],
                $datos['ser_firma_cliente'], $datos['ser_fecha'],
                $hora_entrada, $hora_salida
            ]);
            $servicioId = $this->db->lastInsertId();

            // 7. Guardar los equipos y vincularlos al servicio.
            if (!empty($datos['equipos']) && is_array($datos['equipos'])) {
                $stmtEquipo = $this->db->prepare("INSERT INTO equipo (equi_tipo_equipo, equi_marca, equi_modelo, equi_serie, equi_ubicacion, equi_cantidad) VALUES (?, ?, ?, ?, ?, 1)");
                $stmtVinculo = $this->db->prepare("INSERT INTO servicio_equipo (id_servicio, id_equipo) VALUES (?, ?)");
                foreach ($datos['equipos'] as $equipo) {
                    $stmtEquipo->execute([$equipo['equi_tipo_equipo'], $equipo['equi_marca'], $equipo['equi_modelo'], $equipo['equi_serie'], $equipo['equi_ubicacion']]);
                    $equipoId = $this->db->lastInsertId();
                    $stmtVinculo->execute([$servicioId, $equipoId]);
                }
            }
        
            // 8. Guardar las rutas de las fotos.
            if (!empty($rutasFotos)) {
                $stmtFoto = $this->db->prepare("INSERT INTO foto_servicio (id_servicio, ruta_foto, descripcion) VALUES (?, ?, ?)");
                foreach ($rutasFotos as $foto) {
                    $stmtFoto->execute([$servicioId, $foto['ruta'], $foto['descripcion']]);
                }
            }
            // 9. Si todo salió bien, confirmar todos los cambios en la base de datos.
            $this->db->commit();
            return $servicioId;
        } 
        catch (Exception $e) {
             //10. Si algo falló, revertir todos los cambios.
             $this->db->rollBack();
            // Esto es crucial para la depuración. El mensaje real del error se guardará en los logs de PHP.
            error_log("Error al guardar informe: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todos los datos necesarios para generar el PDF de un informe.
     */
    public function obtenerInformeCompletoPorId($id) {
        $resultado = [];
        $stmtInforme = $this->db->prepare("SELECT s.*, ub.ubi_sitio as cliente_direccion FROM servicio s LEFT JOIN ubicacion ub ON s.id_ubicacion = ub.id_ubicacion WHERE s.id_servicio = ?");
        $stmtInforme->execute([$id]);
        $resultado['informe'] = $stmtInforme->fetch(PDO::FETCH_ASSOC);
        if (!$resultado['informe']) return false;

        $stmtCliente = $this->db->prepare("SELECT * FROM cliente WHERE id_cliente = ?");
        $stmtCliente->execute([$resultado['informe']['id_cliente']]);
        $resultado['cliente'] = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        $stmtTecnico = $this->db->prepare("SELECT u.* FROM usuario u JOIN tecnico t ON u.id_usuario = t.id_usuario WHERE t.id_tecnico = ?");
        $stmtTecnico->execute([$resultado['informe']['id_tecnico']]);
        $resultado['tecnico'] = $stmtTecnico->fetch(PDO::FETCH_ASSOC);

        $stmtEquipos = $this->db->prepare("SELECT e.* FROM equipo e JOIN servicio_equipo se ON e.id_equipo = se.id_equipo WHERE se.id_servicio = ?");
        $stmtEquipos->execute([$id]);
        $resultado['equipos'] = $stmtEquipos->fetchAll(PDO::FETCH_ASSOC);

        $stmtFotos = $this->db->prepare("SELECT * FROM foto_servicio WHERE id_servicio = ?");
        $stmtFotos->execute([$id]);
        $resultado['fotos'] = $stmtFotos->fetchAll(PDO::FETCH_ASSOC);
        
        // Añadir datos de la inspección general
        $stmtInspeccion = $this->db->prepare("SELECT * FROM inspeccion_general WHERE id_inspeccion_general = ?");
        $stmtInspeccion->execute([$resultado['informe']['id_inspeccion_general']]);
        $resultado['inspeccion'] = $stmtInspeccion->fetch(PDO::FETCH_ASSOC);

        return $resultado;
    }
}