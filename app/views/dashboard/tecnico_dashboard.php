<?php
// Medida de Seguridad
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 2) {
    header('Location: /softGenn/public/index.php?action=login&error=' . urlencode('Acceso no autorizado.'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Técnico - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Saira', sans-serif; background-color: #f8f9fa; }
        .stat-card { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075); }
    </style>
</head>
<body>

    <header class="bg-dark text-white shadow-sm">
        <div class="container py-3 d-flex justify-content-between align-items-center">
            <div>
                <a class="navbar-brand" href="#">
                    <img src="/softGenn/public/img/Logo completo.png" alt="Logo SoftGen" height="50">
                </a>
            </div>
            <div class="text-end">
                <span class="d-block">Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></strong></span>
                <a href="/softGenn/public/index.php?action=cerrar_sesion" class="btn btn-sm btn-outline-light mt-1">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div class="row text-center mb-5">
            <div class="col-md-12">
                <h1>Mi Panel de Trabajo</h1>
                <p class="lead">Aquí puedes gestionar tus informes de servicio.</p>
            </div>
        </div>

        <!-- Sección de Acciones y Estadísticas -->
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card text-center h-100 border-primary border-2">
                    <div class="card-body py-4">
                        <i class="bi bi-file-earmark-plus-fill fs-1 text-primary mb-3"></i>
                        <h5 class="card-title">Crear Nuevo Informe</h5>
                        <p class="card-text">Inicia un nuevo informe de servicio para un cliente.</p>
                        <!-- ENLACE FUNCIONAL -->
                        <a href="/softGenn/public/index.php?action=crear_informe" class="btn btn-primary stretched-link">Iniciar Ahora</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light h-100 stat-card">
                    <div class="card-body">
                        <h6 class="text-muted">Mis Informes Totales</h6>
                        <!-- DATO DINÁMICO -->
                        <p class="fs-2 fw-bold mb-0"><?php echo htmlspecialchars($estadisticas['total_informes'] ?? 0); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light h-100 stat-card">
                    <div class="card-body">
                        <h6 class="text-muted">Informes Pendientes</h6>
                        <!-- DATO DINÁMICO -->
                        <p class="fs-2 fw-bold mb-0 text-warning"><?php echo htmlspecialchars($estadisticas['informes_pendientes'] ?? 0); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Mis Últimos Informes -->
        <section class="mt-5 pt-4">
            <h2 class="text-center mb-4">Mis Últimos Informes</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover bg-white rounded shadow-sm">
                    <thead class="table-light">
                        <tr>
                            <th># Informe</th><th>Fecha</th><th>Cliente</th><th>Estado</th><th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($actividadReciente)): ?>
                            <tr><td colspan="5" class="text-center py-4">Aún no has creado ningún informe.</td></tr>
                        <?php else: ?>
                            <?php foreach ($actividadReciente as $informe): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($informe['id_servicio']); ?></strong></td>
                                    <td><?php echo date('d/m/Y', strtotime($informe['ser_fecha'])); ?></td>
                                    <td><?php echo htmlspecialchars($informe['nombre_cliente'] ?? 'N/A'); ?></td>
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
                                        <a href="#" class="btn btn-sm btn-outline-primary" title="Ver Detalles"><i class="bi bi-eye-fill"></i></a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary" title="Descargar PDF"><i class="bi bi-file-earmark-pdf-fill"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>