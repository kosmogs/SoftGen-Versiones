<?php
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /softGenn/public/index.php?action=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Reporte</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Saira:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link rel="stylesheet" href="../public/css/estiloequipo.css">
    
    <link rel="stylesheet" href="../public/css/cssBoostrap/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/jsBoostrap/bootstrap.min.js">

    <link rel="icon" type="image/png" sizes="16x16" href="../public/img/Logo Favicon 16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/img/Logo favicon 1.0.png">
    <link rel="icon" type="image/png" sizes="180x180" href="../public/img/Logo Favicon 180x180.png">
    
    <style>
        .step { display: none; }
        .step.active { display: block; }
    </style>
</head>

<header>
    <div class="bg-primary">
        <?php
            include '/../xampp/htdocs/softgenn/public/headerandfoother/header1.php';
        ?>
    </div>
    
</header>

<body>
    
<div class="container shadow-lg ">
    <form id="formularioReporte" action="?action=procesar_reporte" method="post" class="form-container">
        <h2 class="mb-4 text-center">Crear Reporte de Servicio</h2>
        <div class="progress mb-4" style="height: 25px;">
            <div id="progressBar" class="progress-bar" style="background-color: #135787;" style="color: white;" role="progressbar" style="width: 33.33%;">Paso 1 de 3</div>
        </div>

        <!-- PASO 1: DATOS DEL CLIENTE Y UBICACIÓN -->
        <div class="step active" id="step1">
            <h5 class="mb-3">1. Datos del Cliente y Ubicación</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="selectCliente" class="form-label">Cliente</label>
                    <select class="form-select" name="cliente_id" id="selectCliente" required>
                        <option value="">Seleccione un cliente</option>
                        <?php if (isset($clientes) && is_array($clientes) && !empty($clientes)): ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <!-- El modelo ya nos da 'cli_nombre' correctamente. -->
                                <option value="<?= htmlspecialchars($cliente['id_cliente']) ?>">
                                    <?= htmlspecialchars($cliente['nit']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Se muestra si el array de clientes está vacío -->
                            <option value="" disabled>No hay clientes disponibles</option>
                        <?php endif; ?>
                    </select>
                    
                    <?php if (empty($clientes)): ?>
                        <!-- MENSAJE DE DEPURACIÓN: Se muestra solo si no se encontraron clientes -->
                        <div class="alert alert-warning mt-2" role="alert">
                            <strong>No se encontraron clientes.</strong><br>
                            Asegúrate de que existan usuarios con el rol 'Cliente' y que estos tengan un registro asociado en la tabla `cliente`. La consulta actual busca clientes que existan en ambas tablas.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="selecEmpresa" class="form-label">Empresa</label>
                    <select class="form-select" name="empresa_id" id="selectEmpresa" required>
                        <option value="">Selecione una empresa</option>
                        <?php if (isset($empresas) && is_array($empresas)&& !empty($empresas)):?>
                            <?php foreach ($empresas as $empresa):?>
                                <option value="<?= htmlspecialchars($empresa['id_empresa'])?>">
                                    <?= htmlspecialchars($empresa['razon_social'])?>
                                </option>
                            <?php endforeach;?>
                            <?php else: ?>
                            <!-- Se muestra si el array de clientes está vacío -->
                            <option value="" disabled>No hay empresas disponibles</option>
                        <?php endif;?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="tipo_servicio" class="form-label">Tipo de servicio</label>
                    <select class="form-select" name="ser_tipo_servicio" id="tipo_servicio" required>
                        <option value="">Seleccione un tipo de servicio</option>
                        <?php if (isset($tipo_servicio) && is_array($tipo_servicio)): ?>
                        <?php foreach ($tipo_servicio as $servicio):?>
                            <option value="<?= htmlspecialchars($servicio); ?>">
                                <?= htmlspecialchars($servicio); ?>
                            </option>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No hay tipos de servicio disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="tipo_informe" class="form-label">Tipo informe</label>
                    <select class="form-select" name="ser_tipo_informe" id="tipo_informe" required>
                        <option value="">Seleccione el tipo de informe</option>
                        <?php if (isset($tipo_servicio) && is_array($tipo_informe)): ?>
                        <?php foreach ($tipo_informe as $tinforme):?>
                            <option value="<?=htmlspecialchars($tinforme); ?>">
                                <?=htmlspecialchars($tinforme); ?>
                            </option>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <option value=""disabled>No hay tipos de informes que elegir</option>
                        <?php endif; ?>
                    </select>
                </div>

            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="sitio" class="form-label">Sitio</label>
                    <input type="text" class="form-control" id="sitio" name="ubi_sitio" placeholder="Ej: Oficina Principal, Bodega" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" name="ubi_ciudad" placeholder="Ej: Bucaramanga" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="departamento" class="form-label">Departamento</label>
                    <select class="form-select" name="ubi_departamento" id="departamento" required >
                        <?php if (isset($departamentos) && is_array($departamentos)): ?>
                            <?php foreach ($departamentos as $depto): ?>
                                <option value="<?= htmlspecialchars($depto); ?>">
                                    <?= htmlspecialchars($depto); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="barrio" class="form-label">Barrio</label>
                    <input type="text" class="form-control" id="barrio" name="ubi_barrio" placeholder="Ej: Cabecera" required>
                </div>  
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="col-md-6 mb-3">
                    <label for="localidad" class="form-label">Localidad</label>
                    <input type="text" class="form-control" id="localidad" name="ubi_localidad" placeholder="Ej: su mama en tanga" required>
                </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="calle" class="form-label">Dirección (Calle, Carrera, Número)</label>
                    <input type="text" class="form-control" id="calle" name="ubi_calle" placeholder="Ej: Cra 33 # 48-10" required>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="button" class="btn next-btn" style="background-color:#135787" style="color: white;">Siguiente <i class="bi bi-caret-right-fill"></i></button>
            </div>
        </div>
        <div class="step" id="step2">
            <h5 class="mb-3">2.Datos del equipo</h5>
            <div id="equipos-container">
                <div class="equipo-group mb-3">
                    <div class="row">
                        <div class="col-md-4"><label class="form-label">Tipo de Equipo</label><input type="text" class="form-control" name="equipos[0][tipo_equipo]" placeholder="Mini split" required></div>
                        <div class="col-md-4"><label class="form-label">Marca</label><input type="text" class="form-control" name="equipos[0][marca]" placeholder="Lg" required></div>
                        <div class="col-md-4"><label class="form-label">Modelo</label><input type="text" class="form-control" name="equipos[0][modelo]" placeholder="1004398" required></div>  
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label class="form-label">Serie</label><input type="text" class="form-control" name="equipos[0][serie]" placeholder="AAA123" required></div>
                        <div class="col-md-4"><label class="form-label">Refrigerante</label><input type="text" class="form-control" name="equipos[0][refrigerante]" placeholder="0l124R" required></div>
                        <div class="col-md-4"><label class="form-label">Ubicación</label><input type="text" class="form-control" name="equipos[0][ubicacion]" placeholder="Segundo piso" required></div>
                    </div>
                    <hr class="mt-4">
                </div>   
            </div>
            <div class="row mt-3">
                <div class="col-md-12 col-md-2 mb-3 text-center">
                    <button type="button" id="add-equipo-btn" class="btn btn-outline-dark mt-2">
                        <i class="bi bi-plus-circle me-2"></i>Añadir Equipo
                    </button>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn prev-btn" style="background-color:#135787" style="color: white;"><i class="bi bi-caret-left-fill"></i> Anterior</button>
                <button type="button" class="btn  next-btn" style="background-color:#135787" style="color: white;">Siguiente <i class="bi bi-caret-right-fill"></i></button>
            </div>
        </div>

        <!-- PASO 2: INSPECCIÓN -->
        <div class="step" id="step3">
            <h5 class="mb-3">3. Detalles de Inspección General</h5>
            <div class="row">
                <div class="col-md-4 col-6 mb-2"><input class="form-check-input" type="checkbox" value="1" id="azul" name="ig_goteras"><label>Goteras </label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_gabinete" value="1"> <label>Gabinete</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_filtro" value="1"> <label>Filtro</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_drenaje" value="1"> <label>Drenaje</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_serpentina" value="1"> <label>Serpentina</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_refrigerante" value="1"> <label>Fuga de Refrigerante</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_vibracion" value="1"> <label>Vibración Anormal</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_tablero_electronico" value="1"> <label>Tablero Electrónico</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_aislamiento_gabinete" value="1"> <label>Aislamiento</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_flujo_aire" value="1"> <label>Flujo de Aire</label></div>
            </div>
            <hr>
            <h5 class="mb-3 mt-3">Datos Eléctricos y de Temperatura</h5>
            <div class="row">
                <div class="col-md-3 mb-3"><label class="form-label">Amperios</label><input type="number" step="0.01" class="form-control" name="ig_amperios" placeholder="Ej: 5.25" required></div>
                <div class="col-md-3 mb-3"><label class="form-label">Voltaje</label><input type="number" step="0.01" class="form-control" name="ig_voltaje" placeholder="Ej: 220" required></div>
                <div class="col-md-3 mb-3"><label class="form-label">Temp. Suministro (°C)</label><input type="number" step="0.01" class="form-control" name="ig_temp_suministro" placeholder="Ej: 18.5" required></div>
                <div class="col-md-3 mb-3"><label class="form-label">Temp. Retorno (°C)</label>
                <input type="number" step="0.01" class="form-control" name="ig_temp_retorno" placeholder="Ej: 25.0" required></div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn prev-btn" style="background-color:#135787" style="color: white;"><i class="bi bi-caret-left-fill"></i> Anterior</button>
                <button type="button" class="btn  next-btn" style="background-color:#135787" style="color: white;">Siguiente <i class="bi bi-caret-right-fill"></i></button>
            </div>
        </div>
    
        <!-- PASO 3: OBSERVACIONES -->
        <div class="step" id="step4"> 
            <h5 class="md-3 mb-3"> Tipo de servicio </h5>
            <div class="row">
                <h2>Seleccione el estado de los siguientes elementos</h2>
                <div class="col-md-3 mb-3">
                    <label for="Ejes" class="form-label">Estado de ejes</label>
                    <select name="rm_ejes" id="ejes" class="form-select" >
                        <option value="1">Bueno</option>
                        <option value="2">Regular</option>
                        <option value="3">Malo</option>
                        <option value="4">Requiere cambio</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="Rodamientos"class="form-label">Rodamientos</label>
                    <select name="rm_rodamientos" id="rodamientos" class="form-select" >
                        <option value="1">Bueno</option>
                        <option value="2">Regular</option>
                        <option value="3">Malo</option>
                        <option value="4">Requiere cambio</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="Chumaceras" class="form-label">Chumaceras</label>
                    <select name="rm_chumaceras" id="chumaceras" class="form-select" >
                        <option value="1">Bueno</option>
                        <option value="2">Regular</option>
                        <option value="3">Malo</option>
                        <option value="4">Requiere cambio</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="Poleas" class="form-label">Poleas</label>
                    <select name="rm_poleas" id="poleas" class="form-select" >
                        <option value="1">Bueno</option>
                        <option value="2">Regular</option>
                        <option value="3">Malo</option>
                        <option value="4">Requiere cambio</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="Correas" class="form-label">Correa</label>
                    <select name="rm_correas" id="correas" class="form-select" >
                        <option value="1">Bueno</option>
                        <option value="2">Regular</option>
                        <option value="3">Malo</option>
                        <option value="4">Requiere cambio</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                <label for="Rejillas" class="form-label">Rejillas</label>
                    <select name="rm_rejillas" id="rejillas" class="form-select" >
                        <option value="1">Bueno</option>
                        <option value="2">Regular</option>
                        <option value="3">Malo</option>
                        <option value="4">Requiere cambio</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                <label for="Pintura" class="form-label">Pintura</label>
                    <select name="rm_pintura" id="pintura" class="form-select" >
                        <option value="1">Bueno</option>
                        <option value="2">Regular</option>
                        <option value="3">Malo</option>
                        <option value="4">Requiere cambio</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                <label for="Ductos" class="form-label">Ductos</label>
                    <select name="rm_ductos" id="ductos" class="form-select" >
                        <option value="1">Bueno</option>
                        <option value="2">Regular</option>
                        <option value="3">Malo</option>
                        <option value="4">Requiere cambio</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="ser_hora_entrada">Hora de entrada</label>
                    <br>
                    <input type="time" class="" name="hora_entrada">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="ser_hora_salida">Hora de salida</label>
<br>
                    <input type="time" class="" name="hora_salida" id="hora_salida">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="fecha_servicio">Fecha servicio</label>
                    <br>
                    <input type="date" name="fecha_servicio" id="fecha_servicio">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Observaciones</label>
                    <input type="text" class="form-control" name="ser_observaciones" placeholder="El dispositivos tine...">
                </div>
            </div>
            <div class="row md-3 mb-3">
                <div class="text-center mb-4">
                    <button type="button" class="btn prev-btn mt-3" style="background-color:#135787" style="color: white;"><i class="bi bi-caret-left"></i> Anterior</button>
                    <button type="button" class="btn next-btn mt-3" style="background-color:#135787" style="color: white;"> Siguiente <i class="bi bi-caret-right"></i> </button> </div>
                </div>
            </div>
            
        </div>

        <div class="step" id="step5">
            <h5 class="mb-3">3. Observaciones Finales</h5>
            <div class="mb-3">
                <label for="observaciones" class="form-label">Añade aquí cualquier detalle adicional, recomendación o trabajo realizado.</label>
                <textarea name="observaciones" id="observaciones" class="form-control" rows="6" required></textarea>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary prev-btn"><i class="bi bi-caret-left-fill"></i> Anterior</button>
                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle-fill"></i> Finalizar y Generar PDF</button>
            </div>
        </div>
    </form>
</div>
<footer>
    <div class="bg-primary">
        <?php
           include '/xampp/htdocs/USU6/public/headerandfoother/foother1.php'; 

        ?>
    </div>
</footer>
<!-- SCRIPT PARA EL FORMULARIO MULTIPASOS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');
        const progressBar = document.getElementById('progressBar');

        function showStep(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === stepIndex);
            });
            const progress = ((stepIndex + 1) / steps.length) * 100;
            progressBar.style.width = progress + '%';
            progressBar.textContent = `Paso ${stepIndex + 1} de ${steps.length}`;
        }

        document.querySelectorAll('.next-btn').forEach(button => {
            button.addEventListener('click', () => {
                const currentStepInputs = steps[currentStep].querySelectorAll('[required]');
                let allValid = true;
                currentStepInputs.forEach(input => {
                    if (!input.value.trim()) {
                        allValid = false;
                        input.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (allValid && currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                } else if (!allValid) {
                    alert('Por favor, completa todos los campos requeridos en este paso.');
                }
            });
        });

        document.querySelectorAll('.prev-btn').forEach(button => {
            button.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });

        showStep(currentStep);
    });
</script>
<script src="../public/js/javaequipo.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>