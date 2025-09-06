<!--                        <div class="alert alert-info text-center py-4 rounded-3" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i> No hay administradores registrados aún.
                                <p class="mt-2">¡Haz clic en "Añadir Nuevo Administrador" para empezar!</p>
                            </div>

-->
<script>
    function generarTabla(nombreTabla, campos, campos_formateados, datos) {
        const $contenedor = $('#tabla-contenedor');
        const $subtitulo = $('#subtitulo-tabla');
        $subtitulo.html('Listado de ' + nombreTabla);
        
        const $agregarBtn = $('#agregar-btn');
        $agregarBtn.html('Agregar Nuevo ' + nombreTabla);
        $agregarBtn.attr('href', 'index.php?c=formulario&a=guardar&t=' + nombreTabla);

        if (datos.length > 0) {
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

            datos.forEach(dato => {
                const $filaDatos = $('<tr>');
                campos.forEach(campo => {
                    $filaDatos.append(`<td class="py-3 px-4">${dato[campo]}</td>`);
                });
                // Agrega el campo de Acciones
                $filaDatos.append(`
                    <td class="text-center px-3">
                        <a href="index.php?c=formulario&a=guardar&t=${nombreTabla}&id=${dato.id}" class="btn btn-sm btn-warning me-2 rounded-pill shadow-sm">
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
        }
    }
    $(document).ready(function() {
        const datosPHP = <?php echo $datos_tabla; ?>;

        const urlParams = new URLSearchParams(window.location.search);
        const tipo = urlParams.get('t');
        
        generarTabla(tipo, datosPHP.campos, datosPHP.campos_formateados, datosPHP.datos);
    });
</script>
