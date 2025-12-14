function validarCampo($elemento, funcionDeValidacion, mensajeDeError) {
    const valor = $elemento.val();
    const esRequerido = $elemento.prop('required');

    if (!esRequerido && valor.trim() === '') {
        manejarValidacionUI(true, $elemento, '');
        return;
    }

    const esValido = funcionDeValidacion(valor);
    manejarValidacionUI(esValido, $elemento, mensajeDeError);
}

function validarNombre($elemento) {
    validarCampo(
        $elemento,
        (valor) => validarString(valor, 2, 50),
        'El campo debe tener entre 2 y 50 caracteres.'
    );
}

function validarNombreUsuario($elemento) {
    validarCampo(
        $elemento,
        (valor) => validarString(valor, 3, 30),
        'El campo debe tener entre 3 y 30 caracteres.'
    );
}

function validarContrasena($elemento) {
    validarCampo(
        $elemento,
        (valor) => validarString(valor, 6, 32),
        'El campo debe tener entre 6 y 32 caracteres.'
    );
}

function validarNombrePadrino($elemento) {
    validarCampo(
        $elemento,
        (valor) => validarString(valor, 2, 100),
        'El campo debe tener entre 2 y 100 caracteres.'
    );
}

function validarPartidaDeNacimiento($elemento) {
    validarCampo(
        $elemento,
        (valor) => validarString(valor, 4, 30),
        'El campo debe tener entre 4 y 30 caracteres.'
    );
}

function validarLugar($elemento) {
    validarCampo(
        $elemento,
        (valor) => validarString(valor, 4, 50),
        'El campo debe tener entre 4 y 50 caracteres.'
    );
}

function validarCedula($elemento) {
    validarCampo(
        $elemento,
        (valor) => validarEntero(valor, 1000, 100000000),
        'El campo debe ser entre 1 000 y 100 000 000.'
    );
}

function validarFechaNacimiento($elemento) {
    const fechaActual = new Date().toISOString().slice(0, 10);
    const mensaje = `La fecha debe ser entre 1900-01-01 y ${fechaActual}.`;
    validarCampo(
        $elemento,
        (valor) => validarFecha(valor, "1900-01-01", fechaActual),
        mensaje
    );
}

function validarFechaConstanciaSuceso($elemento) {
    const fechaActual = new Date().toISOString().slice(0, 10);
    const mensaje = `La fecha debe ser entre 1900-01-01 y ${fechaActual}.`;
    validarCampo(
        $elemento,
        (valor) => validarFecha(valor, "1900-01-01", fechaActual),
        mensaje
    );
}

function validarFechaExpedicion($elemento) {
     validarCampo(
        $elemento,
        (valor) => validarFecha(valor, "1900-01-01"),
        'La fecha debe ser a partir de 1900-01-01.'
    );
}

function validarFechaIntencion($elemento) {
    let $fecha_inicio = $(`[name="fecha_inicio"]`);
    let $fecha_fin = $(`[name="fecha_fin"]`);

    const hoy = new Date();
    const fechaMax = new Date();
    fechaMax.setFullYear(hoy.getFullYear() + 1);
    
    const maxStr = fechaMax.toISOString().slice(0, 10);
    const minStr = "1900-01-01";

    validarCampo($elemento, (valor) => {
        const esRangoValido = validarFecha(valor, minStr, maxStr);
        if (!esRangoValido) {
            $elemento.data('error-msg', `La fecha debe estar entre ${minStr} y ${maxStr}`);
            return false;
        }

        const valInicio = $fecha_inicio.val();
        const valFin = $fecha_fin.val();
        
        if (valInicio && valFin && valInicio > valFin) {
            $elemento.data('error-msg', `La fecha de inicio no puede ser mayor a la final.`);
            return false;
        }

        return true;
    }, $elemento.data('error-msg')); 
}

function validarEnteroLibro($elemento) {
    const valor = $elemento.val();
    const esValido = validarEntero(valor, 1, 1000);
    manejarValidacionUI(esValido, $elemento, 'El campo debe ser entre 1 y 1 000.');
}

function validarLista($elemento) {
    const esRequerido = $elemento.prop('required');

    validarCampo(
        $elemento,
        (valor) => {
            if (!esRequerido && (valor === '0' || valor === '' || valor === null)) {
                return true;
            }
            return valor !== null && valor !== '' && valor !== '0';
        },
        'Debe seleccionar una opción de la lista.'
    );
}

