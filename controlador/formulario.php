<script>
    $(document).ready(function() {
        const datosPHP = <?php echo $datos_formulario['formulario']; ?>;

        const urlParams = new URLSearchParams(window.location.search);
        const tipo = urlParams.get('t');

        const actionUrl = 'index.php?c=formulario&a=guardar&t=' + tipo;
        const cancelarUrl = 'index.php?c=tablas&a=mostrar&t=' + tipo;

        let formularioCampos;
        switch (tipo) {
            case 'administrador':
                if (datosPHP.id) {
                    formularioCampos = [
                        { type: 'text', name: 'nombre', label: 'Nombre de Usuario', value: datosPHP.nombre},
                        { type: 'password', name: 'password', label: 'Contraseña', placeholder: 'Deja este campo vacío si no deseas cambiar la contraseña.'},
                        { type: 'hidden', name: 'id', value: datosPHP.id},
                    ];
                    break;
                }
                formularioCampos = [
                    { type: 'text', name: 'nombre', label: 'Nombre de Usuario' , value: datosPHP.nombre },
                    { type: 'password', name: 'password', label: 'Contraseña' },
                ];
                break;
            case 'categoria_de_servicio':
                break;
        }

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
