<?php
// Medida de Seguridad Esencial
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
    <title>Panel de Administración - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Saira', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            padding: 20px;
            background-color: #212529;
            color: #fff;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            font-size: 1.1rem;
            padding: 10px 15px;
            border-radius: 0.375rem;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            color: #fff;
            background-color: #343a40;
        }
        .sidebar .nav-link .bi {
            margin-right: 10px;
        }
        .sidebar .logo {
            margin-bottom: 30px;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        .stat-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        }
    </style>
</head>
<body>

    <!-- Barra de Navegación Lateral (Sidebar) -->
    <div class="sidebar">
        <div class="logo text-center">
            <img src="/softGenn/public/img/Logo completo.png" alt="Logo SoftGen" height="70">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="?url=admin_dashboard">
                    <i class="bi bi-speedometer2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/softGenn/public/index.php?action=gestionar_usuarios">
                    <i class="bi bi-people-fill"></i>Gestión de Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-journal-text"></i>Gestión de Informes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-building"></i>Gestión de Clientes
                </a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-tools"></i>Gestión de Equipos
                </a>
            </li>
        </ul>
        <div class="mt-auto" style="position: absolute; bottom: 20px; width: calc(100% - 40px);">
            <hr class="bg-secondary">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-circle fs-3 me-2"></i>
                <div>
                    <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></strong><br>
                    <small><?php echo htmlspecialchars($_SESSION['rol_nombre']); ?></small>
                </div>
            </div>
            <a href="/softGenn/public/index.php?action=cerrar_sesion" class="btn btn-danger w-100 mt-3">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <main class="main-content">
        <h1 class="mb-4">Dashboard de Administración</h1>

        <!-- Tarjetas de Estadísticas -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card bg-primary text-white stat-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Informes Totales</h5>
                            <p class="card-text fs-2 fw-bold"><?php echo htmlspecialchars($estadisticas['total_informes']); ?></p>
                        </div>
                        <i class="bi bi-file-earmark-text-fill fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card bg-success text-white stat-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Técnicos Activos</h5>
                            <p class="card-text fs-2 fw-bold"><?php echo htmlspecialchars($estadisticas['total_tecnicos']); ?></p>
                        </div>
                        <i class="bi bi-person-check-fill fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card bg-info text-white stat-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Clientes</h5>
                            <p class="card-text fs-2 fw-bold"><?php echo htmlspecialchars($estadisticas['total_clientes']); ?></p>
                        </div>
                        <i class="bi bi-building fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card bg-warning text-dark stat-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Pendientes</h5>
                            <p class="card-text fs-2 fw-bold"><?php echo htmlspecialchars($estadisticas['informes_pendientes']); ?></p>
                        </div>
                        <i class="bi bi-pen-fill fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos y Acciones Críticas -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Informes por Tipo de Servicio</h5>
                        <canvas id="informesPorTipoChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Estado de Servicios</h5>
                        <canvas id="estadoServiciosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Últimos Informes -->
        <div class="card stat-card">
            <div class="card-header">
                <h5 class="mb-0">Últimos Informes Registrados</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th><th>Cliente</th><th>Técnico</th><th>Fecha</th><th>Estado</th><th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($actividadReciente)): ?>
                                <tr><td colspan="6" class="text-center">No hay informes recientes.</td></tr>
                            <?php else: ?>
                                <?php foreach ($actividadReciente as $actividad): ?>
                                    <tr>
                                        <td><strong>#<?php echo htmlspecialchars($actividad['id_servicio']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($actividad['nombre_cliente']); ?></td>
                                        <td><?php echo htmlspecialchars($actividad['usu_nombre'] . ' ' . $actividad['usu_apellido']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($actividad['ser_fecha'])); ?></td>
                                        <td>
                                            <?php 
                                                $estado = htmlspecialchars($actividad['ser_estado'] ?? 'Pendiente');
                                                $badge_class = 'bg-secondary';
                                                if ($estado == 'Firmado') $badge_class = 'bg-success';
                                                if ($estado == 'Rechazado') $badge_class = 'bg-danger';
                                                if ($estado == 'Pendiente') $badge_class = 'bg-warning text-dark';
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>"><?php echo $estado; ?></span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye-fill"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Librería para Gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- DATOS REALES DESDE PHP ---
            // Convertimos los arrays de PHP a objetos de JavaScript de forma segura.
            const datosTipoPHP = <?php echo json_encode($estadisticas['informes_por_tipo'] ?? []); ?>;
            const labelsTipo = Object.keys(datosTipoPHP);
            const dataTipo = Object.values(datosTipoPHP);

            const datosEstadoPHP = <?php echo json_encode($estadisticas['informes_por_estado'] ?? []); ?>;
            const labelsEstado = Object.keys(datosEstadoPHP);
            const dataEstado = Object.values(datosEstadoPHP);

            // Gráfico de Barras: Informes por Tipo
            const chartTipo = document.getElementById('informesPorTipoChart');
            if (chartTipo && labelsTipo.length > 0) {
                new Chart(chartTipo, {
                    type: 'bar',
                    data: {
                        labels: labelsTipo,
                        datasets: [{
                            label: 'Nº de Informes',
                            data: dataTipo,
                            backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#0dcaf0', '#6f42c1', '#fd7e14']
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                });
            }

            // Gráfico de Dona: Estado de Servicios
            const chartEstado = document.getElementById('estadoServiciosChart');
            if (chartEstado && labelsEstado.length > 0) {
                new Chart(chartEstado, {
                    type: 'doughnut',
                    data: {
                        labels: labelsEstado,
                        datasets: [{
                            data: dataEstado,
                            backgroundColor: ['#198754', '#ffc107', '#dc3545', '#6c757d'] // Colores para Firmado, Pendiente, Rechazado, etc.
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } } }
                });
            }
        });
    </script>
</body>
</html>