function soloNumero(e) {
    const charCode = (e.which) ? e.which : e.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        e.preventDefault();
        return false;
    }
}

function consultarMisasPorRango() {
    let $fecha_inicio = $(`[name="fecha_inicio"]`);
    let $fecha_fin = $(`[name="fecha_fin"]`);
    validarFechaIntencion($fecha_inicio);
    validarFechaIntencion($fecha_fin);
    
    let datos = {
        'fecha_inicio': $fecha_inicio.val(),
        'fecha_fin': $fecha_fin.val(),
        'metodo': 'consultarOCrearMisas',
    };
    
    if ($fecha_inicio.hasClass('is-invalid') || $fecha_inicio.val() === '' || $fecha_fin.hasClass('is-invalid') || $fecha_fin.val() === '') {
        return;
    }

    pedirDatos(JSON.stringify(datos), manejarRespuestaMisas, "modelo/intenciones.php")
}

// Variable global o fuera de la función para almacenar todas las misas recibidas
// Esto es útil para el paso final de "Guardar"
let misasDisponibles = [];

/**
 * Maneja la respuesta AJAX del servidor, agrupa las misas y renderiza
 * las opciones de asignación en el formulario.
 * @param {object} response - El objeto JSON devuelto por el servidor.
 */
function manejarRespuestaMisas(response) {
    // 1. Verificar el estado y obtener la lista de misas
    if (!response || response.length === 0) {
        $('#misas_selecionadas').html('<p class="text-danger">No se encontraron misas disponibles en el rango seleccionado.</p>');
        misasDisponibles = [];
        return;
    }

    misasDisponibles = response;
    const $contenedor = $('#misas_selecionadas');
    $contenedor.empty(); // Limpiar el contenedor anterior

    const numDiasSeleccionados = obtenerNumDias(misasDisponibles);
    let htmlOpciones = '';
    console.log(numDiasSeleccionados);
    // === Lógica de Agrupación (Paso JIT Inteligente) ===

    if (numDiasSeleccionados === 1) {
        // --- Caso 1: Un solo día (Mostramos cada misa individualmente) ---
        htmlOpciones += '<h4>Misas del día:</h4>';
        misasDisponibles.forEach(misa => {
            // El valor del checkbox será el ID de la Misa
            htmlOpciones += `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="misa_ids[]" value="${misa.id}" id="misa_${misa.id}">
                    <label class="form-check-label" for="misa_${misa.id}">
                        ${misa.dia_semana}, ${misa.hora_formato} (${misa.lugar || 'Principal'})
                    </label>
                </div>
            `;
        });
    } else {
        // --- Caso 2: Múltiples días (Agrupamos por patrón de hora) ---

        // A. Agrupación: { "07:00 PM": [misa1, misa2, ...], "08:00 AM": [...] }
        const misasAgrupadas = agruparPorPatron(misasDisponibles);
        let opcionMasFrecuente = null;
        let maxFrecuencia = -1;

        // B. Generar HTML para los patrones
        htmlOpciones += `<h6>Misas disponibles para el periodo seleccionado (${numDiasSeleccionados} días):</h6>`;
        
        for (const hora in misasAgrupadas) {
            const count = misasAgrupadas[hora].length;
            const ids = misasAgrupadas[hora].map(m => m.id).join(','); // IDs para el valor
            const idLimpio = limpiarParaID(hora);
            // Detectar la opción más frecuente (para preselección)
            if (count > maxFrecuencia) {
                maxFrecuencia = count;
                opcionMasFrecuente = hora;
            }
            
            // Generar Checkbox para el Patrón
            htmlOpciones += `
                <div class="form-check">
                    <input class="form-check-input patron-misa" type="checkbox" name="misa_ids[]" value="${ids}" id="patron_${idLimpio}">
                    <label class="form-check-label" for="patron_${idLimpio}">
                        Misa de ${hora} (${count} misas encontradas en el rango)
                    </label>
                </div>
            `;
        }

        // C. Opción "Asignar a todas las misas disponibles" (Total)
        const todosLosIDs = misasDisponibles.map(m => m.id).join(',');
        const esMasFrecuente = (misasDisponibles.length > maxFrecuencia) ? '' : 'checked'; // Raramente será la más frecuente
        
        htmlOpciones += `
            <hr>
            <div class="form-check">
                <input class="form-check-input patron-misa" type="checkbox" name="misa_ids[]" value="${todosLosIDs}" id="patron_todas" ${esMasFrecuente}>
                <label class="form-check-label" for="patron_todas">
                    Asignar a <b>TODAS</b> las misas disponibles (${misasDisponibles.length} misas)
                </label>
            </div>
            <hr>
        `;
        $contenedor.html(htmlOpciones);
        
        // D. Aplicar preselección de la opción más frecuente (¡CERO FRICCIÓN!)
        if (opcionMasFrecuente) {
             // Marcamos el patrón más común
            const idLimpioFrecuente = limpiarParaID(opcionMasFrecuente);
            console.log(`#patron_${idLimpioFrecuente}`);
            $contenedor.find(`#patron_${idLimpioFrecuente}`).prop('checked', true);
        }
    }

    //$contenedor.html(htmlOpciones);

    // Adjuntar evento: solo se puede seleccionar una opción de asignación de patrón
    $contenedor.on('change', '.patron-misa', function() {
        if ($(this).is(':checked')) {
            // Desmarcar todos los demás patrones
            $contenedor.find('.patron-misa').not(this).prop('checked', false);
        }
    });

}

