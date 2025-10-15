/**
 * Verifica si un valor es un número entero dentro de un rango específico.
 *
 * @param {string|number} value El valor a validar.
 * @param {number} min El valor mínimo permitido (inclusive).
 * @param {number} max El valor máximo permitido (inclusive).
 * @returns {boolean} True si es un entero válido dentro del rango, de lo contrario false.
 */
function validarEntero(valor, min, max) {
    const num = Number(valor);
    if (valor === null || valor.trim() === '') return false; // No validar si está vacío
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
function validarFecha(fechaString, minFechaString, maxFechaString) {
    const fecha = new Date(fechaString + 'T00:00:00'); // Añadir T00:00:00 para evitar problemas de zona horaria
    const minfecha = new Date(minFechaString + 'T00:00:00');
    const maxfecha = new Date(maxFechaString + 'T00:00:00');

    // Comprueba si las fechas son válidas (e.g., no '2025-02-30')
    if (isNaN(fecha.getTime()) || isNaN(minfecha.getTime()) || isNaN(maxfecha.getTime())) {
        return false;
    }

    if (fecha < minfecha || fecha > maxfecha) return false;
    return true;
} 
