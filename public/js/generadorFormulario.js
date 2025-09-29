function completarCampos(datos) {
    const prefijos = ['padre', 'madre', 'feligres'];

    prefijos.forEach(prefijo => {
        const objetoDatos = datos[prefijo]; // Obtener los datos para 'padre', 'madre', o 'feligres'

        if (objetoDatos && typeof objetoDatos === 'object') {
            // Iterar sobre las propiedades del objeto (e.g., 'primer_nombre', 'cedula')
            for (const key in objetoDatos) {
                if (objetoDatos.hasOwnProperty(key)) {
                    const valor = objetoDatos[key];
                    // Construir el nombre completo del campo en el formulario (e.g., 'padre-primer_nombre')
                    const nombreCampo = `${prefijo}-${key}`;
                    
                    // Buscar el input y asignarle el valor si existe
                    const $input = $(`[name="${nombreCampo}"]`);

                    if ($input.length) {
                        // Usar .val() para inputs, textareas y selects
                        $input.val(valor); 
                        console.log(`Autocompletado: ${nombreCampo} = ${valor}`);
                    }
                }
            }
        } else {
            // console.log(`No se encontraron datos para ${prefijo}.`);
        }
    });
}

function pedirDatos(datos) {
    $.post("modelo/formulario.php", { json: datos }, function(resultado) {
        // 1. Aquí, 'resultado' YA es un objeto JavaScript (si la conversión fue exitosa)
        console.log("Respuesta del servidor (Objeto JS):", resultado); 
        // 2. Procesar y autocompletar los campos
        completarCampos(resultado);

    }, 'json') // <--- ¡AÑADE 'json' AQUÍ!
    .fail(function(xhr, status, error) {
        console.log("Error en la respuesta del servidor (Objeto JS):", xhr);
    });
}

function autocompletarPadreCedula($element) {
    // Obtenemos la cédula del elemento que dispaó el evento
    const cedulaPadre = $element.val();
    const cedulaMadre = $element.val();
    const cedulaFeligres = $element.val();
    
    // Si la cédula está vacía, no hacemos nada
    if (!cedulaPadre) {
        return;
    }

    // Estructura de datos a enviar al servidor
    let datos = JSON.stringify({ 'padre-cedula': cedulaPadre }); 
    pedirDatos(datos);
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

    if (properties.autocompletarMetodo) {
        $element.on('focusout', function() {// TODO que gemini me explice esto
            // Llamamos a la función. 'this' dentro de la función se referirá al input.
            window[properties.autocompletarMetodo].call(null, $element);
        });
    }

    return $element;
}

// Objeto que contiene funciones para crear cada tipo de campo.
// Esto reemplaza el bloque largo de if/else if.
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
        

        return asignarAtributosComunes($select, prop);
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

    crearFila: function(prop) {
        const $row = $('<div class="row">');
        prop.campos.forEach(campoInterno => {
            const $col = $('<div class="col-md mb-3">');
            const $formGroup = $('<div>');
            
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
                case 'textarea':
                    $campo = this.crearTextarea(campoInterno);
                    break;
                case 'subtitulo':
                    $campo = this.crearSubtitulo(campoInterno);
                    break;
                default:
                    $campo = this.crearInput(campoInterno);
            }

            $formGroup.append($campo);
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

    // 1. Crear la estructura base del formulario
    const $cardHeader = $(`
        <div class="card-header bg-success text-white">
            <header class="bg-success text-white text-center py-3">
                <h1 class="mb-0">${tituloFormulario}</h1>
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
            return; // Continuar con el siguiente campo
        }

        const $formGroup = $('<div class="mb-3">');
        
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
            case 'subtitulo':
                $elemento = creadoresDeCampos.crearSubtitulo(propiedadCampo);
                break;
            default:
                $elemento = creadoresDeCampos.crearInput(propiedadCampo);
        }
        
        $formGroup.append($elemento);
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

    // 4. Ensamblar todo y añadirlo al DOM
    $cardBody.append($form);
    $contenedor.append($cardHeader, $cardBody);
}
