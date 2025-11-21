<script>
    const hoy = new Date().toISOString().slice(0, 10);
    function getFormularioCampos(tipo, datosPHP) {
        //console.log(datosPHP);
        let formularioCampos;
        let sacerdoteOptions;
        let sacerdoteVivosOptions;

        if (datosPHP.sacerdotes) {
            sacerdoteOptions = datosPHP.sacerdotes.map(sacerdote => ({
                value: sacerdote.id,
                text: sacerdote.nombre,
                disabled: sacerdote.id === 0
            }));
            sacerdoteVivosOptions = datosPHP.sacerdotes_vivos.map(sacerdote => ({
                value: sacerdote.id,
                text: sacerdote.nombre,
                disabled: sacerdote.id === 0
            }));
        }

        switch (tipo) {
            case 'administrador':
                formularioCampos = [
                    { type: 'text', name: 'nombre_usuario', label: 'Nombre de Usuario',  required: true, validarMetodo: 'validarNombreUsuario', value: datosPHP.nombre_usuario },
                    { type: 'password', name: 'password', label: 'Contraseña',  required: true,  validarMetodo: 'validarContrasena' },
                ];
                if (datosPHP.id) {
                    formularioCampos[1] = { type: 'password', name: 'password', label: 'Contraseña', required: false, validarMetodo: 'validarContrasena', placeholder: 'Deja este campo vacío si no deseas cambiar la contraseña.'};
                }
                break;

            case 'categoria_de_servicio':
            break;
            case 'sacerdote':
                formularioCampos = [
                    { type: 'text', name: 'nombre', label: 'Nombre del Sacerdote',  required: true, validarMetodo: 'validarNombre', value: datosPHP.nombre },
                    { type: 'select', name: 'vivo', label: '¿Está vivo?', value: datosPHP.vivo, options: [
                        { value: 1, text: 'Si'},
                        { value: 0, text: 'No'},
                    ] },
                ];
            break;
            case 'intencion':
                formularioCampos = [
                    { type: 'autocomplete', name: 'objeto_de_peticion_nombre', label: 'Por que es la intencion',  required: true, validarMetodo: 'validarNombre', sugerencias: datosPHP.objeto_de_peticion, value: datosPHP.objeto_de_peticion_nombre },
                    { type: 'select', name: 'tipo_de_intencion_id', label: 'Selecciona el tipo de intención',  required: true, value: datosPHP.tipo_de_intencion_id, options: [
                      { value: '0', text: 'Selecciona un tipo de intención', disabled: true },
                      { value: '1', text: 'Acción de Gracias' },
                      { value: '2', text: 'Salud' },
                      { value: '3', text: 'Aniversario' },
                      { value: '4', text: 'Difunto' },
                    ]},
                    { type: 'fila', 
                        campos: [
                            { type: 'date', name: 'fecha_inicio', label: 'Fecha de Inicio', required: true, validarMetodo: 'validarFecha', value: datosPHP.fecha_inicio?.slice(0, 10) || hoy},
                            { type: 'date', name: 'fecha_fin', label: 'Fecha de Fin', required: true, validarMetodo: 'validarFecha', value: datosPHP.fecha_fin?.slice(0, 10) || hoy },
                        ]
                    },
                ];
                break;
            case 'feligres':
                formularioCampos = [
                    { type: 'subtitulo', name: 'subtitulo-personal', value: 'Información Personal'},
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'cedula', label: 'Cédula', required: true, validarMetodo: 'validarCedula', keypress: 'soloNumero', autocompletarMetodo: 'autocompletarCampo', value: datosPHP.cedula, pattern: '\\d{4,9}', maxlength: '9'},
                            { type: 'text', name: 'partida_de_nacimiento', label: 'Partida de Nacimiento', required: false, validarMetodo: 'validarPartidaDeNacimiento', autocompletarMetodo: 'autocompletarCampo', value: datosPHP.partida_de_nacimiento },
                        ] 
                    },
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarNombre', value: datosPHP.primer_nombre },
                            { type: 'text', name: 'segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarNombre', value: datosPHP.segundo_nombre },
                        ] 
                    },
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarNombre', value: datosPHP.primer_apellido },
                            { type: 'text', name: 'segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarNombre', value: datosPHP.segundo_apellido },
                        ] 
                    },
                    { type: 'subtitulo', name: 'subtitulo-datos-nacimiento', value: 'Datos de Nacimiento'},
                    { type: 'date', name: 'fecha_nacimiento', label: 'Fecha de Nacimiento', required: false, validarMetodo: 'validarFechaNacimiento', value: datosPHP.fecha_nacimiento },
                    { type: 'subtitulo', name: 'subtitulo-lugar-nacimiento', value: 'Lugar de Nacimiento'},
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'pais', label: 'País', required: false, validarMetodo: 'validarLugar', value: datosPHP.pais },
                            { type: 'text', name: 'estado', label: 'Estado', required: false, validarMetodo: 'validarLugar', value: datosPHP.estado },
                            { type: 'text', name: 'localidad', label: 'Ciudad', required: false, validarMetodo: 'validarLugar', value: datosPHP.localidad },
                            { type: 'text', name: 'municipio', label: 'Municipio', required: false, validarMetodo: 'validarLugar', value: datosPHP.municipio },
                        ] 
                    },
                ];
            break;
            case 'constancia_de_comunion':
                formularioCampos = [
                    { type: 'subtitulo', name: 'subtitulo-cedulas', value: 'Identificación Principal'},
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'feligres-cedula', label: 'Cédula del Feligres', validarMetodo: 'validarCedula', keypress: 'soloNumero', autocompletarMetodo: 'autocompletarSujetoSacramento', pattern: '\\d{4,9}', maxlength: '9', value: datosPHP.feligres?.cedula ?? '' },
                            { type: 'text', name: 'feligres-partida_de_nacimiento', label: 'Partida de Nacimiento del Feligres', validarMetodo: 'validarPartidaDeNacimiento', autocompletarMetodo: 'autocompletarSujetoSacramento', value: datosPHP.feligres?.partida_de_nacimiento ?? '' },
                            { type: 'text', name: 'padre-cedula', label: 'Cédula de un progenitor', required: false, validarMetodo: 'validarCedula', keypress: 'soloNumero', autocompletarMetodo: 'autocompletarCampo', pattern: '\\d{4,9}', maxlength: '9', value: datosPHP.padre?.cedula ?? '' },
                        ]
                    },
                    { type: 'subtitulo', name: 'subtitulo-feligres-datos', value: 'Datos del Feligre'},
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'feligres-primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarNombre', value: datosPHP.feligres?.primer_nombre ?? '' },
                            { type: 'text', name: 'feligres-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarNombre', value: datosPHP.feligres?.segundo_nombre ?? '' },
                        ] 
                    },
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'feligres-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarNombre', value: datosPHP.feligres?.primer_apellido ?? '' },
                            { type: 'text', name: 'feligres-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarNombre', value: datosPHP.feligres?.segundo_apellido ?? '' },
                        ] 
                    },
                    { type: 'date', name: 'constancia-fecha_comunion', label: 'Fecha de la Comunión', required: true, validarMetodo: 'validarFechaConstanciaSuceso', value: datosPHP.fecha_comunion },
                    { type: 'subtitulo', name: 'subtitulo-expedicion-datos', value: 'Datos de la Expedición'},
                    { type: 'date', name: 'fecha_expedicion', label: 'Fecha de Expedición', required: true, validarMetodo: 'validarFechaExpedicion', value: datosPHP.fecha_expedicion ?? new Date().toISOString().slice(0, 10)},
                    { type: 'select', name: 'ministro_certifica_expedicion_id', label: 'Ministro que certifica la Expedición', required: true, value: datosPHP.ministro_certifica_expedicion_id, options: sacerdoteVivosOptions },
                ];
                break;
        case 'constancia_de_fe_de_bautizo':
            formularioCampos = [
                { type: 'subtitulo', name: 'subtitulo-cedulas', value: 'Identificación Principal'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'feligres-cedula', label: 'Cédula del Bautizado', validarMetodo: 'validarCedula', keypress: 'soloNumero', autocompletarMetodo: 'autocompletarSujetoSacramento', pattern: '\\d{4,9}', maxlength: '9', value: datosPHP.feligres?.cedula ?? '' },
                        { type: 'text', name: 'feligres-partida_de_nacimiento', label: 'Partida de Nacimiento del Bautizado', required: true, validarMetodo: 'validarPartidaDeNacimiento', autocompletarMetodo: 'autocompletarSujetoSacramento', value: datosPHP.feligres?.partida_de_nacimiento ?? '' },
                    ]
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'padre-cedula', label: 'Cédula del Progenitor 1 del Bautizado', required: true, validarMetodo: 'validarCedula', keypress: 'soloNumero', autocompletarMetodo: 'autocompletarCampo', pattern: '\\d{4,9}', maxlength: '9', value: datosPHP.padre?.cedula ?? '' },
                        { type: 'text', name: 'madre-cedula', label: 'Cédula del Progenitor 2 del Bautizado', required: true, validarMetodo: 'validarCedula', keypress: 'soloNumero', autocompletarMetodo: 'autocompletarCampo', pattern: '\\d{4,9}', maxlength: '9', value: datosPHP.madre?.cedula ?? '' },
                    ]
                },
                { type: 'subtitulo', name: 'subtitulo-feligres-datos', value: 'Datos del Bautizado'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'feligres-primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarNombre', value: datosPHP.feligres?.primer_nombre ?? '' },
                        { type: 'text', name: 'feligres-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarNombre', value: datosPHP.feligres?.segundo_nombre ?? '' },
                    ] 
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'feligres-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarNombre', value: datosPHP.feligres?.primer_apellido ?? '' },
                        { type: 'text', name: 'feligres-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarNombre', value: datosPHP.feligres?.segundo_apellido ?? '' },
                    ] 
                },
                { type: 'date', name: 'feligres-fecha_nacimiento', label: 'Fecha de Nacimiento', required: true, validarMetodo: 'validarFechaNacimiento', value: datosPHP.feligres?.fecha_nacimiento ?? '' },
                { type: 'subtitulo', name: 'subtitulo-lugar-nacimiento', value: 'Lugar de Nacimiento del Bautizado'},
                    { type: 'fila', 
                        campos: [
                            { type: 'text', name: 'feligres-pais', label: 'País', required: true, validarMetodo: 'validarLugar', value: datosPHP.feligres?.pais ?? '' },
                            { type: 'text', name: 'feligres-estado', label: 'Estado', required: true, validarMetodo: 'validarLugar', value: datosPHP.feligres?.estado ?? '' },
                            { type: 'text', name: 'feligres-municipio', label: 'Municipio', required: true, validarMetodo: 'validarLugar', value: datosPHP.feligres?.municipio ?? '' },
                        ] 
                    },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos del Progenitor 1'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'padre-primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarNombre', value: datosPHP.padre?.primer_nombre ?? '' },
                        { type: 'text', name: 'padre-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarNombre', value: datosPHP.padre?.segundo_nombre ?? '' },
                    ] 
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'padre-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarNombre', value: datosPHP.padre?.primer_apellido ?? '' },
                        { type: 'text', name: 'padre-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarNombre', value: datosPHP.padre?.segundo_apellido ?? '' },
                    ] 
                },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos del Progenitor 2'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'madre-primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarNombre', value: datosPHP.madre?.primer_nombre ?? '' },
                        { type: 'text', name: 'madre-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarNombre', value: datosPHP.madre?.segundo_nombre ?? '' },
                    ] 
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'madre-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarNombre', value: datosPHP.madre?.primer_apellido ?? '' },
                        { type: 'text', name: 'madre-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarNombre', value: datosPHP.madre?.segundo_apellido ?? '' },
                    ] 
                },

                { type: 'subtitulo', name: 'subtitulo-bautizo-datos', value: 'Datos del Bautismo'},
                { type: 'date', name: 'constancia-fecha_bautizo', label: 'Fecha del Bautizo', required: true, validarMetodo: 'validarFechaConstanciaSuceso', value: datosPHP.fecha_bautizo },
                { type: 'text', name: 'constancia-padrino_nombre', label: 'Nombre Completo del Padrino', required: true, validarMetodo: 'validarNombrePadrino', value: datosPHP.padrino_nombre },
                { type: 'text', name: 'constancia-madrina_nombre', label: 'Nombre Completo de la Madrina', required: true, validarMetodo: 'validarNombrePadrino', value: datosPHP.madrina_nombre },
                { type: 'textarea', name: 'constancia-observaciones', label: 'Observaciones', required: false, value: datosPHP.observaciones },
                { type: 'fila', 
                    campos: [
                        { type: 'select', name: 'constancia-ministro_id', label: 'Ministro', required: true, value: datosPHP.ministro_id, options: sacerdoteOptions},
                        { type: 'select', name: 'constancia-ministro_certifica_id', label: 'Ministro que Certifica', required: true, value: datosPHP.ministro_certifica_id, options: sacerdoteOptions },
                    ]
                },

                { type: 'subtitulo', name: 'subtitulo-registro-datos', value: 'Datos del Registro'},
                { type: 'fila', 
                    campos: [
                        { type: 'number', name: 'constancia-numero_libro', label: 'Libro N°', required: true, validarMetodo: 'validarEnteroLibro', value: datosPHP.numero_libro },
                        { type: 'number', name: 'constancia-numero_pagina', label: 'N° Folio', required: true, validarMetodo: 'validarEnteroLibro', value: datosPHP.numero_pagina },
                        { type: 'number', name: 'constancia-numero_marginal', label: 'N° Marginal', required: true, validarMetodo: 'validarEnteroLibro', value: datosPHP.numero_marginal }
                    ] 
                },

                { type: 'subtitulo', name: 'subtitulo-expedicion-datos', value: 'Datos de la Expedición'},
                { type: 'date', name: 'fecha_expedicion', label: 'Fecha de Expedición', required: true, validarMetodo: 'validarFechaExpedicion', value: datosPHP.fecha_expedicion ?? new Date().toISOString().slice(0, 10)},
                { type: 'select', name: 'ministro_certifica_expedicion_id', label: 'Ministro que certifica la Expedición', required: true, value: datosPHP.ministro_certifica_expedicion_id, options: sacerdoteVivosOptions },
                { type: 'select', name: 'proposito', label: 'Propósito de la Certificación', required: true, value: datosPHP.proposito ?? 'Personal', options: [
                      { value: 'Personal', text: 'Personal' },
                      { value: 'Comunión', text: 'Comunión' },
                      { value: 'Confirmación', text: 'Confirmación' },
                      { value: 'Matrimonio', text: 'Matrimonio' },
                    ] },
            ];
            break;
            case 'constancia_de_matrimonio':
            formularioCampos = [
                { type: 'subtitulo', name: 'subtitulo-cedulas', value: 'Identificación Principal'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'padre-cedula', label: 'Cédula del Contrayente 1', required: true, validarMetodo: 'validarCedula', keypress: 'soloNumero', autocompletarMetodo: 'autocompletarSujetoSacramento', pattern: '\\d{4,9}', maxlength: '9', value: datosPHP.contrayente1?.cedula ?? '' },
                        { type: 'text', name: 'madre-cedula', label: 'Cédula del Contrayente 2', required: true, validarMetodo: 'validarCedula', keypress: 'soloNumero', autocompletarMetodo: 'autocompletarSujetoSacramento', pattern: '\\d{4,9}', maxlength: '9', value: datosPHP.contrayente2?.cedula ?? '' },
                    ]
                },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos del Progenitor 1'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'padre-primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarNombre', value: datosPHP.padre?.primer_nombre ?? '' },
                        { type: 'text', name: 'padre-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarNombre', value: datosPHP.padre?.segundo_nombre ?? '' },
                    ] 
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'padre-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarNombre', value: datosPHP.padre?.primer_apellido ?? '' },
                        { type: 'text', name: 'padre-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarNombre', value: datosPHP.padre?.segundo_apellido ?? '' },
                    ] 
                },

                { type: 'subtitulo', name: 'subtitulo-padre-datos', value: 'Datos del Progenitor 2'},
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'madre-primer_nombre', label: 'Primer Nombre', required: true, validarMetodo: 'validarNombre', value: datosPHP.madre?.primer_nombre ?? '' },
                        { type: 'text', name: 'madre-segundo_nombre', label: 'Segundo Nombre', required: false, validarMetodo: 'validarNombre', value: datosPHP.madre?.segundo_nombre ?? '' },
                    ] 
                },
                { type: 'fila', 
                    campos: [
                        { type: 'text', name: 'madre-primer_apellido', label: 'Primer Apellido', required: true, validarMetodo: 'validarNombre', value: datosPHP.madre?.primer_apellido ?? '' },
                        { type: 'text', name: 'madre-segundo_apellido', label: 'Segundo Apellido', required: false, validarMetodo: 'validarNombre', value: datosPHP.madre?.segundo_apellido ?? '' },
                    ] 
                },

                { type: 'subtitulo', name: 'subtitulo-bautizo-datos', value: 'Datos del Bautismo'},
                { type: 'date', name: 'constancia-fecha_bautizo', label: 'Fecha del Bautizo', required: true, validarMetodo: 'validarFechaConstanciaSuceso', value: datosPHP.fecha_bautizo },
                { type: 'text', name: 'constancia-padrino_nombre', label: 'Nombre Completo del Padrino', required: true, validarMetodo: 'validarNombrePadrino', value: datosPHP.padrino_nombre },
                { type: 'text', name: 'constancia-madrina_nombre', label: 'Nombre Completo de la Madrina', required: true, validarMetodo: 'validarNombrePadrino', value: datosPHP.madrina_nombre },
                { type: 'textarea', name: 'constancia-observaciones', label: 'Observaciones', required: false, value: datosPHP.observaciones },
                { type: 'fila', 
                    campos: [
                        { type: 'select', name: 'constancia-ministro_id', label: 'Ministro', required: true, value: datosPHP.ministro_id, options: sacerdoteOptions},
                        { type: 'select', name: 'constancia-ministro_certifica_id', label: 'Ministro que Certifica', required: true, value: datosPHP.ministro_certifica_id, options: sacerdoteOptions },
                    ]
                },

                { type: 'subtitulo', name: 'subtitulo-registro-datos', value: 'Datos del Registro'},
                { type: 'fila', 
                    campos: [
                        { type: 'number', name: 'constancia-numero_libro', label: 'Libro N°', required: true, validarMetodo: 'validarEnteroLibro', value: datosPHP.numero_libro },
                        { type: 'number', name: 'constancia-numero_pagina', label: 'N° Folio', required: true, validarMetodo: 'validarEnteroLibro', value: datosPHP.numero_pagina },
                        { type: 'number', name: 'constancia-numero_marginal', label: 'N° Marginal', required: true, validarMetodo: 'validarEnteroLibro', value: datosPHP.numero_marginal }
                    ] 
                },

                { type: 'subtitulo', name: 'subtitulo-expedicion-datos', value: 'Datos de la Expedición'},
                { type: 'date', name: 'fecha_expedicion', label: 'Fecha de Expedición', required: true, validarMetodo: 'validarFechaExpedicion', value: datosPHP.fecha_expedicion ?? new Date().toISOString().slice(0, 10)},
                { type: 'select', name: 'ministro_certifica_expedicion_id', label: 'Ministro que certifica la Expedición', required: true, value: datosPHP.ministro_certifica_expedicion_id, options: sacerdoteVivosOptions },
                { type: 'select', name: 'proposito', label: 'Propósito de la Certificación', required: true, value: datosPHP.proposito ?? 'Personal', options: [
                      { value: 'Personal', text: 'Personal' },
                      { value: 'Comunión', text: 'Comunión' },
                      { value: 'Confirmación', text: 'Confirmación' },
                      { value: 'Matrimonio', text: 'Matrimonio' },
                    ] },
            ];
            break;
        }
        formularioCampos.push({ type: 'hidden', name: 'id', value: datosPHP.id});
        
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
