<?php
// app/models/UsuarioModel.php
namespace App\Models;

use PDO;

class UsuarioModel {
    private $db;
    private $usuarioModel;

    public function __construct(PDO $db) {
       // $this->db = getDbConnection();
        $this->db = $db;
    }

    // --- Métodos de Lectura (Read) ---

    public function buscarPorCorreo($correo) {
        $sql = "SELECT u.*, r.rol_nombre FROM usuario u JOIN rol r ON u.id_rol = r.id_rol WHERE u.usu_correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una lista de usuarios con paginación y búsqueda.
     * CORREGIDO: Ahora usa solo marcadores de posición '?' para compatibilidad con PDO.
     */
    public function obtenerTodosPaginado($pagina, $porPagina, $busqueda = '') {
        $offset = ($pagina - 1) * $porPagina;
        $sqlBusqueda = '';
        $params = [];
        $paramIndex = 1;

        if (!empty($busqueda)) {
            $sqlBusqueda = "WHERE u.usu_nombre LIKE ? OR u.usu_apellido LIKE ? OR u.usu_correo LIKE ?";
            $params = ["%$busqueda%", "%$busqueda%", "%$busqueda%"];
        }

        $sql = "SELECT u.*, r.rol_nombre 
                FROM usuario u 
                JOIN rol r ON u.id_rol = r.id_rol 
                $sqlBusqueda
                ORDER BY u.id_usuario DESC 
                LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($sql);

        // Vincular los parámetros de búsqueda (si existen)
        foreach ($params as $value) {
            $stmt->bindValue($paramIndex++, $value);
        }

        // Vincular los parámetros de paginación (LIMIT y OFFSET) como enteros
        $stmt->bindValue($paramIndex++, $porPagina, PDO::PARAM_INT);
        $stmt->bindValue($paramIndex, $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cuenta el total de usuarios para la paginación, opcionalmente con un filtro de búsqueda.
     */
    public function contarTodos($busqueda = '') {
        $sqlBusqueda = '';
        $params = [];
        if (!empty($busqueda)) {
            $sqlBusqueda = "WHERE usu_nombre LIKE ? OR usu_apellido LIKE ? OR usu_correo LIKE ?";
            $params = ["%$busqueda%", "%$busqueda%", "%$busqueda%"];
        }
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuario $sqlBusqueda");
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    // --- Método de Creación (Create) ---

    public function crearUsuario($datos) {
        $contrasenaHasheada = password_hash($datos['usu_contrasena'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (id_rol, usu_nombre, usu_apellido, usu_doc_identidad, usu_telefono, usu_correo, usu_contrasena) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$datos['id_rol'], $datos['usu_nombre'], $datos['usu_apellido'], $datos['usu_doc_identidad'], $datos['usu_telefono'], $datos['usu_correo'], $contrasenaHasheada]);
    }

    // --- Método de Actualización (Update) ---

    public function actualizarUsuario($id, $datos) {
        $sql = "UPDATE usuario SET id_rol = ?, usu_nombre = ?, usu_apellido = ?, usu_doc_identidad = ?, usu_telefono = ?, usu_correo = ? WHERE id_usuario = ?";
        $params = [$datos['id_rol'], $datos['usu_nombre'], $datos['usu_apellido'], $datos['usu_doc_identidad'], $datos['usu_telefono'], $datos['usu_correo'], $id];

        if (!empty($datos['usu_contrasena'])) {
            $sql = "UPDATE usuario SET id_rol = ?, usu_nombre = ?, usu_apellido = ?, usu_doc_identidad = ?, usu_telefono = ?, usu_correo = ?, usu_contrasena = ? WHERE id_usuario = ?";
            $contrasenaHasheada = password_hash($datos['usu_contrasena'], PASSWORD_DEFAULT);
            $params = [$datos['id_rol'], $datos['usu_nombre'], $datos['usu_apellido'], $datos['usu_doc_identidad'], $datos['usu_telefono'], $datos['usu_correo'], $contrasenaHasheada, $id];
        }
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // --- Método de Eliminación (Delete) ---

    public function eliminarUsuario($id) {
        $stmtTecnico = $this->db->prepare("DELETE FROM tecnico WHERE id_usuario = ?");
        $stmtTecnico->execute([$id]);

        $stmtUsuario = $this->db->prepare("DELETE FROM usuario WHERE id_usuario = ?");
        return $stmtUsuario->execute([$id]);
    }
    // --- Método para verificar contraseña ---

            public function guardarTokenReset($email, $token) {
        // MUY IMPORTANTE: Guardamos un HASH del token, no el token en texto plano.
        $tokenHash = password_hash($token, PASSWORD_DEFAULT);
        $expiraEn = date('Y-m-d H:i:s', strtotime('+1 hour')); // El token es válido por 1 hora.

        $sql = "INSERT INTO password_resets (usu_correo, token, expires_at) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$email, $tokenHash, $expiraEn]);
    }

    /**
     * Busca un token válido en la base de datos.
     * @param string $token El token que el usuario proporciona.
     * @return array|false Los datos del token si es válido, o false si no.
     */
    public function buscarTokenValido($token) {
        $todosLosTokens = $this->db->query("SELECT * FROM password_resets WHERE expires_at > NOW()")->fetchAll();
        
        foreach ($todosLosTokens as $tokenData) {
            // Comparamos el token del usuario con el hash guardado en la BD.
            if (password_verify($token, $tokenData['token'])) {
                return $tokenData;
            }
        }
        return false;
    }

    /**
     * Actualiza la contraseña de un usuario.
     * @param string $email El correo del usuario.
     * @param string $nuevaContrasena La nueva contraseña sin hashear.
     * @return bool
     */
    public function actualizarContrasena($email, $nuevaContrasena) {
        $contrasenaHasheada = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET usu_contrasena = ? WHERE usu_correo = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$contrasenaHasheada, $email]);
    }

    /**
     * Elimina un token de la base de datos una vez que ha sido usado.
     * @param string $email El correo asociado al token.
     * @return bool
     */
    public function eliminarToken($email) {
        $sql = "DELETE FROM password_resets WHERE usu_correo = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$email]);
    }
}
