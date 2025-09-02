<script>
    function getFormularioCampos(tipo, datosPHP) {
        let formularioCampos;
        switch (tipo) {
            case 'administrador':
            if (datosPHP.id) {
                formularioCampos = [
                    { type: 'text', name: 'nombre_usuario', label: 'Nombre de Usuario', validarMetodo: '', value: datosPHP.nombre_usuario},
                    { type: 'password', name: 'password', label: 'Contraseña', placeholder: 'Deja este campo vacío si no deseas cambiar la contraseña.', validarMetodo: ''},
                    { type: 'hidden', name: 'id', validarMetodo: '', value: datosPHP.id},
                ];
                break;
            }
            formularioCampos = [
                { type: 'text', name: 'nombre_usuario', label: 'Nombre de Usuario', validarMetodo: '', value: datosPHP.nombre_usuario },
                { type: 'password', name: 'password', label: 'Contraseña', validarMetodo: ''},
            ];
            break;

            case 'categoria_de_servicio':
            break;
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
