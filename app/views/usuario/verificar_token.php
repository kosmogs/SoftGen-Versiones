<?php
// El email se pasará por la URL para saber a qué cuenta pertenece el token
$email = $_GET['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/softGenn/public/css/iniciosesion.css">
    <link rel="icon" type="image/png" href="/softGenn/public/img/Logo Favicon 16x16.png">
</head>
<body>
    <header>
        <div class="logo text-center">
            <img src="/softGenn/public/img/Logo completo.png" class="m-3" alt="Logo SoftGen" height="90px">
        </div>
    </header>

    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-container text-center">
                    <h3 class="mb-3">Verificar tu Identidad</h3>
                    <hr>
                    <p class="text-muted mb-4">Ingresa el código que enviamos a tu correo electrónico.</p>
                    <div id="mensaje" class="mb-3"></div>

                    <form action="/softGenn/public/index.php?action=procesar_token" method="POST">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el código aquí" name="token" required>
                        </div>
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary">Verificar Código</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Script para mostrar errores si el token es incorrecto
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const mensajeDiv = document.getElementById('mensaje');
            if (params.has('error')) {
                mensajeDiv.innerHTML = `<div class="alert alert-danger">${decodeURIComponent(params.get('error'))}</div>`;
            }
        });
    </script>
</body>
</html>
