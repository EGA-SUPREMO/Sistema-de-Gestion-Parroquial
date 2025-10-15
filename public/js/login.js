$(document).ready(function() {
    const MAX_USUARIO_LENGTH = 30;
    const $loginForm = $('form[action*="procesarDatos"]');
    
    const $usuarioInput = $('#usuario');
    const $contrasenaInput = $('#contrasena');
    $usuarioInput.focus();

    function showErrorAlert(message, $fieldToFocus) {
        Swal.fire({
            title: '¡Error de Validación!',
            text: message,
            icon: 'error',
            confirmButtonText: 'Entendido'
        }).then(() => {
            if ($fieldToFocus) {
                $fieldToFocus.focus();
                $fieldToFocus.select(); 
            }
        });
    }

    // --- 1. Validación en tiempo real al escribir (keyup event) ---

    $usuarioInput.on('keyup', function() {
        const value = $(this).val();
        
        // Remover cualquier clase de validación previa
        $(this).removeClass('is-valid is-invalid');

        if (value.length > MAX_USUARIO_LENGTH) {
            // Marca el campo como inválido
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').remove(); // Quita el mensaje anterior si existe
            $(this).after('<div class="invalid-feedback">El usuario no puede exceder los ' + MAX_USUARIO_LENGTH + ' caracteres.</div>');
        } else if (value.length > 0) {
            // Marca como válido si no excede el límite y tiene contenido
            $(this).addClass('is-valid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    $loginForm.on('submit', function(e) {
        let isValid = true;
        const usuario = $usuarioInput.val();
        const contrasena = $contrasenaInput.val();
        let errorMessage = '';
        let $fieldToFocus;

        if (usuario.trim() === '') {
            errorMessage = 'El campo "Usuario" es obligatorio.';
            isValid = false;
            $fieldToFocus = $usuarioInput;
        }
        else if (usuario.length > MAX_USUARIO_LENGTH) {
            errorMessage = 'El nombre de usuario es demasiado largo (máximo ' + MAX_USUARIO_LENGTH + ' caracteres).';
            $fieldToFocus = $usuarioInput;
            isValid = false;
        }

        if (contrasena.trim() === '') {
            errorMessage = 'El campo "Contraseña" es obligatorio.';
            $fieldToFocus = $contrasenaInput;
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            showErrorAlert(errorMessage, $fieldToFocus);
        }
        
    });
}); 
