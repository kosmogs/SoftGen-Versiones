<div class="step" id="step2">
            <h5 class="mb-3">2.Datos del equipo</h5>
            <div id="equipos-container">
                <div class="equipo-group mb-3">
                    <div class="row">
                        <div class="col-md-4"><label class="form-label">Tipo de Equipo</label><input type="text" class="form-control" name="equipos[0][tipo_equipo]" required></div>
                        <div class="col-md-4"><label class="form-label">Marca</label><input type="text" class="form-control" name="equipos[0][marca]" required></div>
                        <div class="col-md-4"><label class="form-label">Modelo</label><input type="text" class="form-control" name="equipos[0][modelo]"></div>  
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label class="form-label">Serie</label><input type="text" class="form-control" name="equipos[0][serie]" required></div>
                        <div class="col-md-4"><label class="form-label">Refrigerante</label><input type="text" class="form-control" name="equipos[0][refrigerante]" required></div>
                        <div class="col-md-4"><label class="form-label">Ubicación</label><input type="text" class="form-control" name="equipos[0][ubicacion]" required></div>
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
</div>