function manejarValidacionUI(esValido, $input, mensaje) {
    $input.removeClass('is-valid is-invalid');
    const $feedback = $input.next('.invalid-feedback');

    if (esValido) {
        $input.addClass('is-valid');
        $feedback.text('');
    } else {
        $input.addClass('is-invalid');
        $feedback.text(mensaje);
    }
}

/**
 * Verifica si un valor es un número entero dentro de un rango específico.
 *
 * @param {string|number} value El valor a validar.
 * @param {number} min El valor mínimo permitido (inclusive).
 * @param {number} max El valor máximo permitido (inclusive).
 * @returns {boolean} True si es un entero válido dentro del rango, de lo contrario false.
 */
function validarEntero(valor, min, max) {
    if (valor === null || valor === undefined) return false;
    if (valor.trim() === '') return false; // No validar si está vacío
    const num = Number(valor);
    if (!Number.isInteger(num)) return false; // Debe ser un entero
    if (num < min || num > max) return false; // Debe estar en el rango
    return true;
}

/**
 * Verifica si la longitud de un texto está dentro de un rango específico.
 *
 * @param {string} value El texto a validar.
 * @param {number} minLength La longitud mínima permitida (inclusive).
 * @param {number} maxLength La longitud máxima permitida (inclusive).
 * @returns {boolean} True si la longitud es válida, de lo contrario false.
 */
function validarString(valor, minLength, maxLength) {
    if (typeof valor !== 'string') return false;
    const len = valor.trim().length;
    if (len < minLength || len > maxLength) return false;
    return true;
}

/**
 * Verifica si un valor NO está vacío, nulo o compuesto solo de espacios en blanco.
 *
 * @param {string} value El valor a validar.
 * @returns {boolean} True si el valor tiene contenido, de lo contrario false.
 */
function noEstaVacio(value) {
    if (value === null || typeof value === 'undefined') return false;
    return value.trim().length > 0;
}

/**
 * Verifica si una fecha en formato 'YYYY-MM-DD' es válida y está dentro de un rango.
 *
 * @param {string} fechaString La fecha a validar (formato 'YYYY-MM-DD').
 * @param {string} minfechaString La fecha mínima permitida (formato 'YYYY-MM-DD').
 * @param {string} maxDateString La fecha máxima permitida (formato 'YYYY-MM-DD').
 * @returns {boolean} True si la fecha es válida y está en el rango, de lo contrario false.
 */
function validarFecha(fechaString, minFechaString, maxFechaString = null) {
    // 1. Crear las fechas base con ajuste de zona horaria (T00:00:00)
    const fecha = new Date(fechaString + 'T00:00:00');
    const minfecha = new Date(minFechaString + 'T00:00:00');

    // 2. Comprobar si las fechas base son válidas
    if (isNaN(fecha.getTime()) || isNaN(minfecha.getTime())) {
        return false;
    }

    // 3. Comprobar la fecha mínima (esto es obligatorio)
    if (fecha < minfecha) {
        return false;
    }

    // 4. Comprobar la fecha máxima (solo si maxFechaString NO es null/undefined/vacío)
    if (maxFechaString) { // Esto es true si se pasó un valor (una string de fecha)
        const maxfecha = new Date(maxFechaString + 'T00:00:00');
        
        // Comprobar si la fecha máxima proporcionada es válida
        if (isNaN(maxfecha.getTime())) {
            // Podrías decidir qué hacer aquí: si es inválida, se valida como falsa.
            return false;
        }

        // Comprobar si la fecha es mayor que la máxima
        if (fecha > maxfecha) {
            return false;
        }
    }

    // Si pasó todas las comprobaciones
    return true;
}