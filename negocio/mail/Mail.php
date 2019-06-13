<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail {

    public function notificacionAuditorio($nombre, $apellido, $auditorio, $correo, $respuesta, $observaciones) {
        require 'vendor/autoload.php';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "beclufps2018@gmail.com";
            $mail->Password = "@dminbecl2018";
            $mail->setFrom('AdminBiblioteca@gmail.com','Biblioteca Eduardo Cote Lamus');
            $mail->addAddress($correo);
            $mail->isHTML(true);

            $mail->Subject = 'Solicitud, Prestamo de Auditorio'; //asunto

            $mail->Body = $this->plantillaMensaje($nombre, $apellido,$auditorio, $respuesta, $observaciones); //mensaje
            
            $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));

            $exito = $mail->send(); //enviar    
        } catch (Exception $e) {
            throw new Exception('No lograste enviar el correo ');
        }
        return $exito;
    }

    function plantillaMensaje($nombre, $apellido,$auditorio, $respuesta, $observaciones){
        $plantilla = '<div><strong>Estimado(a) '.$nombre.' '.$apellido.'</strong><br><br>
                      La administración de la Biblioteca Eduardo Cote Lamus le informa que su solicitud para el prestamo del auditorio '.$auditorio.' ha sido <strong>'.$respuesta.'.</strong><br><br>
                      Observaciones:<br>
                      '.$observaciones.'<br><br>
                      Cordial Saludo,<br><br><br>
                      Alexis Quintero<br>
                      _________________________________<br>
                      Practicante Plataforma Tecnológica<br>
                      Biblioteca Eduardo Cote Lamus<br>
                      UFPS<br><br><br>
                      **********************NO RESPONDER - Mensaje Generado Automáticamente**********************<br>
                      Este correo es únicamente informativo y es de uso exclusivo del destinatario(a), puede contener información privilegiada y/o confidencial.
                      </div>';
        return $plantilla;
    }
}
