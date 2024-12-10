<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';

class SenderEmailPHPMailer
{
    private function obtenerEmailUsuario()
    {
        $sesion = new ManejoSesiones();
        $usuario = $sesion->obtenerUsuario();
        return $usuario['email'] ?? 'invitado@gmail.com'; // email predeterminado si no lo encuentra el del usaurio
    }

    private function obtenerNombreUsuario()
    {
        $sesion = new ManejoSesiones();
        $usuario = $sesion->obtenerUsuario();
        return $usuario['nombre'] ?? 'Invitado';
    }

    public function sendEmail($to, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP(); // Indicar que se usará SMTP
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
            $mail->SMTPAuth = true; // Habilitar autenticación SMTP
            $mail->Username = 'estevezgaston01@gmail.com'; // Tu correo
            $mail->Password = 'qgvpvjlzvnosdhrr'; // Contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar TLS
            $mail->Port = 587; // Puerto para TLS

            $mail->setFrom($mail->Username, 'Preguntados'); //nombre de la app de gmail que cree
            $mail->addAddress($to); // Añadir destinatario
            $mail->isHTML(true); // Habilitar HTML
            $mail->Subject = $subject; // Asunto
            $mail->Body = $message; // Cuerpo del mensaje

            $mail->send(); // Enviar correo
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }


    public function sendActivationEmail($userId, $email, $token)
    {
        $activationLink = "http://localhost/PW2MVC-PREGUNTADOS/index.php?page=registro&action=activarCuenta&id=$userId&token=$token";
        $message = "Hola, haz clic en el siguiente enlace para activar tu cuenta: <a href='$activationLink'>Activar cuenta</a>";
        $this->sendEmail($email, "Activación de cuenta", $message);
    }
}