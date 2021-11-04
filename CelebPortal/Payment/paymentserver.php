<?php
if(!isset($_SESSION)) { 
  session_start(); 
} 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Execption;

if (function_exists("go") === FALSE){
function go($email,$v_code)
{
require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

  $mail1 = new PHPMailer(true);

  try {

    $mail1->isSMTP();                                            
    $mail1->Host       = 'smtp.gmail.com';                     
    $mail1->SMTPAuth   = true;                                   
    $mail1->Username   = 'phptesting2@gmail.com';                     
    $mail1->Password   = 'Qwerty@111';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';                            


    $mail1->setFrom('phptesting2@gmail.com', 'Mailer');
    $mail1->addAddress($email);     
    $mail1->AddCC('trendytiger72@gmail.com');
  
  
    $mail1->isHTML(true);                                  
    $mail1->Subject = 'Order Receipt';
    $mail1->Body    = "Order Sucessful <br>Email: $email <br>OrderID : $v_code ";

    $mail1->send();
    return true;
  } 
    catch (Exception $e) {
    return false;
  }

  }
}

// initializing variables
$name = "";
$cnumber    = "";
$expmonth = "";
$expyear = "";
$cvv = "";
$email = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'OrderSystem');
$connection = mysqli_connect('localhost', 'root', '', 'LoginSystem');
// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $cnumber = mysqli_real_escape_string($db, $_POST['cnumber']);
  $expmonth = mysqli_real_escape_string($db, $_POST['expmonth']);
  $expyear = mysqli_real_escape_string($db, $_POST['expyear']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $cvv = mysqli_real_escape_string($db, $_POST['cvv']);
  $payment = 'Done';
  $v_code = $_POST['edit_id'];

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) { array_push($errors, "Name on Card is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($cnumber)) { array_push($errors, "Card Number is required"); }
  if (empty($expmonth)) { array_push($errors, "Expiriy Month is required"); }
  if (empty($expyear)) { array_push($errors, "Expiriy Year is required"); }
  if (empty($cvv)) { array_push($errors, "CVV Number is required"); }

  //By recording paid section into table, also changes the status of that order to done to prevent repeated
  //order that is paid to appear.
  if (count($errors) == 0) {
  	$query = "INSERT INTO orders (name, cnumber, expmonth, expyear, cvv, email, verfication_code) 
  			  VALUES('$name', '$cnumber', '$expmonth','$expyear','$cvv', '$email', '$v_code')";
  	if(mysqli_query($db, $query)){
    $changepayment = "UPDATE businessorder SET payment = '$payment' WHERE verification_code='$v_code'";
    $query_run = mysqli_query($connection, $changepayment);
  	if($query_run){
    $_SESSION['success'] = "You money has been deposited sucessfully. A receipt has been sent to your email address";
  	go($_POST['email'],$v_code);
    header('location: success.php');
  }else{
    echo mysqli_error();
  }
  }else{
    echo mysqli_error();
  }
}
}
?>
