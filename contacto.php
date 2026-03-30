<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar datos del formulario
    $nombre  = htmlspecialchars($_POST['nombre']);
    $email   = htmlspecialchars($_POST['email']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    // Configuración del correo
    $destinatario = "logisticohg@gmail.com"; // cambia por tu correo real
    $asunto = "Nuevo mensaje desde el formulario de contacto";
    $contenido = "Nombre: $nombre\nCorreo: $email\nMensaje:\n$mensaje";

    $headers = "From: $email";

    // Enviar correo
    if (mail($destinatario, $asunto, $contenido, $headers)) {
        // Mensaje de confirmación en HTML
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
          <meta charset='UTF-8'>
          <title>Mensaje enviado</title>
          <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap' rel='stylesheet'>
          <link rel='stylesheet' href='style.css'>
        </head>
        <body>
          <div class='container' style='text-align:center; padding:50px;'>
            <h2>¡Gracias por contactarnos!</h2>
            <p>Tu mensaje ha sido enviado correctamente. Te responderemos lo antes posible.</p>
            <a href='contacto.html' class='btn btn-azul'>Volver</a>
          </div>
        </body>
        </html>";
    } else {
        echo "<p>Error al enviar el mensaje. Intenta nuevamente.</p>";
    }
}
?>
