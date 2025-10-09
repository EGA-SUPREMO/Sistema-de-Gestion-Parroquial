<script>
    function generarTabla(nombreTabla, datosPHP) {
        const campos = datosPHP.campos;
        const campos_formateados = datosPHP.campos_formateados;
        const filas = datosPHP.datos;

        if (filas?.length > 0) {
            $('#sin-registros').hide();
            $('#con-registros').show();
            
            const $cabezaTabla = $('#cabeza-tabla');
            const $cuerpoTabla = $('#cuerpo-tabla');

            $cabezaTabla.empty();
            $cuerpoTabla.empty();

            const $filaEncabezado = $('<tr>');
            campos_formateados.forEach(campo => {
                $filaEncabezado.append(`<th scope="col" class="py-3 px-4">${campo}</th>`);
            });
            $filaEncabezado.append('<th scope="col" class="py-3 px-4">Acciones</th>');
            $cabezaTabla.append($filaEncabezado);

            filas.forEach(dato => {
                const $filaDatos = $('<tr>');
                campos.forEach(campo => {
                    $filaDatos.append(`<td class="py-3 px-4">${dato[campo]}</td>`);
                });
                
                $filaDatos.append(`
                    <td class="text-center px-3">
                        <a href="index.php?c=formulario&a=mostrar&t=${nombreTabla}&id=${dato.id}" class="btn btn-sm btn-warning me-2 rounded-pill shadow-sm">
                            Editar
                        </a>

                        <form action="?c=panel&a=eliminar&t=${nombreTabla}" method="POST" onsubmit="return confirm('¿Seguro de eliminar?');">
                            <input type="hidden" name="id" value="${dato.id}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger zoom-out rounded-pill shadow-sm">
                                Eliminar
                            </button>
                        </form>
                    </td>
                `);
                $cuerpoTabla.append($filaDatos);
            });

        } else {
            $('#sin-registros').show();
            $('#con-registros').hide();
            $('#sugerencia-sin-registro').html(`¡Haz clic en 'Agregar ${datosPHP.nombre_tabla_formateado}' para empezar!`);
        }
    }
    $(document).ready(function() {
        const datosPHP = <?php echo $datos_tabla; ?>;

        const urlParams = new URLSearchParams(window.location.search);
        const nombreTabla = urlParams.get('t');

        const $agregarBtn = $('#agregar-btn');
        $agregarBtn.html('Agregar ' + datosPHP.nombre_tabla_formateado);
        $agregarBtn.attr('href', 'index.php?c=formulario&a=mostrar&t=' + nombreTabla);
        
        const $subtitulo = $('#subtitulo-tabla');
        $subtitulo.html('Listado de ' + datosPHP.nombre_tabla_formateado);

        generarTabla(nombreTabla, datosPHP);
    });
</script>
