$(document).ready(function() {
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    const errorMessage = getUrlParameter('error');

    if (errorMessage) {
        const decodedMessage = decodeURIComponent(errorMessage.replace(/\+/g, ' '));

        Swal.fire({
            title: '¡Atención!',
            text: decodedMessage,
            icon: 'error',
            confirmButtonText: 'Aceptar',
            didOpen: () => {
                const confirmButton = Swal.getConfirmButton();
                if (confirmButton) {
                    confirmButton.focus();
                }
            }
        }).then(() => {
            if (history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('error');
                history.replaceState(null, '', url);
            }
        });
    }
});