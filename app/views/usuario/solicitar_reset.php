<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi Contraseña - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/softGenn/public/css/iniciosesion.css">
    <link rel="icon" type="image/png" href="/softGenn/public/img/Logo Favicon 16x16.png">
</head>
<body>
    <header>
        <div class="logo text-center">
            <img src="/softGenn/public/img/Logo completo.png" class="m-3" alt="Logo SoftGen" height="90px">
        </div>
    </header>
    <div class="container pt-5 main-content">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-container text-center">
                    <h3 class="mb-3">¿Olvidaste tu Contraseña?</h3>
                    <hr>
                    <p class="text-muted mb-4">Ingresa tu dirección de correo y te enviaremos un enlace para restablecer tu contraseña.</p>
                    <div id="mensaje" class="mb-3"></div>
                    <form action="/softGenn/public/index.php?action=procesar_solicitud" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label visually-hidden">Email</label>
                            <input type="email" class="form-control" id="email" name="usu_correo" placeholder="Ingresa tu Email" required autocomplete="email">
                        </div>
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary">Enviar Enlace</button>
                        </div>
                        <div class="text-center">
                            <a href="/softGenn/public/index.php?action=login" class="btn btn-link">Volver a Iniciar Sesión</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const mensajeDiv = document.getElementById('mensaje');
            if (params.has('error')) {
                mensajeDiv.innerHTML = `<div class="alert alert-danger">${decodeURIComponent(params.get('error'))}</div>`;
            } else if (params.has('exito')) {
                mensajeDiv.innerHTML = `<div class="alert alert-success">${decodeURIComponent(params.get('exito'))}</div>`;
            }
        });
    </script>
</body>
</html>
