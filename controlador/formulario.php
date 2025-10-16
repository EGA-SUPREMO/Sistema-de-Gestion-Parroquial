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
            case 'intencion':
                formularioCampos = [
                    { type: 'autocomplete', name: 'nombre', label: 'Por quien es la intencion',  required: true, validarMetodo: '', value: datosPHP.nombre },
                    { type: 'select', name: 'nombre', label: 'Selecciona el tipo de intención',  required: true, validarMetodo: '', value: datosPHP.nombre, options: [
                      { value: '0', text: 'Selecciona un tipo de intención', disabled: true },
                      { value: '1', text: 'Acción de Gracias' },
                      { value: '2', text: 'Salud' },
                      { value: '3', text: 'Aniversario' },
                      { value: '4', text: 'Difunto' },
                    ]},
                    { type: 'fila', 
                        campos: [
                            { type: 'date', name: 'fecha_nacimiento', label: 'Fecha de Inicio', required: true, validarMetodo: 'validarFecha', value: new Date().toISOString().slice(0, 10)},
                            { type: 'date', name: 'fecha_nacimiento', label: 'Fecha de Fin', required: true, validarMetodo: 'validarFecha', value: new Date().toISOString().slice(0, 10) },
                        ]
                    },
                ];
                break;
            case 'feligres':
                formularioCampos = [
                    { type: 'subtitulo', name: 'subtitulo-personal', value: 'Información Personal'},
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'cedula', label: 'Cédula', required: true, validarMetodo: 'validarEntero', autocompletarMetodo: 'autocompletarCampo', value: datosPHP.cedula, pattern: '\\d{4,10}', maxlength: '10'},
                            { type: 'text', name: 'partida_de_nacimiento', label: 'Partida de Nacimiento', required: false, validarMetodo: 'validarString', autocompletarMetodo: 'autocompletarCampo', value: datosPHP.partida_de_nacimiento },
                        ] 
                    },
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: datosPHP.primer_nombre },
                            { type: 'text', name: 'segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: datosPHP.segundo_nombre },
                        ] 
                    },
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: datosPHP.primer_apellido },
                            { type: 'text', name: 'segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: datosPHP.segundo_apellido },
                        ] 
                    },
                    { type: 'subtitulo', name: 'subtitulo-datos-nacimiento', value: 'Datos de Nacimiento'},
                    { type: 'date', name: 'fecha_nacimiento', label: 'Fecha de Nacimiento', required: false, validarMetodo: 'validarFecha', value: datosPHP.fecha_nacimiento },
                    { type: 'subtitulo', name: 'subtitulo-lugar-nacimiento', value: 'Lugar de Nacimiento'},
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'pais', label: 'País', required: false, validarMetodo: 'validarString', value: datosPHP.pais },
                            { type: 'text', name: 'estado', label: 'Estado', required: false, validarMetodo: 'validarString', value: datosPHP.estado },
                            { type: 'text', name: 'localidad', label: 'Ciudad', required: false, validarMetodo: 'validarString', value: datosPHP.localidad },
                            { type: 'text', name: 'municipio', label: 'Municipio', required: false, validarMetodo: 'validarString', value: datosPHP.municipio },
                        ] 
                    },
                ];
            break;
        case 'constancia_de_bautizo':
            const sacerdoteOptions = datosPHP.sacerdotes.map(sacerdote => ({
                value: sacerdote.id,
                text: sacerdote.nombre,
                disabled: sacerdote.id === 0
            }));
            const sacerdoteVivosOptions = datosPHP.sacerdotes_vivos.map(sacerdote => ({
                value: sacerdote.id,
                text: sacerdote.nombre,
                disabled: sacerdote.id === 0
            }));
            formularioCampos = [
                { type: 'subtitulo', name: 'subtitulo-cedulas', value: 'Identificación Principal'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'feligres-cedula', label: 'Cédula del Bautizado', validarMetodo: 'validarEntero', autocompletarMetodo: 'autocompletarFeligresBautizado', pattern: '\\d{4,10}', maxlength: '10', value: 223344 },
                        { type: 'text', name: 'feligres-partida_de_nacimiento', label: 'Partida de Nacimiento del Bautizado', required: true, validarMetodo: 'validarString', autocompletarMetodo: 'autocompletarFeligresBautizado', value: 'ASDDE' },
                    ]
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'padre-cedula', label: 'Cédula del Padre del Bautizado', required: true, validarMetodo: 'validarEntero', autocompletarMetodo: 'autocompletarCampo', pattern: '\\d{4,10}', maxlength: '10', value: 112233 },
                        { type: 'text', name: 'madre-cedula', label: 'Cédula de la Madre del Bautizado', required: true, validarMetodo: 'validarEntero', autocompletarMetodo: 'autocompletarCampo', pattern: '\\d{4,10}', maxlength: '10', value: 334455 },
                    ]
                },
                { type: 'subtitulo', name: 'subtitulo-feligres-datos', value: 'Datos del Bautizado'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'feligres-primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarNombre', value: 'datosPHP.primer_nombre' },
                        { type: 'text', name: 'feligres-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarNombre', value: 'datosPHP.segundo_nombre' },
                    ] 
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'feligres-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: 'datosPHP.primer_apellido' },
                        { type: 'text', name: 'feligres-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: 'datosPHP.segundo_apellido' },
                    ] 
                },
                { type: 'date', name: 'feligres-fecha_nacimiento', label: 'Fecha de Nacimiento', required: true, validarMetodo: 'validarFecha', value: new Date().toISOString().slice(0, 10) },
                { type: 'subtitulo', name: 'subtitulo-lugar-nacimiento', value: 'Lugar de Nacimiento del Bautizado'},
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'feligres-pais', label: 'País', required: true, validarMetodo: 'validarString', value: 'datosPHP.pais' },
                            { type: 'text', name: 'feligres-estado', label: 'Estado', required: true, validarMetodo: 'validarString', value: 'datosPHP.estado' },
                            { type: 'text', name: 'feligres-municipio', label: 'Municipio', required: true, validarMetodo: 'validarString', value: 'datosPHP.municipio' },
                        ] 
                    },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos del Padre'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'padre-primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: 'datosPHP.padre_primer_nombre' },
                        { type: 'text', name: 'padre-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: 'datosPHP.padre_segundo_nombre' },
                    ] 
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'padre-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: 'datosPHP.padre_primer_apellido' },
                        { type: 'text', name: 'padre-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: 'datosPHP.padre_segundo_apellido' },
                    ] 
                },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos de la Madre'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'madre-primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarString', value: 'datosPHP.madre_primer_nombre' },
                        { type: 'text', name: 'madre-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarString', value: 'datosPHP.madre_segundo_nombre' },
                    ] 
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'madre-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarString', value: 'datosPHP.madre_primer_apellido' },
                        { type: 'text', name: 'madre-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarString', value: 'datosPHP.madre_segundo_apellido' },
                    ] 
                },

                { type: 'subtitulo', name: 'subtitulo-bautizo-datos', value: 'Datos del Bautismo'},
                { type: 'date', name: 'constancia-fecha_bautizo', label: 'Fecha del Bautizo', required: true, validarMetodo: 'validarFecha', value: new Date().toISOString().slice(0, 10) },
                { type: 'text', name: 'constancia-padrino_nombre', label: 'Nombre Completo del Padrino', required: true, validarMetodo: 'validarString', value: 'datosPHP.padrino_nombre' },
                { type: 'text', name: 'constancia-madrina_nombre', label: 'Nombre Completo de la Madrina', required: true, validarMetodo: 'validarString', value: 'datosPHP.madrina_nombre' },
                { type: 'textarea', name: 'constancia-observaciones', label: 'Observaciones', required: false, validarMetodo: 'validarString', value: 'datosPHP.observaciones' },
                { type: 'fila', 
                    campos: [
                        { type: 'select', name: 'constancia-ministro_id', label: 'Ministro', required: true, validarMetodo: 'validarEntero', options: sacerdoteOptions},
                        { type: 'select', name: 'constancia-ministro_certifica_id', label: 'Ministro que Certifica', required: true, validarMetodo: 'validarEntero', options: sacerdoteOptions },
                    ]
                },

                { type: 'subtitulo', name: 'subtitulo-registro-datos', value: 'Datos del Registro'},
                { type: 'fila', 
                    campos: [
                        { type: 'number', name: 'constancia-numero_libro', label: 'Libro N°', required: true, validarMetodo: 'validarEntero', value: 4 },
                        { type: 'number', name: 'constancia-numero_pagina', label: 'N° Folio', required: true, validarMetodo: 'validarEntero', value: 4 },
                        { type: 'number', name: 'constancia-numero_marginal', label: 'N° Marginal', required: true, validarMetodo: 'validarEntero', value: 4 }
                    ] 
                },

                { type: 'subtitulo', name: 'subtitulo-expedicion-datos', value: 'Datos de la Expedición'},
                { type: 'date', name: 'fecha_expedicion', label: 'Fecha de Expedición', required: true, validarMetodo: 'validarFecha', value: new Date().toISOString().slice(0, 10)},
                { type: 'select', name: 'ministro_certifica_expedicion_id', label: 'Ministro que certifica la Expedición', required: true, validarMetodo: 'validarEntero', options: sacerdoteVivosOptions },
                { type: 'select', name: 'proposito', label: 'Propósito de la Certificación', required: true, validarMetodo: 'validarString', value: 'Personal', options: [
                      { value: 'Personal', text: 'Personal' },
                      { value: 'Comunión', text: 'Comunión' },
                      { value: 'Confirmación', text: 'Confirmación' },
                      { value: 'Matrimonio', text: 'Matrimonio' },
                    ] },
            ];
        break;
        }
        formularioCampos.push({ type: 'hidden', name: 'id', validarMetodo: '', value: datosPHP.id});
        
        return formularioCampos;
    }


    $(document).ready(function() {
        const datosPHP = <?php echo $datos_formulario['formulario']; ?>;

        const urlParams = new URLSearchParams(window.location.search);
        const tipo = urlParams.get('t');
        const controlador = urlParams.get('c');

        const actionUrl = 'index.php?c=' + controlador + '&a=procesarFormulario&t=' + tipo;
        const cancelarUrl = 'index.php?c=panel&a=index&t=' + tipo;

        let formularioCampos = getFormularioCampos(tipo, datosPHP);

        const definicionFormulario = {
            action: actionUrl,
            cancelarBtn: cancelarUrl,
            contenedor: '#formulario',
            campos: formularioCampos,
        };
        
        const $primerElemento = generarFormulario(definicionFormulario, datosPHP.titulo);
        $primerElemento.focus();
    });
</script>
