<script>
    $(document).ready(function() {
        const datosPHP = <?php echo $datos_formulario['formulario']; ?>;

        const urlParams = new URLSearchParams(window.location.search);
        const tipo = urlParams.get('t');

        const actionUrl = 'index.php?c=formulario&a=guardar&t=' + tipo;
        const cancelarUrl = 'index.php?c=tablas&a=mostrar&t=' + tipo;

        
        const definicionFormulario = {
            action: actionUrl,
            cancelarBtn: cancelarUrl,
            contenedor: '#formulario-registrar-administrador',
            campos: [
                { type: 'text', name: 'nombre', label: 'Nombre de Usuario' , value: datosPHP.nombre},
                { type: 'password', name: 'password', label: 'Contraseña'},
            ]
        };

        const definicionFormulario1 = {
                action: 'index.php?c=login&a=actualizar',
                cancelarBtn: 'index.php?c=login&a=mostrar',
                contenedor: '#formulario-registrar-administrador',
                campos: [
                    { type: 'text', name: 'nombre', label: 'Nombre de Usuario', value: datosPHP.nombre},
                    { type: 'password', name: 'password', label: 'Contraseña', placeholder: 'Deja este campo vacío si no deseas cambiar la contraseña.'},
                    { type: 'hidden', name: 'id_admin', value: datosPHP.id_admin},
                ]
        };

        generarFormulario(definicionFormulario, datosPHP.titulo);
        $(datosPHP.primerElemento).focus();
    });
</script>
