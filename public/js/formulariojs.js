// script.js
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formularioReporte');
    const steps = document.querySelectorAll('.step');
    let currentStep = 0; // El índice del paso actual (0-indexed)

    // Mostrar el primer paso al cargar la página
    steps[currentStep].classList.add('active'); //

    // Función para actualizar la visibilidad de los pasos
    function updateSteps() { //
        steps.forEach((step, index) => { //
            if (index === currentStep) { //
                step.classList.add('active'); // Muestra el paso actual
            } else { //
                step.classList.remove('active'); // Oculta los demás
            }
        }); //
    }

    // Manejar clics en el botón "Siguiente"
    form.querySelectorAll('.next-btn').forEach(button => { //
        button.addEventListener('click', () => { //
            // Validación básica para campos requeridos en el paso actual
            let requiredInputs = steps[currentStep].querySelectorAll('[required]'); //
        
            let allFieldsValid = true; //

            requiredInputs.forEach(input => { //
                // Elimina espacios en blanco para la validación
                if (!input.value.trim()) { //
                    input.classList.add('is-invalid'); // Clase de Bootstrap para indicar error
                    allFieldsValid = false; //
                } else { //
                    input.classList.remove('is-invalid'); //
                }
            }); //

            if (!allFieldsValid) { //
                alert('Por favor, completa todos los campos requeridos antes de avanzar.'); //
                return; // Detiene la función si hay campos incompletos
            }

            // Si la validación es exitosa y no es el último paso
            if (currentStep < steps.length - 1) { //
                currentStep++; //
                updateSteps(); //
            }
        }); //
    }); //

    // Manejar clics en el botón "Anterior"
    form.querySelectorAll('.prev-btn').forEach(button => { //
        button.addEventListener('click', () => { 
            let allFieldsValid = true; // Variable para rastrear la validez

        // IMPORTANTE: Asumiendo que el paso de "Datos del equipo" es el segundo (índice 1)
        // Si es otro paso, cambia el número (ej. si es el tercer paso, usa currentStep === 2)
        if (currentStep === 1) { 
            const equipos = steps[currentStep].querySelectorAll('.equipo-group');
            
            // Si no hay ningún formulario de equipo, el paso es válido
            if (equipos.length === 0) {
                allFieldsValid = true;
            } else {
                // Itera sobre cada grupo de equipo por separado
                for (const equipo of equipos) {
                    const inputsRequeridosDelGrupo = equipo.querySelectorAll('[required]');
                    for (const input of inputsRequeridosDelGrupo) {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            allFieldsValid = false; // Si un solo input falla, todo el paso falla
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    }
                }
            }
        }else {
            // --- Lógica de validación ORIGINAL para los demás pasos ---
            let requiredInputs = steps[currentStep].querySelectorAll('[required]');
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    allFieldsValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
        }



        if (!lastStepValid) {
            alert('Por favor, completa todos los campos requeridos antes de finalizar el reporte.');
            return; // Detiene el envío si el último paso no es válido
        }

        // Si todos los pasos son válidos, procede con el envío AJAX
        const formData = new FormData(form); // Recopila todos los datos del formulario
        
        fetch(form.action, { // Envía al 'action' del formulario
            method: form.method, // Usa el método 'post' del formulario
            body: formData // Envía los datos como FormData
        })
       
        .then(data => {
            // Manejo de la respuesta exitosa del servidor
            console.log('Respuesta del servidor:', data);
            alert('¡Reporte guardado con éxito!');

            window.location.href = '?url=informes'; //
        })
        .catch(error => { // Corregido 'Error' a 'error'
            // Manejo de errores (red, servidor, JSON parsing, etc.)
            console.error('Error al enviar el formulario:', error);
            alert('Hubo un error al guardar el reporte: ' + error.message);
        });


    });
});
