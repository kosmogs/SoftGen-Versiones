
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Saira:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/css/iniciosesion.css">

    <link rel="icon" type="image/png" sizes="16x16" href="public/img/Logo Favicon 16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="public/img/Logo favicon 1.0.png">
    <link rel="icon" type="image/png" sizes="180x180" href="public/img/Logo Favicon 180x180.png">
</head>
</head>
<header>
    <div class="logo text-center">
        <img src="../public/img/Logocompleto.png" class="m-3" alt="Logo SoftGen" height="90px">
    </div>
</header>
<body>
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="login-container text-center">
                    <h3 class="mb-3">Iniciar Sesión</h3>
                    <hr>

                    <div id="mensaje" class="mb-3"></div>

                    <form action="/softGenn/public/index.php?action=iniciar_sesion" method="POST" id="loginForm " class="shadown" >

                        <div class="mb-2">
                            <select name="rol" id="rol" class="form-select" required>
                                <option value="">Elija su rol</option>
                                <option value="2">Tecnico</option>
                                <option value="1">Administrador</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="correo" required>
                        </div>

                        <div class="mb-3 col-12">
                            <div class="password-wrapper">
                                <input type="password" id="passwordField" class="form-control" placeholder="Contraseña" name="contrasena" required>
                                <span class="toggle-password" id="togglePassword" style="position: absolute;">👁</span>
                            </div>
                        </div>

                        <div class="mb-3 text-center">
                            <a href="index.php?action=solicitar_reset">¿Olvidó su contraseña?</a>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary mb-4">Iniciar Sesión</button>
                        </div>

                    </form>
                    </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error de Inicio de Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="errorModalBody">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

    <footer class="text-white mt-5" id="piePagina">
            <?php 
            require_once "../public/headerandfoother/foother1.php"
            ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- RUTA CORREGIDA -->
    <script src="js/iniciosesion.js"></script> 
    
    <!-- Este script JS ya es compatible con nuestro controlador, ¡perfecto! -->
    <script>
        const params = new URLSearchParams(window.location.search);
        const mensajeDiv = document.getElementById('mensaje');
        if (params.has('error')) {
            mensajeDiv.innerHTML = `<div class="alert alert-danger">${decodeURIComponent(params.get('error'))}</div>`;
        } else if (params.has('registro') && params.get('registro') === 'exitoso') {
            mensajeDiv.innerHTML = `<div class="alert alert-success">¡Registro exitoso! Ahora puedes iniciar sesión.</div>`;
        } else if (params.has('status') && params.get('status') === 'logout') {
            mensajeDiv.innerHTML = `<div class="alert alert-info">Has cerrado sesión correctamente.</div>`;
        }
    </script>
</body>
</html>