/**
 * Función auxiliar para agrupar misas por su hora_formato.
 * @param {Array} misas - Lista de objetos misa.
 * @returns {object} Objeto con la hora como clave y un array de misas como valor.
 */
function agruparPorPatron(misas) {
    return misas.reduce((acc, misa) => {
        const hora = misa.hora_formato;
        if (!acc[hora]) {
            acc[hora] = [];
        }
        acc[hora].push(misa);
        return acc;
    }, {});
}

/**
 * Función auxiliar para obtener el número de días únicos.
 * Esto diferencia si es un día o varios.
 * @param {Array} misas - Lista de objetos misa.
 * @returns {number} Número de días únicos.
 */
function obtenerNumDias(misas) {
    // Usamos un Set para obtener solo las fechas únicas (ej. '2025-11-15')
    const fechasUnicas = new Set(misas.map(misa => misa.fecha_hora.split(' ')[0]));
    return fechasUnicas.size;
}

function limpiarParaID(str) {
    // Reemplaza ":" y espacios por "_" y elimina puntos
    return str.replace(/[:\s\.]/g, '_');
}
// ====================================================================
// NOTA SOBRE EL PASO FINAL DE GUARDADO (Backend)
// ====================================================================

// Al presionar [Guardar], el valor del checkbox marcado (el patrón) será una cadena 
// de IDs separados por comas. Tu backend debe manejar esto:
/*
// En el backend (PHP):
$misaIdsCadena = $_POST['misa_ids'][0]; // Obtener la cadena del único checkbox marcado
$misaIdsArray = explode(',', $misaIdsCadena); // Convertir a array de IDs
// Luego, iteras sobre $misaIdsArray para crear los registros en peticion_misa
*/















function manejarBusquedaDirecta(respuesta) {
    const datosPersona = respuesta['feligres-'] || respuesta; // Ajusta según tu JSON
    
    if (datosPersona && datosPersona.nombre_completo) {
        
        solicitarConfirmacionSimple(
            "Persona encontrada",
            `Se encontró a: ${datosPersona.nombre_completo}. ¿Desea cargar sus datos?`,
            () => {
                completarCampos(respuesta); 
                Swal.fire("Cargado", "Formulario autocompletado.", "success");
            }
        );
        
    } else {
        Swal.fire("Sin resultados", "No se encontró ninguna persona.", "warning");
    }
}


