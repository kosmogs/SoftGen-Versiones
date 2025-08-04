<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Servicio Técnico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            font-size: 14px;
        }

        .report-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2.5rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .report-header {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .company-logo {
            max-height: 80px;
            max-width: 200px;
        }

        .report-title {
            color: #0d6efd;
            font-weight: 700;
            font-size: 2rem;
            text-align: right;
        }

        .section-title {
            background-color: #0d6efd;
            color: #fff;
            padding: 0.5rem 1rem;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 1rem;
            border-radius: 0.25rem;
        }
        
        .info-box p {
            margin-bottom: 0.25rem;
        }

        .table {
            border: 1px solid #dee2e6;
        }
        
        .table thead th {
            background-color: #e9ecef;
        }

        .checklist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 0.75rem;
        }

        .checklist-item {
            background-color: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            border-left: 4px solid #adb5bd;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .checklist-item.ok {
            border-left-color: #198754;
        }
        
        .checklist-item.fail {
            border-left-color: #dc3545;
        }
        
        .checklist-item .status-icon {
            font-size: 1.2rem;
        }

        .photo-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .photo-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
        
        .photo-item p {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 0.25rem;
            text-align: center;
        }

        .signature-box {
            border: 1px solid #dee2e6;
            padding: 1rem;
            margin-top: 1rem;
            background-color: #f8f9fa;
            text-align: center;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .signature-box img {
            max-height: 80px;
            object-fit: contain;
            margin: auto;
        }

        .signature-box .signature-line {
            border-top: 1px solid #6c757d;
            margin-top: auto;
            padding-top: 0.5rem;
        }

        .report-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #dee2e6;
            font-size: 0.8rem;
            color: #6c757d;
        }

        @media print {
            body {
                background-color: #fff;
                font-size: 12px;
            }
            .report-container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
                max-width: 100%;
            }
            .section-title {
                background-color: #e9ecef !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
            }
            .photo-gallery {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>

    <div class="report-container">
        <!-- ENCABEZADO -->
        <header class="report-header row align-items-center">
            <div class="col-6">
                <img src="{{empresa.logo}}" alt="Logo de la Empresa" class="company-logo" 
                    onerror="this.onerror=null; this.src='https://placehold.co/200x80/ffffff/cccccc?text=Logo+Empresa';">
                <p class="mt-3 mb-0"><strong>{{empresa.razon_social}}</strong></p>
                <p class="mb-0 text-muted">{{empresa.direccion}}</p>
                <p class="mb-0 text-muted">NIT: {{empresa.nit}}</p>
                <p class="mb-0 text-muted">Contacto: {{empresa.telefono}} - {{empresa.correo}}</p>
            </div>
            <div class="col-6 text-end">
                <h1 class="report-title">INFORME DE SERVICIO</h1>
                <p class="mb-0"><strong>Informe N°:</strong> {{servicio.id}}</p>
                <p class="mb-0"><strong>Fecha:</strong> {{servicio.fecha}}</p>
            </div>
        </header>

        <main>
            <!-- INFORMACIÓN DEL CLIENTE Y SERVICIO -->
            <section class="row">
                <div class="col-6">
                    <h5 class="mb-2"><strong>Cliente:</strong></h5>
                    <div class="info-box">
                        <p><strong>Razón Social:</strong> {{cliente.razon_social}}</p>
                        <p><strong>NIT / C.C:</strong> {{cliente.nit}}</p>
                        <p><strong>Contacto:</strong> {{cliente.contacto_nombre}}</p>
                        <p><strong>Dirección Servicio:</strong> {{cliente.direccion}}</p>
                        <p><strong>Teléfono:</strong> {{cliente.contacto_telefono}}</p>
                    </div>
                </div>
                <div class="col-6">
                    <h5 class="mb-2"><strong>Detalles del Servicio:</strong></h5>
                    <div class="info-box">
                        <p><strong>Tipo de Informe:</strong> {{servicio.tipo_informe}}</p>
                        <p><strong>Tipo de Servicio:</strong> {{servicio.tipo_servicio}}</p>
                        <p><strong>Hora de Entrada:</strong> {{servicio.hora_entrada}}</p>
                        <p><strong>Hora de Salida:</strong> {{servicio.hora_salida}}</p>
                        <p><strong>Técnico Asignado:</strong> {{tecnico.nombre_completo}}</p>
                    </div>
                </div>
            </section>

            <!-- EQUIPOS ATENDIDOS -->
            <section>
                <h3 class="section-title"><i class="bi bi-gear-wide-connected"></i>Equipos Atendidos</h3>
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo de Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Ubicación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- {{#each equipos}} -->
                        <tr>
                            <td>{{equipo.tipo}}</td>
                            <td>{{equipo.marca}}</td>
                            <td>{{equipo.modelo}}</td>
                            <td>{{equipo.serie}}</td>
                            <td>{{equipo.ubicacion}}</td>
                        </tr>
                        <!-- {{/each}} -->
                        <!-- Ejemplo 2 -->
                        <tr>
                            <td>Unidad Manejadora</td>
                            <td>Carrier</td>
                            <td>39M</td>
                            <td>CAR-39M-00123</td>
                            <td>Piso 5 - Ala Norte</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            
            <!-- MEDICIONES TÉCNICAS -->
            <section>
                <h3 class="section-title"><i class="bi bi-speedometer2"></i>Mediciones Técnicas</h3>
                <div class="row">
                    <div class="col-md-3 text-center info-box me-3">
                        <p class="fs-5 fw-bold mb-0">{{mediciones.voltaje}} V</p>
                        <small class="text-muted">VOLTAJE</small>
                    </div>
                    <div class="col-md-3 text-center info-box me-3">
                        <p class="fs-5 fw-bold mb-0">{{mediciones.amperaje}} A</p>
                        <small class="text-muted">AMPERAJE</small>
                    </div>
                    <div class="col-md-3 text-center info-box me-3">
                        <p class="fs-5 fw-bold mb-0">{{mediciones.temp_suministro}} °C</p>
                        <small class="text-muted">T° SUMINISTRO</small>
                    </div>
                    <div class="col-md-3 text-center info-box">
                        <p class="fs-5 fw-bold mb-0">{{mediciones.temp_retorno}} °C</p>
                        <small class="text-muted">T° RETORNO</small>
                    </div>
                </div>
            </section>

            <!-- CHECKLIST DE ACTIVIDADES -->
            <section>
                <h3 class="section-title"><i class="bi bi-check2-circle"></i>Checklist de Actividades Realizadas</h3>
                <div class="checklist-grid">
                    <!-- {{#each checklist}} -->
                    <div class="checklist-item {{#if ok}}ok{{else}}fail{{/if}}">
                        <span>{{nombre_item}}</span>
                        <span class="status-icon">
                            {{#if ok}}
                                <i class="bi bi-check-circle-fill text-success"></i>
                            {{else}}
                                <i class="bi bi-x-circle-fill text-danger"></i>
                            {{/if}}
                        </span>
                    </div>
                    <!-- {{/each}} -->
                    <!-- Ejemplos -->
                    <div class="checklist-item ok"><span>Limpieza de filtros</span><span class="status-icon"><i class="bi bi-check-circle-fill text-success"></i></span></div>
                    <div class="checklist-item ok"><span>Revisión de drenaje</span><span class="status-icon"><i class="bi bi-check-circle-fill text-success"></i></span></div>
                    <div class="checklist-item ok"><span>Inspección de serpentín</span><span class="status-icon"><i class="bi bi-check-circle-fill text-success"></i></span></div>
                    <div class="checklist-item fail"><span>Verificación de goteos</span><span class="status-icon"><i class="bi bi-x-circle-fill text-danger"></i></span></div>
                    <div class="checklist-item ok"><span>Revisión de vibraciones</span><span class="status-icon"><i class="bi bi-check-circle-fill text-success"></i></span></div>
                    <div class="checklist-item ok"><span>Estado del gabinete</span><span class="status-icon"><i class="bi bi-check-circle-fill text-success"></i></span></div>
                </div>
            </section>

            <!-- OBSERVACIONES -->
            <section>
                <h3 class="section-title"><i class="bi bi-chat-left-text"></i>Observaciones y Recomendaciones</h3>
                <div class="info-box">
                    <p>{{observaciones}}</p>
                    <p><i>Se recomienda cambiar el filtro del equipo en el próximo mantenimiento preventivo. Se observa leve corrosión en la base de la unidad condensadora.</i></p>
                </div>
            </section>

            <!-- EVIDENCIA FOTOGRÁFICA -->
            <section>
                <h3 class="section-title"><i class="bi bi-camera"></i>Evidencia Fotográfica</h3>
                <div class="photo-gallery">
                    <!-- {{#each fotos}} -->
                    <div class="photo-item">
                        <img src="{{url_foto}}" alt="{{descripcion}}">
                        <p>{{descripcion}}</p>
                    </div>
                    <!-- {{/each}} -->
                    <!-- Ejemplos -->
                    <div class="photo-item">
                        <img src="https://placehold.co/400x300/cccccc/ffffff?text=Antes" alt="Estado inicial del filtro">
                        <p>Estado inicial del filtro</p>
                    </div>
                    <div class="photo-item">
                        <img src="https://placehold.co/400x300/cccccc/ffffff?text=Después" alt="Filtro limpio">
                        <p>Filtro limpio</p>
                    </div>
                    <div class="photo-item">
                        <img src="https://placehold.co/400x300/cccccc/ffffff?text=Serie" alt="Número de serie del equipo">
                        <p>Número de serie del equipo</p>
                    </div>
                </div>
            </section>

            <!-- FIRMAS -->
            <section>
                <h3 class="section-title"><i class="bi bi-pen"></i>Firmas y Aprobación</h3>
                <div class="row">
                    <div class="col-6">
                        <h5>Firma del Técnico</h5>
                        <div class="signature-box">
                            <img src="{{firma_tecnico_url}}" alt="Firma del Técnico">
                            <div class="signature-line">
                                <span>{{tecnico.nombre_completo}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5>Firma del Cliente</h5>
                        <div class="signature-box">
                            <img src="{{firma_cliente_url}}" alt="Firma del Cliente">
                            <div class="signature-line">
                                <span>{{cliente.contacto_nombre}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <footer class="report-footer">
            <p>{{empresa.razon_social}} - Todos los derechos reservados &copy; 2025</p>
        </footer>
    </div>

</body>
</html>
