<?php

namespace Mail;
use Mail\Mail;
use PHPMailer\PHPMailer\Exception;

class ForgetPasswordMail extends Mail
{
    public function send($sendTo,$meaasgeBody,$subject): bool{
        try {

            //Recipients
            //$this->mail->setFrom('from@example.com', 'Ecommerce team');
            $this->mail->addAddress($sendTo);     //Add a recipient
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $meaasgeBody;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}