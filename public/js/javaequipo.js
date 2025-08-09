
    // Espera a que todo el contenido de la página se cargue
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Conectar el botón a una función
        const addButton = document.getElementById('add-equipo-btn');
        addButton.addEventListener('click', agregarEquipo);

        // Variable para llevar la cuenta de los equipos
        let equipoIndex = 1;

        function agregarEquipo() {
            // El contenedor donde se añadirán los nuevos equipos
            const container = document.getElementById('equipos-container');
            
            // Crear un nuevo div para el formulario del equipo
            const nuevoEquipoDiv = document.createElement('div');
            nuevoEquipoDiv.className = 'equipo-group mb-3'; // Clases para el estilo
            
            // 2. HTML del nuevo formulario. Fíjate que los 'name' coinciden con el original
            // Usamos el 'equipoIndex' para que cada equipo sea único
            nuevoEquipoDiv.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Nuevo Equipo</h6>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarEquipo(this)">Eliminar</button>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Tipo de Equipo</label>
                        <input type="text" class="form-control" name="equipos[${equipoIndex}][tipo_equipo]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marca</label>
                        <input type="text" class="form-control" name="equipos[${equipoIndex}][marca]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Modelo</label>
                        <input type="text" class="form-control" name="equipos[${equipoIndex}][modelo]">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Serie</label>
                        <input type="text" class="form-control" name="equipos[${equipoIndex}][serie]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Refrigerante</label>
                        <input type="text" class="form-control" name="equipos[${equipoIndex}][refrigerante]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Ubicación</label>
                        <input type="text" class="form-control" name="equipos[${equipoIndex}][ubicacion]" required>
                    </div>
                </div>
                <hr class="mt-4">
            `;
            
            // 3. Añadir el nuevo formulario al contenedor
            container.appendChild(nuevoEquipoDiv);
            
            // Incrementar el índice para el próximo equipo
            equipoIndex++;
        }
    });

    // Función para eliminar el formulario de un equipo
    function eliminarEquipo(button) {
        // El botón está dentro del div 'equipo-group', así que lo buscamos y lo eliminamos
        button.closest('.equipo-group').remove();
    }
