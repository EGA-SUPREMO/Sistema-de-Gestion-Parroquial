<!--                        <div class="alert alert-info text-center py-4 rounded-3" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i> No hay administradores registrados aún.
                                <p class="mt-2">¡Haz clic en "Añadir Nuevo Administrador" para empezar!</p>
                            </div>

                                        <tr>
                                            
                                            <th scope="col" class="py-3 px-4">Nombre de Usuario</th>
                                            <th scope="col" class="py-3 px-4">Acciones</th>
                                       
                                        </tr>

-->
<script>
    function generarTabla(nombreTabla, campos, datos) {
        alert(campos);
        const $contenedor = $('#tabla-contenedor');
        const $subtitulo = $('#subtitulo-tabla');
        $subtitulo.html('Listado de ' + nombreTabla);
        
        const $agregarBtn = $('#agregar-btn');
        $agregarBtn.html('Agregar Nuevo ' + nombreTabla);
        $agregarBtn.attr('href', 'index.php?c=formulario&a=guardar&t=' + nombreTabla);

        if (datos.length > 0) {
            $('.sin-registros').hide();
            $('.con-registros').show();
            
            const $cabezaTabla = $('#cabeza-tabla');
            const $cuerpoTabla = $('#cuerpo-tabla');

            $cabezaTabla.empty();
            $cuerpoTabla.empty();

            const $filaEncabezado = $('<tr>');
            campos.forEach(campo => {
                $filaEncabezado.append(`<th scope="col" class="py-3 px-4">${campo}</th>`);
            });
            $filaEncabezado.append('<th scope="col" class="py-3 px-4">Acciones</th>');
            $cabezaTabla.append($filaEncabezado);

            datos.forEach(dato => {
                const $filaDatos = $('<tr>');
                campos.forEach(campo => {
                    $filaDatos.append(`<td class="py-3 px-4">${dato.campo}</td>`);
                });
                // Agrega el campo de Acciones
                $filaDatos.append(`
                    <td class="text-center px-3">
                        <a href="?c=peticiones&a=Editar&id="" class="btn btn-sm btn-warning me-2 rounded-pill shadow-sm">
                            Editar
                        </a>

                        <a class="btn btn-danger zoom-out rounded-pill shadow-sm"
                            onclick="javascript:return confirm('¿Seguro de eliminar ?');" href="?c=peticiones&a=Eliminar&id=">
                           Eliminar
                        </a>
                    </td>
                `);
                $cuerpoTabla.append($filaDatos);
            });

        } else {
            // Muestra el mensaje de que no hay registros si el array de datos está vacío
            $('.sin-registros').show();
            $('.con-registros').hide();
        }
    }
    $(document).ready(function() {
        const datosPHP = <?php echo $datos_tabla; ?>;

        const urlParams = new URLSearchParams(window.location.search);
        const tipo = urlParams.get('t');
        
        generarTabla(tipo, datosPHP.campos, datosPHP.datos);
    });
</script>
