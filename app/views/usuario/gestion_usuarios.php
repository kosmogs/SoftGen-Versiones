<?php
// Medida de Seguridad
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header('Location: index.php?action=login&error=' . urlencode('Acceso denegado.'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_header.php'; // Usamos un header reutilizable ?>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Usuarios y Técnicos</h1>
            <a href="index.php?action=mostrar_crear_usuario" class="btn btn-primary">
                <i class="bi bi-plus-circle-fill me-2"></i>Crear Nuevo Usuario
            </a>
        </div>

        <!-- Formulario de Búsqueda -->
        <form action="index.php" method="get" class="mb-4">
            <input type="hidden" name="action" value="gestionar_usuarios">
            <div class="input-group">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre, apellido o correo..." value="<?php echo htmlspecialchars($busqueda ?? ''); ?>">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Buscar</button>
            </div>
        </form>

        <!-- Tabla de Usuarios -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No se encontraron usuarios.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['usu_nombre'] . ' ' . $usuario['usu_apellido']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['usu_correo']); ?></td>
                                <td><span class="badge bg-info"><?php echo htmlspecialchars($usuario['rol_nombre']); ?></span></td>
                                <td><?php echo htmlspecialchars($usuario['usu_telefono']); ?></td>
                                <td>
                                    <a href="index.php?action=mostrar_editar_usuario&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-warning" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                    <a href="index.php?action=eliminar_usuario&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?php echo ($paginaActual == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?action=gestionar_usuarios&pagina=<?php echo $i; ?>&busqueda=<?php echo htmlspecialchars($busqueda ?? ''); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </main>
</body>
</html>


