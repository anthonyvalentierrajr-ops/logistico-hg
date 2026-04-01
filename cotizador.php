<?php
/**
 * Logístico HG S.A.S - Motor de Cotización Seguro
 * Este archivo procesa los datos y los envía al correo corporativo.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. LIMPIEZA Y CAPTURA DE DATOS (Sanitización)
    // Filtramos los datos para eliminar espacios extra y etiquetas peligrosas
    $nombre   = strip_tags(trim($_POST['nombre']));
    $telefono = strip_tags(trim($_POST['telefono']));
    $correo   = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $servicio = strip_tags(trim($_POST['servicio']));
    $detalles = strip_tags(trim($_POST['detalles']));

    // 2. VALIDACIÓN DE SEGURIDAD EN EL SERVIDOR
    // Verificamos que los campos obligatorios no estén vacíos y el email sea válido
    if (empty($nombre) || empty($correo) || empty($telefono) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: cotizador.html?error=datos_invalidos");
        exit;
    }

    // 3. CONFIGURACIÓN DEL CORREO
    $destinatario = "logisticohg@gmail.com"; 
    $asunto = "Nueva solicitud de cotización - Logístico HG";
    
    // Cuerpo del correo bien organizado
    $contenido = "Has recibido una nueva solicitud desde la web:\n\n";
    $contenido .= "------------------------------------------\n";
    $contenido .= "Nombre: $nombre\n";
    $contenido .= "Teléfono: $telefono\n";
    $contenido .= "Correo: $correo\n";
    $contenido .= "Servicio: $servicio\n";
    $contenido .= "Detalles:\n$detalles\n";
    $contenido .= "------------------------------------------\n";
    $contenido .= "Enviado el: " . date("d/m/Y H:i:s");

    // 4. SEGURIDAD DE CABECERAS (Evita Header Injection)
    // Usamos un correo del dominio o un "no-reply" para que los servidores no lo marquen como SPAM
    $headers = "From: no-reply@logisticohg.com\r\n"; // Cambia esto al dominio de tu hosting si es necesario
    $headers .= "Reply-To: $correo\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 5. ENVIAR CORREO
    if (mail($destinatario, $asunto, $contenido, $headers)) {
        // Respuesta HTML Exitosa
        mostrar_mensaje("¡Gracias por tu solicitud!", "Tu cotización ha sido enviada correctamente. Nos pondremos en contacto contigo pronto.", "success");
    } else {
        // Respuesta HTML Error
        mostrar_mensaje("⚠️ Error en el envío", "Hubo un problema al procesar tu solicitud. Intenta nuevamente más tarde.", "error");
    }
}

// Función para mostrar mensajes estilizados con tu CSS
function mostrar_mensaje($titulo, $mensaje, $tipo) {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
      <meta charset='UTF-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>$titulo</title>
      <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap' rel='stylesheet'>
      <link rel='stylesheet' href='style.css'>
      <style>
        .mensaje-caja { text-align:center; padding:100px 20px; max-width:600px; margin:auto; background:white; border-radius:10px; margin-top:50px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        .btn-azul { background:#003285; color:white !important; padding:12px 25px; text-decoration:none; border-radius:50px; font-weight:bold; display:inline-block; margin-top:20px; }
      </style>
    </head>
    <body style='background:#f4f4f4;'>
      <div class='mensaje-caja'>
        <h2 style='color:#003285;'>$titulo</h2>
        <p>$mensaje</p>
        <a href='cotizador.html' class='btn-azul'>Volver al sitio</a>
      </div>
    </body>
    </html>";
}
?>