function manejarHijos(hijos, datosPadreOriginales) {
    if (!hijos || Object.keys(hijos).length === 0) return;

    const opciones = {};
    Object.keys(hijos).forEach(key => {
        const hijo = hijos[key];
        const nombreCompleto = [
            hijo['feligres-'].primer_nombre,
            hijo['feligres-'].segundo_nombre,
            hijo['feligres-'].primer_apellido,
            hijo['feligres-'].segundo_apellido
        ]
        .filter(Boolean)
        .join(' ');
        opciones[key] = `${hijo['feligres-'].cedula} - ${nombreCompleto}`; 
    });

    solicitarSeleccionDeOpcion(
        "Hijos encontrados", 
        opciones, 
        (keySeleccionada) => {
            const hijoSeleccionado = hijos[keySeleccionada];
            const datosFinales = {
                ...datosPadreOriginales,
                ...hijoSeleccionado
            };

            rellenarFormularioConDatos(datosFinales);
            Swal.fire("¡Listo!", "Datos del hijo y constancia cargados.", "success");
        },
        () => {
            const datosEntidadPrincipal = datosPadreOriginales['feligres-'] || datosPadreOriginales['padre-'] || datosPadreOriginales['madre-'] || datosPadreOriginales['padre_1-'] || datosPadreOriginales['padre_2-'] || datosPadreOriginales['contrayente_1-'] || datosPadreOriginales['contrayente_2-'] || datosPadreOriginales['constancia-'] || datosPadreOriginales[''];

            const nombreCompleto = [
                datosEntidadPrincipal.primer_nombre,
                datosEntidadPrincipal.segundo_nombre,
                datosEntidadPrincipal.primer_apellido,
                datosEntidadPrincipal.segundo_apellido
            ]
            .filter(Boolean)
            .join(' ');
            
            const identificador = datosEntidadPrincipal.cedula ? `C.I. ${datosEntidadPrincipal.cedula}` : `ID ${datosEntidadPrincipal.id}`;
            
            // 3. Llamar a la confirmación simple
            solicitarConfirmacionSimple(
                "Datos Encontrados",
                `Se encontró información para ${nombreCompleto} (${identificador}), ¿Desea autocompletar el formulario con esta información?`,
                () => {
                    rellenarFormularioConDatos(datosPadreOriginales); 
                    Swal.fire("Éxito", "Datos cargados al formulario.", "success");
                }
            );
        }
    );
}

/**
 * Muestra un modal con un select para elegir entre varias opciones.
 * @param {string} titulo - Título del modal.
 * @param {object} opcionesMap - Objeto { "id": "Texto a mostrar" }.
 * @param {function} onSeleccion - Callback que recibe la key seleccionada.
 */
function solicitarSeleccionDeOpcion(titulo, opcionesMap, onSeleccion, onCancelar = null) {
    const NO_USAR_KEY = "none";
    const opcionesFinales = { ...opcionesMap };
    opcionesFinales[NO_USAR_KEY] = "No usar ninguno";

    Swal.fire({
        title: titulo,
        text: "Seleccione un registro para autocompletar.",
        input: 'select',
        inputOptions: opcionesFinales,
        showCancelButton: true,
        confirmButtonText: "Seleccionar",
        cancelButtonText: "Cerrar",
        inputValidator: (value) => {
            return !value && 'Debe seleccionar una opción';
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value === NO_USAR_KEY) {
                Swal.fire("Operación omitida", "No se cargaron datos.", "info");
                onCancelar(result.value);
            } else {
                onSeleccion(result.value);
            }
        }
    });
}

/**
 * Muestra una confirmación simple Sí/No para un solo registro.
 * @param {string} titulo - Título (ej: "Persona encontrada").
 * @param {string} texto - Detalles (ej: "Se encontró a Juan Perez. ¿Usar datos?").
 * @param {function} onConfirmar - Callback si el usuario dice SÍ.
 */
function solicitarConfirmacionSimple(titulo, texto, onConfirmar) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: "Sí, autocompletar",
        cancelButtonText: "No, ignorar",
    }).then((result) => {
        if (result.isConfirmed) {
            onConfirmar();
        } else {
            Swal.fire("Operación cancelada", "No se cargaron datos.", "info");
        }
    });
}


