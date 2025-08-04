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
        button.addEventListener('click', () => { //
            if (currentStep > 0) { //
                currentStep--; //
                updateSteps(); //
            }
        }); //
    }); //

    // Manejar el envío final del formulario
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // IMPORTANTE: Mantenemos esto para controlar el envío con JS

        // Validación final del último paso (ya la tienes, solo la reafirmo)
        const lastStepRequiredInputs = steps[currentStep].querySelectorAll('[required]'); //
        let lastStepValid = true; //
        lastStepRequiredInputs.forEach(input => { //
            if (!input.value.trim()) { //
                input.classList.add('is-invalid'); //
                lastStepValid = false; //
            } else { //
                input.classList.remove('is-invalid'); //
            }
        }); //

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
