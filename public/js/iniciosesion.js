document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');

    // Mantenemos SOLO ESTA definición de showError
    function showError(field, message) {
        if (field) {
            field.classList.add('is-invalid'); // CORREGIDO: classList
            let feedbackElement = field.nextElementSibling;
            // CORREGIDO: classList y contains
            if (!feedbackElement || !feedbackElement.classList.contains('invalid-feedback')) {
                feedbackElement = document.createElement('div');
                feedbackElement.classList.add('invalid-feedback'); // CORREGIDO: classList
                field.parentNode.insertBefore(feedbackElement, field.nextSibling);
            }
            feedbackElement.textContent = message;
        } else {
            // Este alert se usa si 'field' es null, lo cual puede ocurrir para errores generales.
            alert(message);
        }
    }

    function hideError(field) {
        if (field) {
            field.classList.remove('is-invalid'); // CORREGIDO: classList
            let feedbackElement = field.nextElementSibling;
            // CORREGIDO: classList y contains
            if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                feedbackElement.remove();
            }
        }
    }

    if (form) {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            // No es necesario firstErrorField si usamos alert(), pero lo mantenemos por si quieres usarlo para focus.
            let firstErrorField = null; 

            // --- Obtener campos ---
            const rol = form.elements['rol'];
            const email = form.elements['correo']; // CORREGIDO: Usa 'correo' según tu HTML
            const contrasena = form.elements['contrasena'];

            // Ocultar errores previos al revalidar
            hideError(rol);
            hideError(email);
            hideError(contrasena);


            // --- Validaciones ---

            // 1. Rol seleccionado
            if (!rol || rol.value === "rol" || rol.value === "") { // Asegúrate que "rol" sea el valor de tu opción deshabilitada
                showError(rol, ', selecciona tu rol.');
                isValid = false;
                if (!firstErrorField) {
                    firstErrorField = rol;
                }
            }

            // 2. Email no vacío y formato básico
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || email.value.trim() === "") {
                showError(email, 'Por favor, ingresa tu correo electrónico.');
                isValid = false;
                if (!firstErrorField) {
                    firstErrorField = email;
                }
            } else if (!emailPattern.test(email.value.trim())) {
                showError(email, 'Por favor, ingresa un correo electrónico válido.');
                isValid = false;
                if (!firstErrorField) {
                    firstErrorField = email;
                }
            }


            // 3. Contraseña no vacía
            if (!contrasena || contrasena.value.trim() === "") {
                showError(contrasena, 'Por favor, ingresa tu contraseña.');
                isValid = false;
                if (!firstErrorField) {
                    firstErrorField = contrasena;
                }
            }

            // --- Finalizar ---
            if (!isValid) {
                event.preventDefault(); // ¡IMPORTANTE! Detiene el envío si hay errores
                if (firstErrorField) {
                    firstErrorField.focus();
                }
            }
            // Si isValid es true, el formulario se envía al PHP.
        });
    } else {
        console.error("El formulario con id 'loginForm' no se encontró.");
    }
});