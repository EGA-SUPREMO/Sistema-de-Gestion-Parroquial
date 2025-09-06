<script>
    function generarTabla(tipo, datosPHP) {

    }
    $(document).ready(function() {
        const datosPHP = <?php echo $datos['tabla']; ?>;

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
        
        generarTabla(definicionFormulario, datosPHP.titulo);
        $(datosPHP.primerElemento).focus();
    });
</script>
