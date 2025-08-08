<style>
    .nav-link {
    font-family: saira;
    text-decoration: none;
    color: #135787;
 }

 .navbar {
    background-color: #e4f7ff;
    color: #135787;
 }


    .navbar-nav .nav-link.active,
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link:focus {
        font-weight: bold;
        color: #135787;
        background-color: rgba(0, 86, 179, 0.1);
        border-radius: 4px;

    }

    :root{
        --sidebar-bg: #135787;
 
        --sidebar-active: #fff;
    }
    
    .sidebar {
        background-color: var(--sidebar-bg);
        color: var(--sidebar-text);
        height: 100vh;
        position: fixed;
        padding-top: 20px;
        width: 250px;
        font-family: saira;
    }

    .sidebar .nav-link {
        color: white;
        margin-bottom: 5px;
        border-radius: 5px;
        padding: 10px 15px;
    }

    .sidebar .nav-link:hover, .sidebar .nav-link.active {
        background-color: var(--sidebar-active);
    }

    .sidebar .nav-link i {
        margin-right: 10px;
    }

    .nav-link {

        text-decoration: none;
    }


    .navbar-toggler {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        border: none;
        padding: 10px;
        font-size: 40px;
    }
</style>
<header>
        <nav class="navbar navbar-expand-lg" >
            <div class="container-fluid pt-2 sm">
                <a class="navbar-brand" href="/../softgenn/app/views/usuario/login.php">
                    <img src="/softGenn/public/img/Logocompleto.png" alt="SOFTGEN Logo" width="180">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span><i class="bi bi-grid-fill"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li><a class="nav-link" href="javascript:void(0);" onclick="window.location.replace('../app/views/dashboard/tecnico_dashboard.php');">Inicio</a></li>
                        <li><a class="nav-link" href="javascript:void(0);" onclick="window.location.replace('../app/views/informes/crear_informe.php');">Creación</a></li>
                        <li><a class="nav-link" href="javascript:void(0);" onclick="window.location.replace('../app/views/informes/gestion_informes.php');">Visualización</a></li>
                        <li><a class="nav-link" href="soporte.html">Soporte</a></li>
                    </ul>
                    <ul class="navbar-nav">
                        <li><a class="nav-link" href="javascript:void(0);" onclick="window.location.replace('/../app/views/usuario/login.php');">Cerrar sesion</a></li>
                        <li><a class="nav-link" href="javascript:void(0);" onclick="window.location.replace('/../app/views/usuario/editar_usuario.php');">Editar</a></li>
                    </ul>
                </div>
            </div>
        </nav>
</header>