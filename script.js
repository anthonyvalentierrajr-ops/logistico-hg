document.addEventListener("DOMContentLoaded", function() {
    // Seleccionamos el botón de las 3 rayitas
    const botón = document.querySelector('.menu-toggle');
    // Seleccionamos la franja azul
    const menú = document.querySelector('.nav-container');
    // Seleccionamos los enlaces (Inicio, Nosotros, etc.)
    const enlaces = document.querySelectorAll('nav a');

    if (botón && menú) {
        // Al hacer clic en las rayitas, quitamos o ponemos la clase 'active'
        botón.addEventListener('click', function() {
            menú.classList.toggle('active');
        });

        // Al hacer clic en cualquier opción, cerramos la franja azul
        enlaces.forEach(function(enlace) {
            enlace.addEventListener('click', function() {
                menú.classList.remove('active');
            });
        });
    }
});