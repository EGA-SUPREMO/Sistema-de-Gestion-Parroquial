<script>
    /*$.post('modelo/adminisrtrador_registrar.php', formData)
        .done(function(data) {

    }*/
    
    const definicionFormulario = {
        action: 'index.php?c=formulario&a=guardar&t=',
        cancelarBtn: 'index.php?c=tablas&a=mostrar&t=',
        contenedor: '#formulario-registrar-administrador',
        campos: [
            { type: 'text', name: 'nombre', label: 'Nombre de Usuario' },
            { type: 'password', name: 'password', label: 'Contraseña' },
        ]
    };

    document.addEventListener('DOMContentLoaded', () => {
        generarFormulario(definicionFormulario, 'Registrar Administrador');
        $('#nombre').focus();
    });

</script>
