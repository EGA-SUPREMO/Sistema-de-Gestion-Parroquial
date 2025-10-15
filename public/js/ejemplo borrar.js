$(document).ready(function() {
    
    // Función auxiliar para mostrar/ocultar errores
    function handleValidationUI(isValid, $input, message) {
        $input.removeClass('is-valid is-invalid');
        const $feedback = $input.next('.invalid-feedback');

        if (isValid) {
            $input.addClass('is-valid');
            $feedback.text('');
        } else {
            $input.addClass('is-invalid');
            $feedback.text(message);
        }
    }

    // --- Validación para Nombre de Usuario (String) ---
    $('#username').on('keyup', function() {
        const $this = $(this);
        const value = $this.val();
        const isValid = validateString(value, 3, 15);
        handleValidationUI(isValid, $this, 'El usuario debe tener entre 3 y 15 caracteres.');
    });

    // --- Validación para Edad (Integer) ---
    $('#age').on('keyup', function() {
        const $this = $(this);
        const value = $this.val();
        const isValid = validateInteger(value, 18, 99);
        handleValidationUI(isValid, $this, 'La edad debe ser un número entre 18 y 99.');
    });

    // --- Validación para Fecha de Nacimiento (Date) ---
    // Usamos 'change' para fechas, ya que 'keyup' no siempre funciona bien
    $('#birthdate').on('change', function() {
        const $this = $(this);
        const value = $this.val(); // El input type="date" ya da el formato YYYY-MM-DD
        const isValid = validateDate(value, '1950-01-01', '2010-12-31');
        handleValidationUI(isValid, $this, 'La fecha debe estar entre 1950 y 2010.');
    });
    
    // --- Validación para Comentarios (NotEmpty) ---
    $('#comments').on('keyup', function() {
        const $this = $(this);
        const value = $this.val();
        const isValid = isNotEmpty(value);
        handleValidationUI(isValid, $this, 'Este campo es obligatorio.');
    });

}); 
