document.addEventListener("DOMContentLoaded", function() {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Estado inicial del sidebar desde localStorage (opcional, para persistencia)
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.getElementById('wrapper').classList.add('toggled');
        // }

        sidebarToggle.addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('wrapper').classList.toggle('toggled');
            
            // Guardar estado en localStorage (opcional)
            // localStorage.setItem('sb|sidebar-toggle', document.getElementById('wrapper').classList.contains('toggled'));
        });
    }

    // Activar tooltips de Bootstrap si los usas
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});