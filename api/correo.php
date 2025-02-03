<?php
require "./libs/PHPMailer/src/PHPMailer.php";
require "./libs/PHPMailer/src/SMTP.php";
require "./libs/PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar credenciales del email
$emailConfig = require("../config/config_email.php");

$mail = new PHPMailer(true);

try {
    // Configurar el servidor SMTP
    $mail->isSMTP();
    $mail->Host = $emailConfig["host"];
    $mail->SMTPAuth = true;
    $mail->Username = $emailConfig["username"];
    $mail->Password = $emailConfig["password"];
    $mail->SMTPSecure = $emailConfig["encryption"];
    $mail->Port = $emailConfig["port"];

    // Configurar remitente y destinatario
    $mail->setFrom($emailConfig["username"], "Prueba de PHPMailer");
    $mail->addAddress("test-3i9w6msuz@srv1.mail-tester.com", "Usuario de Prueba");

    // Configurar contenido del correo
    $mail->isHTML(true);
    $mail->Subject = "Correo de Prueba - PHPMailer";
    $mail->Body = "<h2>¡Hola! 🚀</h2><p>Este es un correo de prueba enviado con PHPMailer desde tu servidor.</p>";

    // Enviar correo
    $mail->send();
    echo "✅ Correo enviado con éxito a tuemail@gmail.com";
} catch (Exception $e) {
    echo "❌ Error al enviar correo: {$mail->ErrorInfo}";
}
?>
