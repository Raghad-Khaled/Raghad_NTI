<?php

namespace Mail;
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader
require 'vendor/autoload.php';

abstract class Mail 
{
    protected const MAILHOST = 'smtp.mailtrap.io';
    protected const MAILUSERNAME = 'f5bd5bbde72ad1';
    protected const MAILPASSWORD = '5c8efd4cbb525b';
    protected const MAILPORT = 587;
    protected const MAILENCRYPTION = PHPMailer::ENCRYPTION_STARTTLS;
    protected PHPMailer $mail;
    public function __construct()
    {
        //Create an instance; passing `true` enables exceptions
        $this->mail = new PHPMailer(true);

        //Server settings
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = self::MAILHOST;                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = self::MAILUSERNAME;                     //SMTP username
        $this->mail->Password   = self::MAILPASSWORD;                               //SMTP password
        $this->mail->SMTPSecure = self::MAILENCRYPTION;            //Enable implicit TLS encryption
        $this->mail->Port       = self::MAILPORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
      
    }

    public abstract function send($sendTo,$meaasgeBody,$subject) : bool;
    
}
