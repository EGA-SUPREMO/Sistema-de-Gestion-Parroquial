$(document).ready(function() {
    
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    const errorMessage = getUrlParameter('error');
    const $container = $('#error-message-container');

    if (errorMessage) {
        const decodedMessage = decodeURIComponent(errorMessage.replace(/\+/g, ' '));
        
        $container.html(`
            <div style="
                background-color: #f8d7da; 
                color: #721c24; 
                border: 1px solid #f5c6cb; 
                padding: 15px; 
                margin-bottom: 20px; 
                border-radius: 4px;"
            >
                <strong>¡Atención!</strong> ${decodedMessage}
            </div>
        `).show();
        if (history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('error');
            history.replaceState(null, '', url);
        }
    }
});