function completarCampos(datos) {
    if (datos.hijos && Object.keys(datos.hijos).length > 0) {
        const datosOriginales = {};
        for (const key in datos) {
            if (key !== 'hijos') {
                datosOriginales[key] = datos[key];
            }
        }
        manejarHijos(datos.hijos, datosOriginales);
        return;
    }

    // --- Si no hay hijos, procedemos a la Confirmación Simple ---
    
    if (datos[''].id == $('#id')[0].value && $('#id')[0].value != 0) {
        return;
    }

    const datosEntidadPrincipal = datos['feligres-'] || datos['padre-'] || datos['madre-'] || datos['padre_1-'] || datos['padre_2-'] || datos['contrayente_1-'] || datos['contrayente_2-'] || datos['constancia-'] || datos[''];
    
    if (datosEntidadPrincipal && (datosEntidadPrincipal.cedula || datosEntidadPrincipal.id)) {
        
        // Intentar construir el nombre completo para el mensaje
        const nombreCompleto = [
            datosEntidadPrincipal.primer_nombre,
            datosEntidadPrincipal.segundo_nombre,
            datosEntidadPrincipal.primer_apellido,
            datosEntidadPrincipal.segundo_apellido
        ]
        .filter(Boolean)
        .join(' ');
        
        const identificador = datosEntidadPrincipal.cedula ? `C.I. ${datosEntidadPrincipal.cedula}` : `ID ${datosEntidadPrincipal.id}`;
        
        // 3. Llamar a la confirmación simple
        solicitarConfirmacionSimple(
            "Datos Encontrados",
            `Se encontró información para ${nombreCompleto} (${identificador}). ¿Desea autocompletar el formulario con esta información?`,
            () => {
                rellenarFormularioConDatos(datos); 
                Swal.fire("Éxito", "Datos cargados al formulario.", "success");
            }
        );
        return;
    }

    Swal.fire("Sin resultados", "No se encontraron datos para autocompletar.", "info");
}

/**
 * Rellena los campos del formulario con los datos estructurados de la respuesta del servidor.
 * @param {object} datosRespuesta - Objeto JS que contiene las claves 'padre-', 'madre-', 'constancia-', etc.
 */
function rellenarFormularioConDatos(datosRespuesta) {
    const clavesAExcluir = ['hijos']; 

    Object.keys(datosRespuesta).forEach(prefijo => {
        if (clavesAExcluir.includes(prefijo)) {
            return;
        }

        const objetoDatos = datosRespuesta[prefijo];

        if (objetoDatos && typeof objetoDatos === 'object' && !Array.isArray(objetoDatos)) {
            for (const key in objetoDatos) {
                if (objetoDatos.hasOwnProperty(key)) {
                    const valor = objetoDatos[key];
                    const nombreCampo = `${prefijo}${key}`;
                    
                    const $input = $(`[name="${nombreCampo}"]`);
                    if ($input.length) {
                        $input.val(valor);

                        $input.trigger('keyup').trigger('change'); 
                    }
                }
            }
        }
    });
}


function pedirDatos(datos, callback, rutaPHP = "modelo/formulario.php") {
    $.post(rutaPHP, { json: datos }, function(resultado) {
        console.log("Respuesta del servidor (Objeto JS):", resultado); 
        if (resultado) {
            callback(resultado);
        }
    }, 'json')
    .fail(function(xhr, status, error) {
        console.log("Error en la respuesta del servidor (Objeto JS):", xhr);
    });
}

function autocompletarCampo($elemento) {
    if ($elemento.hasClass('is-invalid') || $elemento.val() === '') {
        return;
    }
    const valorIdentificador = $elemento.val();

    const nombreCompleto = $elemento.attr('name');    
    const partes = nombreCompleto.split('-'); 

    let prefijo = '';
    let claveIdentificador = nombreCompleto;
    
    if (partes.length > 1) { 
        prefijo = partes[0] + '-';   
        claveIdentificador = partes.slice(1).join('-'); 
    } 

    let datos = {};
    const claveDinamica = `${prefijo}${claveIdentificador}`; 
    datos[claveDinamica] = valorIdentificador;
    datos['nombre_tabla'] = new URLSearchParams(window.location.search).get('t');

    pedirDatos(JSON.stringify(datos), completarCampos);
}

function autocompletarSujetoSacramento($elemento) {
    if ($elemento.hasClass('is-invalid') || $elemento.val() === '') {
        return;
    }
    let datos = {};
    datos[$elemento.attr('name')] = $elemento.val(); 
    datos['nombre_tabla'] = new URLSearchParams(window.location.search).get('t');

    pedirDatos(JSON.stringify(datos), completarCampos);
}

function autocompletarMatrimonio($elemento) {
    if ($elemento.hasClass('is-invalid') || $elemento.val() === '') {
        return;
    }
    let datos = {};
    datos['contrayente_1-cedula'] = $(`[name="contrayente_1-cedula"]`).val(); 
    datos['contrayente_2-cedula'] = $(`[name="contrayente_2-cedula"]`).val(); 
    datos['nombre_tabla'] = new URLSearchParams(window.location.search).get('t');

    pedirDatos(JSON.stringify(datos), completarCampos);
}

