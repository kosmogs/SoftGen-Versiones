<?php
// El controlador pasará las variables 'token' y 'email' después de la validación
if (!isset($token) || !isset($email)) {
    die("Error: Acceso denegado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Contraseña - SoftGen</title>
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
                    <h3 class="mb-3">Crear Nueva Contraseña</h3>
                    <hr>
                    <p class="text-muted mb-4">Tu identidad ha sido verificada. Ahora puedes crear una nueva contraseña.</p>

                    <form action="/softGenn/public/index.php?action=procesar_reset" method="POST" id="resetPasswordForm">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        <input type="hidden" name="usu_correo" value="<?php echo htmlspecialchars($email); ?>">

                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Nueva Contraseña" name="contrasena" id="nueva_contrasena" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Confirmar Nueva Contraseña" id="confirmar_contrasena" required>
                            <div class="invalid-feedback text-start" id="passwordMismatchError">
                                Las contraseñas no coinciden.
                            </div>
                        </div>
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary">Guardar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetForm = document.getElementById('resetPasswordForm');
            const passwordInput = document.getElementById('nueva_contrasena');
            const confirmPasswordInput = document.getElementById('confirmar_contrasena');
            const mismatchErrorDiv = document.getElementById('passwordMismatchError');

            if(resetForm) {
                resetForm.addEventListener('submit', function(event) {
                    passwordInput.classList.remove('is-invalid');
                    confirmPasswordInput.classList.remove('is-invalid');
                    if (passwordInput.value !== confirmPasswordInput.value) {
                        event.preventDefault();
                        passwordInput.classList.add('is-invalid');
                        confirmPasswordInput.classList.add('is-invalid');
                    }
                });
            }
        });
    </script>
</body>
</html>
