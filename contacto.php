<?php
/**
 * Logístico HG S.A.S - Motor de Contacto Seguro
 * Este archivo procesa los mensajes y los envía al correo corporativo.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. CAPTURA Y LIMPIEZA PROFUNDA (Sanitización)
    // Eliminamos etiquetas HTML y espacios en blanco accidentales
    $nombre  = strip_tags(trim($_POST['nombre']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mensaje = strip_tags(trim($_POST['mensaje']));

    // 2. VALIDACIÓN DE SEGURIDAD (Servidor)
    // Verificamos que no haya campos vacíos y que el email sea real
    if (empty($nombre) || empty($email) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Si hay un error, lo devolvemos al formulario
        header("Location: contacto.html?error=campos_invalidos");
        exit;
    }

    // 3. CONFIGURACIÓN DEL MENSAJE
    $destinatario = "info@logisticohg.com"; // Cambia esto al correo de tu empresa
    $asunto = "Nuevo mensaje de contacto - Web Logístico HG";
    
    $cuerpo = "Has recibido un nuevo mensaje desde el formulario de contacto:\n\n";
    $cuerpo .= "------------------------------------------\n";
    $cuerpo .= "Nombre: $nombre\n";
    $cuerpo .= "Correo: $email\n";
    $cuerpo .= "Mensaje:\n$mensaje\n";
    $cuerpo .= "------------------------------------------\n";
    $cuerpo .= "Fecha de envío: " . date("d/m/Y H:i:s") . "\n";
    $cuerpo .= "IP del remitente: " . $_SERVER['REMOTE_ADDR'];

    // 4. CABECERAS SEGURAS (Protección contra SPAM)
    // Usamos 'Reply-To' para que al dar "Responder" en tu Gmail le escribas al cliente.
    $headers = "From: no-reply@logisticohg.com\r\n"; 
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 5. EJECUCIÓN DEL ENVÍO
    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
        mostrar_respuesta("¡Gracias por contactarnos!", "Tu mensaje ha sido enviado correctamente. Te responderemos lo antes posible.", "success");
    } else {
        mostrar_respuesta("⚠️ Error en el envío", "Lo sentimos, hubo un problema técnico. Por favor, intenta de nuevo o escríbenos directamente por WhatsApp.", "error");
    }
}

// Función para mostrar la respuesta con el estilo de tu marca
function mostrar_respuesta($titulo, $texto, $tipo) {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
      <meta charset='UTF-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>$titulo</title>
      <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap' rel='stylesheet'>
      <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #f4f4f4; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .caja-mensaje { background: white; padding: 40px; border-radius: 15px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-width: 500px; width: 90%; }
        h2 { color: #003285; margin-bottom: 15px; }
        p { color: #555; line-height: 1.6; margin-bottom: 25px; }
        .btn-volver { background-color: #003285; color: white !important; text-decoration: none; padding: 12px 30px; border-radius: 50px; font-weight: bold; transition: 0.3s; display: inline-block; }
        .btn-volver:hover { background-color: #2A629A; transform: translateY(-3px); }
      </style>
    </head>
    <body>
      <div class='caja-mensaje'>
        <h2>$titulo</h2>
        <p>$mensaje</p>
        <a href='contacto.html' class='btn-volver'>Volver al sitio</a>
      </div>
    </body>
    </html>";
}
?>