function autocompletarConstanciaLibro($elemento) {
    let datos = {
        'constancia-numero_libro': $(`[name="constancia-numero_libro"]`).val(),
        'constancia-numero_pagina': $(`[name="constancia-numero_pagina"]`).val(),
        'constancia-numero_marginal': $(`[name="constancia-numero_marginal"]`).val(),
        'nombre_tabla': new URLSearchParams(window.location.search).get('t')
    };

    if (+datos['constancia-numero_libro'] && +datos['constancia-numero_pagina'] && +datos['constancia-numero_marginal']) {
        pedirDatos(JSON.stringify(datos), completarCampos);
    }
}









/**
 * Asigna atributos comunes (required, value, pattern, etc.) a un elemento del formulario.
 * @param {jQuery} $element - El elemento de jQuery al que se le asignarán los atributos.
 * @param {object} properties - El objeto de definición del campo.
 * @returns {jQuery} El mismo elemento para permitir encadenamiento.
 */
function asignarAtributosComunes($element, properties) {
    const atributos = {
        'value': properties.value,
        'placeholder': properties.placeholder,
        'maxlength': properties.maxlength,
        'pattern': properties.pattern,
    };

    // Asignar atributos solo si existen en la definición
    for (const attr in atributos) {
        if (atributos[attr]) {
            $element.attr(attr, atributos[attr]);
        }
    }
    
    // Asignar propiedades como 'required' y 'selected'
    if (properties.required) {
        $element.prop('required', true);
    }
    
    // Para selects, selecciona el valor correcto
    if (properties.type === 'select' && properties.value) {
        $element.val(properties.value);
    }
    if (properties.type === 'hidden') {
        $element.on('change', function() {
            const $tituloFormulario = $('#titulo-formulario');
            const valorHidden = $(this).val(); 
            const textoBase = $tituloFormulario.text().replace(/^(Registrar|Editar)\s+/, ''); 
            
            console.log(textoBase);
            let nuevoPrefijo = '';
            if (valorHidden === '0' || valorHidden === 0) {
                nuevoPrefijo = 'Registrar ';
            } else {
                nuevoPrefijo = 'Editar ';
            }

            const url = new URL(window.location.href);
            url.searchParams.set('id', valorHidden);
            window.history.replaceState(null, '', url.toString());

            $tituloFormulario.text(nuevoPrefijo + textoBase);
        });
    }

    if (properties.autocompletarMetodo) {
        $element.on('focusout', function() {// TODO que gemini me explice esto
            // Llamamos a la función. 'this' dentro de la función se referirá al input.
            window[properties.autocompletarMetodo].call(null, $element);
        });
    }
    if (properties.validarMetodo) {
        $element.on('keyup input focusout focusin', function() {
            window[properties.validarMetodo].call(null, $element);
        });
    }
    if (properties.keypress) {
        $element.on('keypress', function(e) {
            window[properties.keypress].call(null, e, $element);
        });
    }
    if (properties.change) {
        $element.on('change', function(e) {
            window[properties.change].call(null, e, $element);
        });
    }

    return $element;
}

