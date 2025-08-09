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