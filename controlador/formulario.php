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
        case 'constancia_bautizo':
            formularioCampos = [
                { type: 'number', name: 'feligres_bautizado_id', label: 'ID del Feligrés Bautizado', required: true, validarMetodo: 'validarEntero', value: datosPHP.feligres_bautizado_id },
                { type: 'select', name: 'feligres_bautizado_id', label: 'ID del Feligrés Bautizado', required: true, validarMetodo: 'validarEntero', value: 2, options: [
                      { value: '1', text: 'Administrador' },
                      { value: '2', text: 'Editor' },
                      { value: '3', text: 'Lector' }
                    ] },
                { type: 'date', name: 'fecha_nacimiento', label: 'Fecha de Nacimiento', required: true, validarMetodo: 'validarFecha', value: datosPHP.fecha_nacimiento },
                { type: 'date', name: 'fecha_bautizo', label: 'Fecha de Bautizo', required: true, validarMetodo: 'validarFecha', value: datosPHP.fecha_bautizo },
                { type: 'number', name: 'padre_id', label: 'ID del Padre', required: true, validarMetodo: 'validarEntero', value: datosPHP.padre_id },
                { type: 'number', name: 'madre_id', label: 'ID de la Madre', required: true, validarMetodo: 'validarEntero', value: datosPHP.madre_id },
                { type: 'text', name: 'padrino_nombre', label: 'Nombre del Padrino', required: true, validarMetodo: 'validarString', value: datosPHP.padrino_nombre },
                { type: 'text', name: 'madrina_nombre', label: 'Nombre de la Madrina', required: true, validarMetodo: 'validarString', value: datosPHP.madrina_nombre },
                { type: 'textarea', name: 'observaciones', label: 'Observaciones', required: false, validarMetodo: 'validarString', value: datosPHP.observaciones },
                { type: 'text', name: 'municipio', label: 'Municipio', required: true, validarMetodo: 'validarString', value: datosPHP.municipio },
                { type: 'number', name: 'ministro_id', label: 'ID del Ministro', required: true, validarMetodo: 'validarEntero', value: datosPHP.ministro_id },
                { type: 'number', name: 'ministro_certifica_id', label: 'ID del Ministro que Certifica', required: true, validarMetodo: 'validarEntero', value: datosPHP.ministro_certifica_id },
                { type: 'text', name: 'registro_civil', label: 'Registro Civil', required: false, validarMetodo: 'validarString', value: datosPHP.registro_civil },
                { type: 'number', name: 'numero_libro', label: 'Número de Libro', required: true, validarMetodo: 'validarEntero', value: datosPHP.numero_libro },
                { type: 'number', name: 'numero_pagina', label: 'Número de Página', required: true, validarMetodo: 'validarEntero', value: datosPHP.numero_pagina },
                { type: 'number', name: 'numero_marginal', label: 'Número Marginal', required: true, validarMetodo: 'validarEntero', value: datosPHP.numero_marginal },
                { type: 'select', name: 'proposito', label: 'Propósito de la Certificación', required: true, validarMetodo: 'validarEntero', value: 'Personal', options: [
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
