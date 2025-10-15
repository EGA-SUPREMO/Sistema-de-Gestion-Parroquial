$(document).ready(function() {
    const MAX_USUARIO_LENGTH = 30;
    const MIN_USUARIO_LENGTH = 2;
    const $loginForm = $('form[action*="procesarDatos"]');
    
    const $usuarioInput = $('#usuario');
    const $contrasenaInput = $('#contrasena');
    $usuarioInput.focus();

    function showErrorAlert(message, $fieldToFocus) {

        Swal.fire({
            title: '¡Error de Validación!',
            text: message,
            icon: 'error',
            confirmButtonText: 'Entendido',
            didOpen: () => {
                const confirmButton = Swal.getConfirmButton();
                if (confirmButton) {
                    confirmButton.focus();
                }
            }
        }).then(() => {
            $usuarioInput.focus();
            $usuarioInput.select();
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
        } else if (value.length > MIN_USUARIO_LENGTH) {
            $(this).addClass('is-valid');
            $(this).next('.invalid-feedback').remove();
        } else {
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
            $(this).after('<div class="invalid-feedback">El nombre de usuario no debe ser mayor a ' + MIN_USUARIO_LENGTH + ' caracteres.</div>');
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
        }
        else if (usuario.length > MAX_USUARIO_LENGTH) {
            errorMessage = 'El nombre de usuario es demasiado largo (máximo ' + MAX_USUARIO_LENGTH + ' caracteres).';
            isValid = false;
        }
        else if (usuario.length <= MIN_USUARIO_LENGTH) {
            errorMessage = 'El nombre de usuario es demasiado corto (mínimo ' + MIN_USUARIO_LENGTH + ' caracteres).';
            isValid = false;
        }

        if (contrasena.trim() === '') {
            errorMessage = 'El campo "Contraseña" es obligatorio.';
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            showErrorAlert(errorMessage);
        }
        
    });
}); 
