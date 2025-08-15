<?php
// ===== models/Cliente.php =====
namespace App\Models;
use PDO;

class Cliente {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }
    
    public function getClientes() {
        $query = "SELECT c.id_cliente, c.razon_social AS razon_social
                FROM cliente c
                /*JOIN usuario u ON c.id_usuario = u.id_usuario*/
                ORDER BY c.razon_social ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClienteById(int $id) {
        $query = "SELECT c.*, u.usu_nombre AS razon_social, u.usu_apellido, u.usu_correo
                FROM cliente c
                JOIN usuario u ON c.id_usuario = u.id_usuario
                WHERE c.id_cliente = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtiene una lista de todos los clientes.
     */ public function obtenerTodos() {
        $stmt = $this->db->query("SELECT id_cliente, razon_social, cli_nit FROM cliente ORDER BY razon_social ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Obtiene una lista de todos los clientes con paginación y búsqueda.
     */
    public function obtenerTodosPaginado($pagina, $porPagina, $busqueda = '') {
        $offset = ($pagina - 1) * $porPagina;
        $sqlBusqueda = '';
        $params = [];

        if (!empty($busqueda)) {
            $sqlBusqueda = "WHERE c.razon_social LIKE ? OR c.nit LIKE ? OR c.contacto_nombre LIKE ?";
            $searchTerm = "%$busqueda%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }

        $sql = "SELECT c.*, u.ubi_sitio AS direccion 
                FROM cliente c
                LEFT JOIN ubicacion u ON c.id_ubicacion = u.id_ubicacion
                $sqlBusqueda
                ORDER BY c.razon_social ASC 
                LIMIT " . (int)$porPagina . " OFFSET " . (int)$offset;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cuenta el total de clientes para la paginación.
     */
    public function contarTodos($busqueda = '') {
        $sqlBusqueda = '';
        $params = [];
        if (!empty($busqueda)) {
            $sqlBusqueda = "WHERE razon_social LIKE ? OR cli_nit LIKE ? OR contacto_nombre LIKE ?";
            $searchTerm = "%$busqueda%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }

        $sql = "SELECT COUNT(*) FROM cliente $sqlBusqueda";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    /**
     * Obtiene los datos de un único cliente por su ID.
     */
    public function obtenerPorId($id) {
        $sql = "SELECT c.*, u.ubi_sitio AS direccion 
                FROM cliente c
                LEFT JOIN ubicacion u ON c.id_ubicacion = u.id_ubicacion
                WHERE c.id_cliente = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo cliente y su ubicación asociada dentro de una transacción.
     */
    public function crear($datos) {
    try {
        $this->db->beginTransaction();

        // 1. Crear ubicación
        $stmtUbicacion = $this->db->prepare("INSERT INTO ubicacion (ubi_sitio) VALUES (?)");
        $stmtUbicacion->execute([$datos['direccion']]);
        $ubicacionId = $this->db->lastInsertId(); // <-- Corregido, no array

        // 2. Crear cliente
        $stmtCliente = $this->db->prepare(
            "INSERT INTO cliente (razon_social, cli_nit, id_ubicacion, contacto_nombre, contacto_correo, contacto_telefono) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmtCliente->execute([
            $datos['razon_social'] ?? null,
            $datos['cli_nit'] ?? null,
            $ubicacionId,
            $datos['contacto_nombre'] ?? null,
            $datos['contacto_correo'] ?? null,
            $datos['contacto_telefono'] ?? null
        ]);

        $this->db->commit();
        return true;
    } catch (\Exception $e) {
        $this->db->rollBack();
        error_log("Error al crear cliente: " . $e->getMessage());
        return false;
    }
}

    /**
     * Actualiza un cliente y su ubicación dentro de una transacción.
     */
public function actualizar($id, $datos) {
    try {
        $this->db->beginTransaction();

        // 1. Obtener la ubicación actual del cliente para actualizarla
        $clienteActual = $this->obtenerPorId($id);
        if ($clienteActual && $clienteActual['id_ubicacion']) {
            $stmtUbicacion = $this->db->prepare(
                "UPDATE ubicacion SET ubi_sitio = ? WHERE id_ubicacion = ?"
            );
            $stmtUbicacion->execute([
                $datos['direccion'],
                $clienteActual['id_ubicacion']
            ]);
        }

        // 2. Actualizar los datos del cliente (sin correo porque no existe en la tabla)
        $stmtCliente = $this->db->prepare(
            "UPDATE cliente 
             SET razon_social = ?, cli_nit = ?, contacto_telefono = ?, contacto_nombre = ?
             WHERE id_cliente = ?"
        );

        $stmtCliente->execute([
            $datos['razon_social'],
            $datos['cli_nit'],
            $datos['contacto_telefono'],
            $datos['contacto_nombre'],
            $id
        ]);

        $this->db->commit();
        return true;

    } catch (Exception $e) {
        $this->db->rollBack();
        error_log("Error al actualizar cliente: " . $e->getMessage());
        return false;
    }
}

    /**
     * Elimina un cliente.
     * Nota: La base de datos impedirá eliminar un cliente si tiene informes asociados.
     * Esto es una medida de seguridad para mantener la integridad de los datos.
     */
    public function eliminar($id) {
        try {
            // No necesitamos una transacción compleja aquí porque las restricciones
            // de la base de datos (foreign keys) se encargarán de la seguridad.
            $stmt = $this->db->prepare("DELETE FROM cliente WHERE id_cliente = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Capturar el error de restricción de clave foránea
            error_log("Error al eliminar cliente: " . $e->getMessage());
            return false;
        }
    }
}
?>