<?php
/**
 * Created by PhpStorm.
 * User: 49176
 * Date: 08.12.2020
 * Time: 12:41
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require './vendor/autoload.php';

// Instantiation and passing `true` enables exceptions

class cls_Email
{

  public $hostName = "ionos.de";
  public $host = "smtp.ionos.de";
  private $userName = "anmeldung@diwan-marburg.de";
  private $password = "Anmeldung1342!";
  public $SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  //ENCRYPTION_STARTTLS = 'tls'; ENCRYPTION_SMTPS = 'ssl'; Enable TLS encryption;
  public $port = 25;
  public $senderName = "DIWAN-Marburg Akademie";

  public $toEmailAddress = "mohsendana2010@yahoo.com";
  public $toEmailName = "Sample Text Email Name";

  public $infoDiwanMail = "info@diwan-marburg.de";

  public $subject = "Sample Subject";
  public $body = 'Sample Body';


  public function sendEmail($emailAddress, $emailName, $subject, $body, $addcc= true)
  {
    $this->toEmailAddress = $emailAddress;
    $this->toEmailName = $emailName;
    $this->body = $body;
    $this->subject = $subject;
    $this->mailSend1($addcc);
//    $this->mailSend2();

  }

  public function mailSend1($addcc)
  {
    $mail = new PHPMailer(true);
    try {
      //Server settings
      $mail->CharSet = 'utf-8';
//      $mail->SMTPDebug = SMTP::DEBUG_SERVER;   // Enable verbose debug output
      $mail->isSMTP();                         // Send using SMTP
      $mail->Hostname = $this->hostName;
      $mail->Host = $this->host;               // Set the SMTP server to send through
      $mail->SMTPAuth = true;                  // Enable SMTP authentication
      $mail->Username = $this->userName;       // SMTP username
      $mail->Password = $this->password;       // SMTP password
      $mail->SMTPSecure = $this->SMTPSecure;   //ENCRYPTION_STARTTLS ENCRYPTION_SMTPS Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port = $this->port;               // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );

      //Recipients

      $mail->From = $this->userName;
      $mail->setFrom($this->userName, $this->senderName);
      $mail->addAddress($this->toEmailAddress, $this->toEmailName);     // Add a recipient
//     $mail->addAddress('ellen@example.com');               // Name is optional
      $mail->addReplyTo($this->infoDiwanMail, 'Anmeldungs Reply');
      if ($addcc){
        $mail->addCC($this->infoDiwanMail);
      }
      $mail->addBCC('m.dana@diwan-marburg.de');
//      $mail->addBCC($this->infoDiwanMail);

      // Attachments
//      $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//      $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $this->subject;
      $mail->Body = $this->body;

      $mail->send();
      return 'Message has been sent';
    } catch (Exception $e) {
      return "Message could not be sent. Mailer Error 111: {$mail->ErrorInfo}";
    }
  }

  public function mailSend2()
  {
    $mail = new PHPMailer(true);
    try {
      //Server settings
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Hostname = "gmail.com";
      $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
      $mail->SMTPAuth = true;                                   // Enable SMTP authentication
      $mail->Username = 'mohsendana2010@gmail.com';                     // SMTP username
      $mail->Password = 'Mohsen2740702-Dana';                   // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //ENCRYPTION_STARTTLS = 'tls'; ENCRYPTION_SMTPS = 'ssl'; Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );

      //Recipients

      $mail->From = 'mohsendana2010@gmail.com';
      $mail->setFrom('mohsendana2010@gmail.com', 'Mohsen d2010');
      $mail->addAddress('mohsendana2010@yahoo.com', 'Joe User');     // Add a recipient
//      $mail->addAddress('ellen@example.com');               // Name is optional
//      $mail->addReplyTo('info@example.com', 'Information');
//      $mail->addCC('cc@example.com');
//      $mail->addBCC('bcc@example.com');

      // Attachments
//      $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//      $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Here is the subject';
      $mail->Body = 'This is the HTML message body <b>in bold!</b>';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();
      return 'Message has been sent';
    } catch (Exception $e) {
      return "Message could not be sent. Mailer Error gmail: {$mail->ErrorInfo}";
    }
  }


}