// Objeto que contiene funciones para crear cada tipo de campo.
const creadoresDeCampos = {
    crearInput: function(prop) {
        const $input = $('<input>').attr({
            type: prop.type,
            name: prop.name,
            id: prop.name,
            class: 'form-control'
        });
        return asignarAtributosComunes($input, prop);
    },
    
    crearSelect: function(prop) {
        const $select = $('<select>').attr({
            name: prop.name,
            id: prop.name,
            class: 'form-control'
        });
        
        prop.options.forEach((option, index) => {
            const $option = $('<option>').val(option.value).text(option.text);

            if (prop.value === option.value || (!prop.value && index === 0)) {
                $option.attr('selected', 'selected');
            }

            if (option.disabled) {
                $option.prop('disabled', true);
            }
            $select.append($option);
        });
        $select.on('change', function() {
            validarLista($(this));
        });
        return asignarAtributosComunes($select, prop);
    },
    crearCheckboxes: function(prop) {
        const $contenedor = $('<div>').addClass('checkbox-group').attr('name', prop.name).attr('id', prop.name);
        const selectedValues = Array.isArray(prop.value) ? prop.value : [];
        prop.options.forEach((option) => {
            const $formCheck = $('<div>').addClass('form-check');
            const inputId = `${prop.name}_${option.value}`; 
            
            // 3. Crear el input (checkbox)
            const $input = $('<input>').attr({
                type: 'checkbox',
                name: `${prop.name}[]`, // Nombre del array para que PHP reciba múltiples valores
                value: option.value,
                id: inputId,
                class: 'form-check-input'
            });

            // 4. Determinar si debe estar marcado (checked)
            // Comprobar si el valor de la opción está en el array de valores seleccionados
            if (selectedValues.includes(option.value)) {
                $input.prop('checked', true);
            }
            
            // 5. Crear la etiqueta (label)
            const $label = $('<label>').attr({
                class: 'form-check-label',
                for: inputId
            }).text(option.text);

            // Manejar el estado deshabilitado (disabled)
            if (option.disabled) {
                $input.prop('disabled', true);
            }

            // 6. Ensamblar: Input y Label dentro del Contenedor individual
            $formCheck.append($input, $label);
            
            // 7. Agregar el elemento individual al contenedor principal
            $contenedor.append($formCheck);
        });

        // 8. Agregar evento de validación al grupo de checkboxes (opcional)
        // El evento 'change' se adjunta a todos los inputs dentro del contenedor
        $contenedor.find('.form-check-input').on('change', function() {
            // Aquí debe definir qué es 'validarLista' para checkboxes
            // Puede que necesite validar todo el grupo $contenedor
            // Ejemplo: validarGrupo($(this).closest('.checkbox-group'));
        });
        
        // 9. Asignar atributos comunes y devolver
        // Asumiendo que esta función existe en su alcance (como en su ejemplo crearSelect)
        return asignarAtributosComunes($contenedor, prop);
    },

    crearTextarea: function(prop) {
        const $textarea = $('<textarea>').attr({
            name: prop.name,
            id: prop.name,
            class: 'form-control',
            rows: 4
        });
        return asignarAtributosComunes($textarea, prop);
    },

    crearSubtitulo: function(prop) {
        return $('<h4>').attr({
            name: prop.name,
            id: prop.name,
            class: 'mt-4 mb-3'
        }).html(prop.value);
    },

    crearAutocomplete: function(prop) {
        // 1. Crear el elemento <input> base (es el mismo que crearInput, pero con type='text' implícito).
        const $input = $('<input>').attr({
            type: 'text',
            name: prop.name,
            id: prop.name,
            class: 'form-control'
        });

        if (typeof $.fn.autocomplete === 'function' && Array.isArray(prop.sugerencias)) {
            $input.autocomplete({
                source: prop.sugerencias,
                select: function(event, ui) {
                    // 1. Asigna el valor seleccionado al campo de entrada.
                    //    (Aunque jQuery UI lo hace por defecto, es buena práctica)
                    $(this).val(ui.item.value);
                    
                    // 2. FORZAR el evento que activa tu validación
                    //    Si tu validación se activa con keyup (lo más común):
                    $(this).trigger('keyup');
                    
                    //    Si tu validación se activa con change:
                    // $(this).trigger('change'); 
                    
                    // 3. Prevenir la acción por defecto para evitar que el valor se establezca dos veces.
                    event.preventDefault(); 
                }
            });
        } else {
            console.warn("jQuery UI Autocomplete no está disponible o las sugerencias no son un array.", prop);
        }

        return asignarAtributosComunes($input, prop);
    },

    crearFila: function(prop) {
        const $row = $('<div class="row">');
        prop.campos.forEach(campoInterno => {
            const $col = $('<div class="col-md mb-3">');
            const $formGroup = $('<div>');
            const $feedback = $('<div class="invalid-feedback"></div>');
            
            if (campoInterno.label) {
                const $label = $('<label>').attr('for', campoInterno.name).addClass('form-label').text(campoInterno.label);
                $formGroup.append($label);
            }
            
            switch (campoInterno.type) {
                case 'input':
                    $campo = this.crearInput(campoInterno);
                    break;
                case 'select':
                    $campo = this.crearSelect(campoInterno);
                    break;
                case 'checkboxes':
                    $campo = this.crearCheckboxes(campoInterno);
                    break;
                case 'textarea':
                    $campo = this.crearTextarea(campoInterno);
                    break;
                case 'subtitulo':
                    $campo = this.crearSubtitulo(campoInterno);
                    break;
                case 'autocomplete':
                    $campo = this.crearAutocomplete(campoInterno);
                    break;
                default:
                    $campo = this.crearInput(campoInterno);
            }

            $formGroup.append($campo);
            $formGroup.append($feedback);
            $col.append($formGroup);
            $row.append($col);
        });
        return $row;
    }
};

