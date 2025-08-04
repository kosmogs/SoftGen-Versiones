<?php
// app/views/layouts/admin_header.php

// Pequeña lógica para determinar qué enlace de la barra lateral está activo
$currentAction = $_GET['action'] ?? 'dashboard_admin';
?>
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
        z-index: 100;
    }
    .sidebar .nav-link {
        color: #adb5bd;
        font-size: 1.1rem;
        padding: 10px 15px;
        border-radius: 0.375rem;
        transition: background-color 0.2s, color 0.2s;
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
    .main-content-with-sidebar {
        margin-left: 260px;
    }
</style>

<!-- Barra de Navegación Lateral (Sidebar) -->
<div class="sidebar">
    <div class="logo text-center">
        <a href="/softGenn/public/index.php?action=dashboard_admin">
            <img src="/softGenn/public/img/Logo completo.png" alt="Logo SoftGen" height="70">
        </a>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentAction == 'dashboard_admin') ? 'active' : ''; ?>" href="/softGenn/public/index.php?action=dashboard_admin">
                <i class="bi bi-speedometer2"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <!-- CORREGIDO: Lógica para marcar como activo si la acción contiene 'usuario' -->
            <a class="nav-link <?php echo (str_contains($currentAction, 'usuario')) ? 'active' : ''; ?>" href="/softGenn/public/index.php?action=gestionar_usuarios">
                <i class="bi bi-people-fill"></i>Gestión de Usuarios
            </a>
        </li>
        <li class="nav-item">
            <!-- CORREGIDO: Enlace y lógica de 'active' para Gestión de Informes -->
            <a class="nav-link <?php echo (str_contains($currentAction, 'informe')) ? 'active' : ''; ?>" href="/softGenn/public/index.php?action=gestionar_informes">
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
        <hr style="color: #6c757d;">
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle fs-3 me-2"></i>
            <div>
                <strong><?php echo htmlspecialchars($_SESSION['nombre_usuario'] ?? 'Admin'); ?></strong><br>
                <small><?php echo htmlspecialchars($_SESSION['rol_nombre'] ?? 'Administrador'); ?></small>
            </div>
        </div>
        <a href="/softGenn/public/index.php?action=cerrar_sesion" class="btn btn-danger w-100 mt-3">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </a>
    </div>
</div>

<!-- Div para empujar el contenido principal -->
<div class="main-content-with-sidebar">
    <!-- El contenido de cada página se mostrará aquí después de este div -->