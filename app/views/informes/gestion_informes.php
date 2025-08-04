<?php
// Medida de Seguridad
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header('Location: /softGenn/public/index.php?action=login&error=' . urlencode('Acceso denegado.'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Informes - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Informes de Servicio</h1>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="/softGenn/public/index.php" method="get" class="mb-4">
                    <input type="hidden" name="action" value="gestionar_informes">
                    <div class="input-group">
                        <input type="text" name="busqueda" class="form-control" placeholder="Buscar por cliente o técnico..." value="<?php echo htmlspecialchars($busqueda ?? ''); ?>">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Buscar</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th># Informe</th><th>Fecha</th><th>Cliente</th><th>Técnico</th><th>Tipo Servicio</th><th>Estado</th><th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($informes)): ?>
                                <tr><td colspan="7" class="text-center">No se encontraron informes.</td></tr>
                            <?php else: ?>
                                <?php foreach ($informes as $informe): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($informe['id_servicio']); ?></strong></td>
                                        <td><?php echo date('d/m/Y', strtotime($informe['ser_fecha'])); ?></td>
                                        <td><?php echo htmlspecialchars($informe['nombre_cliente'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($informe['nombre_tecnico'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($informe['ser_tipo_servicio']); ?></td>
                                        <td>
                                            <?php 
                                                $estado = htmlspecialchars($informe['ser_estado'] ?? 'Pendiente');
                                                $badge_class = 'bg-secondary';
                                                if ($estado == 'Firmado') $badge_class = 'bg-success';
                                                if ($estado == 'Rechazado') $badge_class = 'bg-danger';
                                                if ($estado == 'Pendiente') $badge_class = 'bg-warning text-dark';
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>"><?php echo $estado; ?></span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info" title="Ver Detalles"><i class="bi bi-eye-fill"></i></a>
                                            <a href="/softGenn/public/index.php?action=generar_pdf&id=<?php echo $informe['id_servicio']; ?>" class="btn btn-sm btn-danger" title="Descargar PDF"><i class="bi bi-file-earmark-pdf-fill"></i></a>
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
                                <a class="page-link" href="/softGenn/public/index.php?action=gestionar_informes&pagina=<?php echo $i; ?>&busqueda=<?php echo urlencode($busqueda ?? ''); ?>"><?php echo $i; ?></a>
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