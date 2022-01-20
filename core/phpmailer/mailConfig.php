<?php

namespace PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class mailConfig
{

    public function __construct()
    {
        return true;
    }

    public function config(){

            $mail= new PHPMailer(true);

        try {
            //configuration
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

            //configure smtp
            $mail->isSMTP();
//            $mail->Host = "smtp.gmail.com";
//            $mail->SMTPAuth="true";
//            $mail->SMTPSecure = "tls";
//            $mail->Port = 587;
//            $mail->Username = "";
//            $mail->Password = "";
            //config mailhog
            $mail->Host = "localhost";
            $mail->Port = 1025;
            //CharSet
            $mail->CharSet = "utf-8";

            //destinataires
            $mail->addAddress("remimorettimail@gmail.com");
            //Expediteur
            $mail->setFrom("morettiremimail@gmail.com");

            //contenu
            //            $mail->Subject = "Leader sur la liste principale";
            //            $mail->Body = "Refresh de la page de la liste leader";

            //envoi du mail
            //            $mail->send();

            //vérif envoi
            //            echo "mail envoyé";
            var_dump($mail);
            return $mail;

        } catch (Exception $e) {
            echo "message non envoyé. Erreur : {$mail->ErrorInfo}";
        }

    }
}