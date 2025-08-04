<?php
// app/controllers/UsuarioController.php


namespace App\Controllers;

require_once __DIR__. '../../models/UsuarioModel.php';
require_once __DIR__. '../../models/Tecnico.php';

use App\Models\Tecnico;
use App\Models\UsuarioModel;
use PDO;

class UsuarioController {
    private $usuarioModel;
    private $db;
    private $conn;

    public function __construct(PDO $db){
        $this->usuarioModel = new UsuarioModel($db);
    }

    /**
     * Muestra la vista de login.
     */
    public function mostrarLogin() {
        // Asumimos que moviste tu archivo login.php a esta nueva ruta.
        require_once '../app/views/usuario/login.php';
    }

    /**
     * Procesa la solicitud de inicio de sesión del formulario.
     */
    public function iniciarSesion() {
        // Es fundamental iniciar la sesión para poder guardar los datos del usuario.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Solo procesamos si los datos vienen por POST.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';

            // Validación simple de que los campos no estén vacíos.
            if (empty($correo) || empty($contrasena)) {
                $this->redireccionarConError('login', 'Por favor, complete todos los campos.');
                return;
            }

            // 1. Pedir al Modelo que busque al usuario.
          
            $usuario = $this->usuarioModel->buscarPorCorreo($correo); 

            // 2. Verificar si el usuario existe Y si la contraseña es correcta.
            // password_verify() es la función de PHP para comparar una contraseña en texto plano
            // con un hash seguro guardado en la base de datos. ¡Es muy importante!
            if ($usuario && password_verify($contrasena, $usuario['usu_contrasena'])) {
                // ¡Login Exitoso!
                // 3. Guardar la información importante en la sesión.
                // Guardar la información importante en la sesión.
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_usuario'] = $usuario['usu_nombre'] . ' ' . $usuario['usu_apellido'];
                $_SESSION['id_rol'] = $usuario['id_rol'];
                $_SESSION['rol_nombre'] = $usuario['rol_nombre'];

                // --- ¡NUEVA LÓGICA DE REDIRECCIÓN! ---
                if ($usuario['id_rol'] == 1) { // 1 = Administrador
                    header('Location: /softGenn/public/index.php?action=dashboard_admin');
                } else if ($usuario['id_rol'] == 2) { // 2 = Tecnico
                    header('Location: /softGenn/public/index.php?action=dashboard_tecnico');
                } else {
                    // Para otros roles o por si acaso
                    header('Location: index.php?action=login&error=' . urlencode('Rol no reconocido.'));
                }
                exit();
            } else {
                // Si el usuario no existe o la contraseña es incorrecta, redirigir con error.
                $this->redireccionarConError('login', 'Correo o contraseña incorrectos.');
            }
        } else {
            // Si alguien intenta acceder a esta acción sin enviar el formulario, lo devolvemos al login.
            header('Location: index.php?action=login');
            exit();
        }
    }


    

    /**
     * Cierra la sesión del usuario.
     */
    public function cerrarSesion() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        session_unset();    // Libera todas las variables de sesión.
        session_destroy();  // Destruye toda la información registrada de una sesión.

        // Redirigir a la página de login con un mensaje de éxito (opcional).
        header('Location: index.php?action=login&status=logout');
        exit();
    }

    /**
     * Función de ayuda para redirigir con un mensaje de error.
     * Esto funciona con el JavaScript que ya tienes en tu login.php.
     */
    private function redireccionarConError($accion, $mensaje) {
        header('Location: index.php?action=' . $accion . '&error=' . urlencode($mensaje));
        exit();
    }


    /**
     * Procesa la creación de un nuevo técnico desde el panel de administrador.
     */
    public function crearTecnico() {
        // --- PASO DE SEGURIDAD ---
        // Verificamos si el usuario logueado es un Administrador (rol 1).
        if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
            $this->redireccionarConError('dashboard', 'Acceso no autorizado.');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Recoger los datos del formulario del panel de admin.
            $datosNuevoUsuario = [
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'correo' => $_POST['correo'],
                'contrasena' => $_POST['contrasena'],
                'doc_identidad' => $_POST['doc_identidad'],
                'telefono' => $_POST['telefono']
            ];
            //Holaa
            // Instanciamos los modelos.
            $usuarioModel = new UsuarioModel();
            $tecnicoModel = new TecnicoModel();

            // 2. Llamar al modelo para crear el registro en la tabla 'usuario'.
            // El rol para un técnico es 2.
            $nuevoUsuarioId = $usuarioModel->crearUsuario($datosNuevoUsuario, 2);

            if ($nuevoUsuarioId) {
                // 3. Si el usuario se creó, ahora creamos el registro en la tabla 'tecnico'.
                // Asumimos que la empresa es la 1, esto se puede hacer dinámico después.
                $tecnicoModel->crearTecnico($nuevoUsuarioId, 1); 

                // 4. Redirigir al panel de admin con un mensaje de éxito.
                header('Location: index.php?action=admin_dashboard&status=tecnico_creado');
                exit();
            } else {
                $this->redireccionarConError('admin_dashboard', 'Error al crear el usuario.');
            }
        }
    } 

        public function gestionarUsuarios() {
        $this->verificarAdmin();
        $pagina = $_GET['pagina'] ?? 1;
        $busqueda = $_GET['busqueda'] ?? '';
        $porPagina = 10;
        
        $usuarios = $this->usuarioModel->obtenerTodosPaginado($pagina, $porPagina, $busqueda);
        $totalUsuarios = $this->usuarioModel->contarTodos($busqueda);
        $totalPaginas = ceil($totalUsuarios / $porPagina);

        require_once '../app/views/usuario/gestion_usuarios.php';
    }

    public function mostrarFormularioCrear() {
        $this->verificarAdmin();
        require_once '../app/views/usuario/crear_usuario.php';
    }

    public function crearUsuario() {
        $this->verificarAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST; // Recolectamos todos los datos del formulario
            $this->usuarioModel->crearUsuario($datos);
            header('Location: /softGenn/public/index.php?action=gestionar_usuarios&status=creado');
            exit();
        }
    }

    public function mostrarFormularioEditar() {
        $this->verificarAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) { die('ID de usuario no especificado.'); }
        
        $usuario = $this->usuarioModel->obtenerPorId($id);
        require_once '../app/views/usuario/editar_usuario.php';
    }

    public function editarUsuario() {
        $this->verificarAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_usuario'];
            $datos = $_POST;
            $this->usuarioModel->actualizarUsuario($id, $datos);
            header('Location: /softGenn/public/index.php?action=gestionar_usuarios&status=editado');
            exit();
        }
    }

    public function eliminarUsuario() {
        $this->verificarAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->usuarioModel->eliminarUsuario($id);
        }
        header('Location: /softGenn/public/index.php?action=gestionar_usuarios&status=eliminado');
        exit();
    }

    private function verificarAdmin() {
        if (session_status() == PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
            header('Location: /softGenn/public/index.php?action=login&error=' . urlencode('Acceso no autorizado.'));
            exit();
        }
    }

    
    
    public function mostrarFormularioSolicitud() {
        require_once '../app/views/usuario/solicitar_reset.php';
    }

    public function procesarSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['correo'];
            $usuario = $this->usuarioModel->buscarPorCorreo($email);

            if ($usuario) {
                // Generar un token seguro
                $token = bin2hex(random_bytes(16));
                
                // Guardar el token en la BD
                $this->usuarioModel->guardarTokenReset($email, $token);

                // Enviar el correo electrónico
                $enlace = "/softGenn/public/index.php?action=mostrar_formulario_reset&token=" . $token;
                $asunto = "Recuperación de Contraseña - SoftGen";
                $cuerpo = "Hola, haz clic en el siguiente enlace para restablecer tu contraseña: " . $enlace;
                
                // --- IMPORTANTE: LÓGICA DE ENVÍO DE CORREO ---
                // La función mail() de PHP puede no funcionar en un entorno local como XAMPP.
                // Se recomienda usar una librería como PHPMailer.
                // mail($email, $asunto, $cuerpo);

                // Por ahora, para pruebas, mostraremos el enlace en pantalla.
                echo "Correo enviado (simulación). <a href='$enlace'>Haz clic aquí para resetear</a>";
            } else {
                // Redirigir con error si el correo no existe
                header('Location: /softGenn/public/index.php?action=solicitar_reset&error=' . urlencode('El correo no está registrado.'));
            }
        }
    }

    public function mostrarFormularioReset() {
        $token = $_GET['token'] ?? '';
        $tokenData = $this->usuarioModel->buscarTokenValido($token);

        if ($tokenData) {
            // El token es válido, mostramos el formulario
            $email = $tokenData['email'];
            require_once '../app/views/usuario/resetear_contrasena.php';
        } else {
            die("Token inválido o expirado.");
        }
    }

    public function procesarReset() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $token = $_POST['token'];
            $nuevaContrasena = $_POST['contrasena'];

            $tokenData = $this->usuarioModel->buscarTokenValido($token);

            if ($tokenData && $tokenData['email'] === $email) {
                // Si el token es válido y corresponde al email, actualizamos la contraseña.
                $this->usuarioModel->actualizarContrasena($email, $nuevaContrasena);
                // Eliminamos el token para que no se pueda volver a usar.
                $this->usuarioModel->eliminarToken($email);
                
                header('Location: /softGenn/public/index.php?action=login&status=reset_exitoso');
            } else {
                die("Error de validación. Inténtalo de nuevo.");
            }
        }
    }
}

