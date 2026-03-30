<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar datos del formulario
    $nombre   = htmlspecialchars($_POST['nombre']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $correo   = htmlspecialchars($_POST['correo']);
    $servicio = htmlspecialchars($_POST['servicio']);
    $detalles = htmlspecialchars($_POST['detalles']);

    // Configuración del correo
    $destinatario = "logisticohg@gmail.com"; // cambia por tu correo real
    $asunto = "Nueva solicitud de cotización";
    $contenido = "Nombre: $nombre\nTeléfono: $telefono\nCorreo: $correo\nServicio: $servicio\nDetalles:\n$detalles";

    $headers = "From: $correo";

    // Enviar correo
    if (mail($destinatario, $asunto, $contenido, $headers)) {
        // Mensaje de confirmación en HTML
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
          <meta charset='UTF-8'>
          <title>Cotización enviada</title>
          <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap' rel='stylesheet'>
          <link rel='stylesheet' href='style.css'>
        </head>
        <body>
          <div class='container' style='text-align:center; padding:50px;'>
            <h2>¡Gracias por tu solicitud!</h2>
            <p>Tu cotización ha sido enviada correctamente. Nos pondremos en contacto contigo pronto.</p>
            <a href='cotizador.html' class='btn btn-azul'>Volver</a>
          </div>
        </body>
        </html>";
    } else {
        // Mensaje de error estilizado
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
          <meta charset='UTF-8'>
          <title>Error en el envío</title>
          <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap' rel='stylesheet'>
          <link rel='stylesheet' href='style.css'>
        </head>
        <body>
          <div class='container' style='text-align:center; padding:50px;'>
            <h2>⚠️ Error al enviar la cotización</h2>
            <p>Hubo un problema al procesar tu solicitud. Intenta nuevamente más tarde.</p>
            <a href='cotizador.html' class='btn btn-azul'>Volver</a>
          </div>
        </body>
        </html>";
    }
}
?>
