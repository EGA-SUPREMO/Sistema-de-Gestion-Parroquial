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
                    { type: 'text', name: 'cedula', label: 'Cédula', required: true, validarMetodo: 'validarEntero', value: datosPHP.cedula },
                    { type: 'text', name: 'partida_de_nacimiento', label: 'Partida de Nacimiento', required: false, validarMetodo: 'validarString', value: datosPHP.partida_de_nacimiento },
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
        const cancelarUrl = 'index.php?c=tablas&a=mostrar&t=' + tipo;

        let formularioCampos = getFormularioCampos(tipo, datosPHP);

        const definicionFormulario = {
            action: actionUrl,
            cancelarBtn: cancelarUrl,
            contenedor: '#formulario-registrar-administrador',
            campos: formularioCampos,
        };
        
        generarFormulario(definicionFormulario, datosPHP.titulo);
        $(datosPHP.primerElemento).focus();
    });
</script>
