<?php
// Medida de Seguridad
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header('Location: /softGenn/public/index.php?action=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Clientes</h1>
            <a href="/softGenn/public/index.php?action=mostrar_crear_cliente" class="btn btn-primary">
                <i class="bi bi-plus-circle-fill me-2"></i>Crear Nuevo Cliente
            </a>
        </div>

        <!-- Mensajes de alerta para el usuario -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'creado'): ?>
            <div class="alert alert-success">Cliente creado exitosamente.</div>
        <?php endif; ?>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'editado'): ?>
            <div class="alert alert-success">Cliente actualizado exitosamente.</div>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'eliminar_fallido'): ?>
            <div class="alert alert-danger">No se puede eliminar el cliente porque tiene informes de servicio asociados.</div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="/softGenn/public/index.php" method="get" class="mb-4">
                    <input type="hidden" name="action" value="gestionar_clientes">
                    <div class="input-group">
                        <input type="text" name="busqueda" class="form-control" placeholder="Buscar por razón social, NIT o contacto..." value="<?php echo htmlspecialchars($busqueda ?? ''); ?>">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Razón Social</th>
                                <th>NIT</th>
                                <th>Contacto</th>
                                <th>Dirección</th>
                                <th>Contacto telefono</th>
                                <th>Contacto Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if (empty($clientes)): ?>
                                <tr><td colspan="6" class="text-center">No se encontraron clientes.</td></tr>
                            <?php else: ?>
                                <?php foreach ($clientes as $cliente): ?>
                                        <tr>
                                        <!-- **CORRECCIÓN 2: Uso del operador ?? '' para evitar valores null** -->
                                        <td><?php echo htmlspecialchars($cliente['razon_social'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['cli_nit'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['contacto_nombre'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['direccion'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['contacto_telefono'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['contacto_correo'] ?? ''); ?></td>
                                        <td>
                                            <a href="/softGenn/public/index.php?action=mostrar_editar_cliente&id=<?php echo $cliente['id_cliente']; ?>" class="btn btn-sm btn-warning" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="/softGenn/public/index.php?action=eliminar_cliente&id=<?php echo $cliente['id_cliente']; ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro? Esta acción no se puede deshacer.');"><i class="bi bi-trash-fill"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?php echo ($pagina == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="/softGenn/public/index.php?action=gestionar_clientes&pagina=<?php echo $i; ?>&busqueda=<?php echo urlencode($busqueda ?? ''); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </main>
</div>
</body>
</html>
