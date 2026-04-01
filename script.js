/* ============================================================
    CONTROL DE NAVEGACIÓN - LOGÍSTICO HG
   ============================================================ */
document.addEventListener("click", function(event) {
    const boton = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.nav-container');

    // Si por alguna razón no existen los elementos en el HTML, no hacemos nada
    if (!boton || !menu) return;

    // 1. ABRIR / CERRAR (Clic en las 3 rayitas)
    if (boton.contains(event.target)) {
        menu.classList.toggle('active');
        return;
    }

    // 2. CIERRE AUTOMÁTICO (Solo si el menú está abierto)
    if (menu.classList.contains('active')) {
        
        // Si haces clic en un enlace (Inicio, Nosotros, etc.) se cierra
        if (event.target.tagName === 'A') {
            menu.classList.remove('active');
            return;
        }

        // Si haces clic fuera del menú azul, se cierra 
        // (Esto es lo que te funciona perfecto en Cotizador y Contacto)
        if (!menu.contains(event.target)) {
            menu.classList.remove('active');
        }
    }
});

/* ============================================================
    SEGURIDAD DE FORMULARIOS (COTIZADOR Y CONTACTO)
   ============================================================ */
document.addEventListener("submit", function(e) {
    const btn = e.target.querySelector('button[type="submit"]');
    if (btn) {
        btn.disabled = true;
        btn.innerText = "Enviando...";
    }
});