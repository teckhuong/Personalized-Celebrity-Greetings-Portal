<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);

$alert = '';

if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  $subject = $_POST['subject'];

  try{
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'phptesting2@gmail.com'; // Gmail address which you want to use as SMTP server
    $mail->Password = 'Qwerty@111'; // Gmail address Password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = '465';

    $mail->setFrom('phptesting2@gmail.com'); // Gmail address which you used as SMTP server
    $mail->addAddress('phptesting2@gmail.com'); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)
    // $mail->AddCC('findphiliptiong@gmail.com'); // Email CC to send to someone as well

    $mail->isHTML(true);
    $mail->Subject = "Message Received (Contact Page) $subject";
    $mail->Body = "<h3>Name : $name <br>Email: $email <br>Message : $message</h3>";

    $mail->send();
    $alert = '<div class="alert-success">
                 <span>Message Sent! Thank you for contacting us.</span>
                </div>';
  } catch (Exception $e){
    $alert = '<div class="alert-error">
                <span>'.$e->getMessage().'</span>
              </div>';
  }
}
?>