/**
 * Genera un formulario dinámico a partir de un objeto de definición.
 * @param {object} definicionFormulario - Objeto que define los campos del formulario.
 * @param {string} tituloFormulario - El título del formulario en la tarjeta.
 */
function generarFormulario(definicionFormulario, tituloFormulario) {
    const $contenedor = $(definicionFormulario.contenedor).empty();
    let $primerElemento;

    // 1. Crear la estructura base del formulario
    const $cardHeader = $(`
        <div class="card-header bg-success text-white">
            <header class="bg-success text-white text-center py-3">
                <h1 class="mb-0" id='titulo-formulario'>${tituloFormulario}</h1>
            </header>
        </div>`);

    const $cardBody = $('<div class="card-body">');
    const $form = $('<form>').attr({
        action: definicionFormulario.action,
        method: 'POST',
        autocomplete: 'off'
    });

    // 2. Iterar y crear cada campo del formulario
    definicionFormulario.campos.forEach(propiedadCampo => {
        // Si es una fila, se maneja de forma especial porque no tiene un 'form-group'
        if (propiedadCampo.type === 'fila') {
            const $fila = creadoresDeCampos.crearFila(propiedadCampo);
            $form.append($fila);

            if (!$primerElemento) {
                // Busca el primer input, select o textarea dentro de la fila
                const $primerInputEnFila = $fila.find('input:not([type="hidden"]), select, textarea').first();
                
                // Si encuentra un elemento enfocable, lo asigna como $primerElemento
                if ($primerInputEnFila.length > 0) {
                    $primerElemento = $primerInputEnFila;
            }
        }
            return; // Continuar con el siguiente campo
        }

        const $formGroup = $('<div class="mb-3">');
        const $feedback = $('<div class="invalid-feedback"></div>');
        
        // Crear la etiqueta si existe
        if (propiedadCampo.label) {
            const $label = $('<label>').attr('for', propiedadCampo.name).addClass('form-label').text(propiedadCampo.label);
            $formGroup.append($label);
        }
        
        // Seleccionar la función correcta para crear el elemento
        let $elemento;
        switch(propiedadCampo.type) {
            case 'select':
                $elemento = creadoresDeCampos.crearSelect(propiedadCampo);
                break;
            case 'textarea':
                $elemento = creadoresDeCampos.crearTextarea(propiedadCampo);
                break;
            case 'checkboxes':
                $elemento = creadoresDeCampos.crearCheckboxes(propiedadCampo);
                break;
            case 'subtitulo':
                $elemento = creadoresDeCampos.crearSubtitulo(propiedadCampo);
                break;
            case 'autocomplete':
                $elemento = creadoresDeCampos.crearAutocomplete(propiedadCampo);
                break;
            default:
                $elemento = creadoresDeCampos.crearInput(propiedadCampo);
        }
        if (!$primerElemento && propiedadCampo.type !== 'subtitulo') {
            $primerElemento = $elemento;
        }
        $formGroup.append($elemento);
        $formGroup.append($feedback);
        $form.append($formGroup);
    });
    // 3. Crear botones de acción
    const $actionButtons = $(`
        <hr/>
        <div class="text-left">
            <a href="${definicionFormulario.cancelarBtn}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>`);
    
    $form.append($actionButtons);

    $form.on('submit', function(event) {
        event.preventDefault(); 
    
        $form.find('select:required').each(function() {
            validarLista($(this));
        });

        const $elementosInvalidos = $form.find('.is-invalid');

        if ($elementosInvalidos.length > 0) {
            $elementosInvalidos.first().focus();
            return;
        }
        
        yaSeDecidioNoAutocompletar = false;
        this.submit(); 
        
    });

    // 4. Ensamblar todo y añadirlo al DOM
    $cardBody.append($form);
    $contenedor.append($cardHeader, $cardBody);
    return $primerElemento;
}
