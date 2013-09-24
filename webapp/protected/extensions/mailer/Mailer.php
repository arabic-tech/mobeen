<?php
require("class.phpmailer.php");

class Mailer extends CApplicationComponent {

  public static function sendHtml($from_email, $from_name, $to, $subject, $body, $sender='', $hostname='') {
    $mail = new PHPMailer();
    $mail->IsSMTP(); 
    $mail->Host = 'mail.freesoft.jo';
    $mail->port = 25;
    //$mail->SMTPAuth = false;
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = 'kefah.issa@freesoft.jo';  // SMTP username
    $mail->Password = 'sec11iso'; // SMTP password
    //$mail->SMTPDebug = true;

    $mail->From = $from_email;
    $mail->FromName = $from_name;
    $mail->AddAddress($to);
    $mail->Sender = $sender;
    $mail->Hostname = $hostname;

    $mail->IsHTML(true); 
		$mail->XMailer = ' '; // Hide X-Mailer
    $mail->CharSet = 'UTF-8';

    $mail->Subject = $subject;
    $mail->Body    = $body;

    if(!$mail->Send())
       throw new Exception("Message could not be sent.\nMailer Error: " . $mail->ErrorInfo);
  }

   public static function send($from_email, $from_name, $to, $subject, $body, $sender = '', $hostname = '') {
    $mail = new PHPMailer();
    $mail->IsSMTP(); 
    $mail->Host = 'mail.freesoft.jo';
    $mail->port = 25;
    //$mail->SMTPAuth = false;
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = 'kefah.issa@freesoft.jo';  // SMTP username
    $mail->Password = 'sec11iso'; // SMTP password


    $mail->From = $from_email;
    $mail->FromName = $from_name;
    $mail->AddAddress($to);
    $mail->Sender = $sender;
    $mail->Hostname = $hostname;

    $mail->IsHTML(false); 
		$mail->XMailer = ' '; // Hide X-Mailer
    $mail->CharSet = 'UTF-8';

    $mail->Subject = $subject;
    $mail->Body    = $body;

    if(!$mail->Send())
       throw new Exception("Message could not be sent.\nMailer Error: " . $mail->ErrorInfo);
  }
}

