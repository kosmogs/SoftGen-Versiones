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
    <title>Crear Nuevo Usuario - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>

    <main class="container py-5">
        <h1 class="mb-4">Crear Nuevo Usuario</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="/softGenn/public/index.php?action=crear_usuario" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="usu_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="usu_nombre" name="usu_nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="usu_apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="usu_apellido" name="usu_apellido" required>
                        </div>
                        <div class="col-md-6">
                            <label for="usu_correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="usu_correo" name="usu_correo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="usu_contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="usu_contrasena" name="usu_contrasena" required>
                        </div>
                        <div class="col-md-6">
                            <label for="usu_doc_identidad" class="form-label">Documento de Identidad</label>
                            <input type="text" class="form-control" id="usu_doc_identidad" name="usu_doc_identidad" required>
                        </div>
                        <div class="col-md-6">
                            <label for="usu_telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="usu_telefono" name="usu_telefono" required>
                        </div>
                        <div class="col-md-12">
                            <label for="id_rol" class="form-label">Rol</label>
                            <select class="form-select" id="id_rol" name="id_rol" required>
                                <option value="1">Administrador</option>
                                <option value="2" selected>Técnico</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                        <a href="/softGenn/public/index.php?action=gestionar_usuarios" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>