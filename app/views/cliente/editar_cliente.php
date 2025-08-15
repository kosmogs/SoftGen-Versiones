<?php
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) { /* ... */ }
if (!isset($cliente)) { die('Error: Datos del cliente no encontrados.'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>

    <main class="container py-5">
        <h1 class="mb-4">Editar Cliente: <?php echo htmlspecialchars($cliente['razon_social']); ?></h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="/softGenn/public/index.php?action=editar_cliente" method="POST">
                    <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($cliente['id_cliente']); ?>">
                    <div class="row g-3">
                        <div class="col-md-6"><label for="razon_social" class="form-label">Razón Social*</label><input type="text" class="form-control" id="razon_social" name="razon_social" value="<?php echo htmlspecialchars($cliente['razon_social']); ?>" required></div>
                        <div class="col-md-6"><label for="cli_nit" class="form-label">NIT</label><input type="text" class="form-control" id="cli_nit" name="cli_nit" value="<?php echo htmlspecialchars($cliente['cli_nit']); ?>"></div>
                        <div class="col-md-6"><label for="contacto_nombre" class="form-label">Nombre del Contacto*</label><input type="text" class="form-control" id="contacto_nombre" name="contacto_nombre" value="<?php echo htmlspecialchars($cliente['contacto_nombre']); ?>" required></div>
                        <div class="col-md-6"><label for="direccion" class="form-label">Dirección*</label><input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($cliente['direccion']); ?>" required></div>
                        <div class="col-md-6"><label for="contacto_correo" class="form-label">Contacto correo*</label><input type="email" class="form-control" id="contacto_correo" name="contacto_correo" required></div>
                        <div class="col-md-6"><label for="contacto_telefono" class="form-label">Contacto teléfono*</label><input type="telefono" class="form-control" id="contacto_telefono" name="contacto_telefono" required></div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
                        <a href="/softGenn/public/index.php?action=gestionar_clientes" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
