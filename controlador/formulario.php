<script>
    function getFormularioCampos(tipo, datosPHP) {
        let formularioCampos;
        switch (tipo) {
            case 'administrador':
                formularioCampos = [
                    { type: 'text', name: 'nombre_usuario', label: 'Nombre de Usuario',  required: true, validarMetodo: '', value: datosPHP.nombre_usuario },
                    { type: 'password', name: 'password', label: 'Contraseña',  required: true, validarMetodo: ''},
                ];
                if (datosPHP.id) {
                    formularioCampos[1] = { type: 'password', name: 'password', label: 'Contraseña', required: false, placeholder: 'Deja este campo vacío si no deseas cambiar la contraseña.', validarMetodo: ''};
                }
                break;

            case 'categoria_de_servicio':
            break;
            case 'sacerdote':
                formularioCampos = [
                    { type: 'text', name: 'nombre', label: 'Nombre del Sacerdote',  required: true, validarMetodo: '', value: datosPHP.nombre },
                    { type: 'hidden', name: 'vivo',  value: '0' },
                    { type: 'checkbox', name: 'vivo', label: '¿Está vivo?', validarMetodo: '',  checked: datosPHP.vivo === 1 },
                ];
            break;
            case 'feligres':
                formularioCampos = [
                    { type: 'text', name: 'primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: datosPHP.primer_nombre },
                    { type: 'text', name: 'segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: datosPHP.segundo_nombre },
                    { type: 'text', name: 'primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: datosPHP.primer_apellido },
                    { type: 'text', name: 'segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: datosPHP.segundo_apellido },
                    { type: 'date', name: 'fecha_nacimiento', label: 'Fecha de Nacimiento', required: true, validarMetodo: 'validarFecha', value: datosPHP.fecha_nacimiento },
                    { type: 'text', name: 'cedula', label: 'Cédula', required: true, validarMetodo: 'validarEntero', value: datosPHP.cedula, pattern: '\\d{4,10}', maxlength: '10'},
                    { type: 'text', name: 'partida_de_nacimiento', label: 'Partida de Nacimiento', required: false, validarMetodo: 'validarString', value: datosPHP.partida_de_nacimiento },
                ];
            break;
        case 'constancia_de_bautizo':
            formularioCampos = [
                { type: 'subtitulo', name: 'subtitulo-cedulas', value: 'Cédulas de identidad'},
                { type: 'text', name: 'feligres-cedula', label: 'Cédula del Feligrés Bautizado', validarMetodo: 'validarEntero', pattern: '\\d{4,10}', maxlength: '10', value: 223344 },
                { type: 'text', name: 'padre-cedula', label: 'Cédula del Padre del Bautizado', required: true, validarMetodo: 'validarEntero', pattern: '\\d{4,10}', maxlength: '10', value: 112233 },
                { type: 'text', name: 'madre-cedula', label: 'Cédula de la Madre del Bautizado', required: true, validarMetodo: 'validarEntero', pattern: '\\d{4,10}', maxlength: '10', value: 334455 },
                { type: 'text', name: 'registro_civil', label: 'Registro Civil del Bautizado', required: true, validarMetodo: 'validarString', value: 'ASDDE' },

                { type: 'subtitulo', name: 'subtitulo-feligres-datos', value: 'Datos del Bautizado'},
                { type: 'text', name: 'primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: 'datosPHP.primer_nombre' },
                { type: 'text', name: 'segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: 'datosPHP.segundo_nombre' },
                { type: 'text', name: 'primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: 'datosPHP.primer_apellido' },
                { type: 'text', name: 'segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: 'datosPHP.segundo_apellido' },
                { type: 'date', name: 'fecha_nacimiento', label: 'Fecha de Nacimiento', required: true, validarMetodo: 'validarFecha', value: new Date().toISOString().slice(0, 10) },
                { type: 'text', name: 'municipio', label: 'Lugar de nacimiento (municipio)', required: true, validarMetodo: 'validarString', value: 'datosPHP.municipio' },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos del Padre'},
                { type: 'text', name: 'padre-primer-nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: 'datosPHP.padre_primer_nombre' },
                { type: 'text', name: 'padre-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: 'datosPHP.padre_segundo_nombre' },
                { type: 'text', name: 'padre-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: 'datosPHP.padre_primer_apellido' },
                { type: 'text', name: 'padre-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: 'datosPHP.padre_segundo_apellido' },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos de la Madre'},
                { type: 'text', name: 'madre-primer-nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: 'datosPHP.madre_primer_nombre' },
                { type: 'text', name: 'madre-segundo-nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: 'datosPHP.madre_segundo_nombre' },
                { type: 'text', name: 'madre-primer-apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: 'datosPHP.madre_primer_apellido' },
                { type: 'text', name: 'madre-segundo-apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: 'datosPHP.madre_segundo_apellido' },

                { type: 'subtitulo', name: 'subtitulo-bautizo-datos', value: 'Datos del Bautismo'},
                { type: 'date', name: 'fecha_bautizo', label: 'Fecha de Bautizo', required: true, validarMetodo: 'validarFecha', value: new Date().toISOString().slice(0, 10) },
                { type: 'text', name: 'padrino_nombre', label: 'Nombre del Padrino', required: true, validarMetodo: 'validarString', value: 'datosPHP.padrino_nombre' },
                { type: 'text', name: 'madrina_nombre', label: 'Nombre de la Madrina', required: true, validarMetodo: 'validarString', value: 'datosPHP.madrina_nombre' },
                { type: 'textarea', name: 'observaciones', label: 'Observaciones', required: false, validarMetodo: 'validarString', value: 'datosPHP.observaciones' },
                { type: 'number', name: 'ministro_id', label: 'ID del Ministro', required: true, validarMetodo: 'validarEntero', value: 1 },
                { type: 'number', name: 'ministro_certifica_id', label: 'ID del Ministro que Certifica', required: true, validarMetodo: 'validarEntero', value: 1 },
                { type: 'fila', 
                    campos: [
                        { type: 'number', name: 'numero_libro', label: 'Libro N°', required: true, validarMetodo: 'validarEntero', value: 4 },
                        { type: 'number', name: 'numero_pagina', label: 'N° Folio', required: true, validarMetodo: 'validarEntero', value: 4 },
                        { type: 'number', name: 'numero_marginal', label: 'N° Marginal', required: true, validarMetodo: 'validarEntero', value: 4 }
                    ] 
                },
                { type: 'subtitulo', name: 'subtitulo-expedicion-datos', value: 'Datos de Expedición'},
                { type: 'date', name: 'fecha-expedicion', label: 'Fecha de Expedición', required: true, validarMetodo: 'validarFecha', value: new Date().toISOString().slice(0, 10)},
                { type: 'select', name: 'proposito', label: 'Propósito de la Certificación', required: true, validarMetodo: 'validarString', value: 'Personal', options: [
                      { value: 'Personal', text: 'Personal' },
                      { value: 'Comunión', text: 'Comunión' },
                      { value: 'Confirmación', text: 'Confirmación' },
                      { value: 'Matrimonio', text: 'Matrimonio' },
                    ] },
            ];
        break;
        case 'NO TESTconstancia_de_bautizo':
            formularioCampos = [
                { type: 'subtitulo', name: 'subtitulo-cedulas', value: 'Cédulas de identidad'},
                { type: 'text', name: 'feligres-cedula', label: 'Cédula del Feligrés Bautizado', validarMetodo: 'validarEntero', pattern: '\\d{4,10}', maxlength: '10', value: datosPHP.cedula },
                { type: 'text', name: 'padre-cedula', label: 'Cédula del Padre del Bautizado', required: true, validarMetodo: 'validarEntero', pattern: '\\d{4,10}', maxlength: '10', value: datosPHP.cedula },
                { type: 'text', name: 'madre-cedula', label: 'Cédula de la Madre del Bautizado', required: true, validarMetodo: 'validarEntero', pattern: '\\d{4,10}', maxlength: '10', value: datosPHP.cedula },
                { type: 'text', name: 'registro_civil', label: 'Registro Civil del Bautizado', required: true, validarMetodo: 'validarString', value: datosPHP.registro_civil },

                { type: 'subtitulo', name: 'subtitulo-feligres-datos', value: 'Datos del Bautizado'},
                { type: 'text', name: 'primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: datosPHP.primer_nombre },
                { type: 'text', name: 'segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: datosPHP.segundo_nombre },
                { type: 'text', name: 'primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: datosPHP.primer_apellido },
                { type: 'text', name: 'segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: datosPHP.segundo_apellido },
                { type: 'date', name: 'fecha_nacimiento', label: 'Fecha de Nacimiento', required: true, validarMetodo: 'validarFecha', value: datosPHP.fecha_nacimiento },
                { type: 'text', name: 'municipio', label: 'Lugar de nacimiento (municipio)', required: true, validarMetodo: 'validarString', value: datosPHP.municipio },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos del Padre'},
                { type: 'text', name: 'padre-primer-nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: datosPHP.padre_primer_nombre },
                { type: 'text', name: 'padre-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: datosPHP.padre_segundo_nombre },
                { type: 'text', name: 'padre-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: datosPHP.padre_primer_apellido },
                { type: 'text', name: 'padre-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: datosPHP.padre_segundo_apellido },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos de la Madre'},
                { type: 'text', name: 'madre-primer-nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: datosPHP.madre_primer_nombre },
                { type: 'text', name: 'madre-segundo-nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: datosPHP.madre_segundo_nombre },
                { type: 'text', name: 'madre-primer-apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: datosPHP.madre_primer_apellido },
                { type: 'text', name: 'madre-segundo-apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: datosPHP.madre_segundo_apellido },

                { type: 'subtitulo', name: 'subtitulo-bautizo-datos', value: 'Datos del Bautismo'},
                { type: 'date', name: 'fecha_bautizo', label: 'Fecha de Bautizo', required: true, validarMetodo: 'validarFecha', value: datosPHP.fecha_bautizo },
                { type: 'text', name: 'padrino_nombre', label: 'Nombre del Padrino', required: true, validarMetodo: 'validarString', value: datosPHP.padrino_nombre },
                { type: 'text', name: 'madrina_nombre', label: 'Nombre de la Madrina', required: true, validarMetodo: 'validarString', value: datosPHP.madrina_nombre },
                { type: 'textarea', name: 'observaciones', label: 'Observaciones', required: false, validarMetodo: 'validarString', value: datosPHP.observaciones },
                { type: 'number', name: 'ministro_id', label: 'ID del Ministro', required: true, validarMetodo: 'validarEntero', value: datosPHP.ministro_id },
                { type: 'number', name: 'ministro_certifica_id', label: 'ID del Ministro que Certifica', required: true, validarMetodo: 'validarEntero', value: datosPHP.ministro_certifica_id },
                { type: 'fila', 
                    campos: [
                        { type: 'number', name: 'numero_libro', label: 'Libro N°', required: true, validarMetodo: 'validarEntero', value: datosPHP.numero_libro },
                        { type: 'number', name: 'numero_pagina', label: 'N° Folio', required: true, validarMetodo: 'validarEntero', value: datosPHP.numero_pagina },
                        { type: 'number', name: 'numero_marginal', label: 'N° Marginal', required: true, validarMetodo: 'validarEntero', value: datosPHP.numero_marginal }
                    ] 
                },
                { type: 'subtitulo', name: 'subtitulo-expedicion-datos', value: 'Datos de Expedición'},
                { type: 'date', name: 'fecha-expedicion', label: 'Fecha de Expedición', required: true, validarMetodo: 'validarFecha', value: new Date().toISOString().slice(0, 10)},
                { type: 'select', name: 'proposito', label: 'Propósito de la Certificación', required: true, validarMetodo: 'validarString', value: 'Personal', options: [
                      { value: 'Personal', text: 'Personal' },
                      { value: 'Comunión', text: 'Comunión' },
                      { value: 'Confirmación', text: 'Confirmación' },
                      { value: 'Matrimonio', text: 'Matrimonio' },
                    ] },
            ];
        break;

        }
        if (datosPHP.id) {
            formularioCampos.push({ type: 'hidden', name: 'id', validarMetodo: '', value: datosPHP.id});
        }
        return formularioCampos;
    }


    $(document).ready(function() {
        const datosPHP = <?php echo $datos_formulario['formulario']; ?>;

        const urlParams = new URLSearchParams(window.location.search);
        const tipo = urlParams.get('t');

        const actionUrl = 'index.php?c=formulario&a=guardarRegistro&t=' + tipo;
        const cancelarUrl = 'index.php?c=panel&a=index&t=' + tipo;

        let formularioCampos = getFormularioCampos(tipo, datosPHP);

        const definicionFormulario = {
            action: actionUrl,
            cancelarBtn: cancelarUrl,
            contenedor: '#formulario',
            campos: formularioCampos,
        };
        
        generarFormulario(definicionFormulario, datosPHP.titulo);
        $(datosPHP.primerElemento).focus();
    });
</script>
