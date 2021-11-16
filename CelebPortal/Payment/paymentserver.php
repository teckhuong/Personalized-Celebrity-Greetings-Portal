<?php
if(!isset($_SESSION)) { 
  session_start(); 
} 


use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);

$alert = '';

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
$connectadmin = mysqli_connect('localhost', 'root', '', 'LoginAdminSystem');
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
  	$query = "INSERT INTO orders (name, cnumber, expmonth, expyear, cvv, email, verification_code) 
  			  VALUES('$name', '$cnumber', '$expmonth','$expyear','$cvv', '$email', '$v_code')";
          $_SESSION['success'] = "You money has been deposited sucessfully. A receipt has been sent to your email address";
          mysqli_query($db, $query);
    
          try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'phptesting2@gmail.com'; // Gmail address which you want to use as SMTP server
            $mail->Password = 'Qwerty@111'; // Gmail address Password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = '465';

            $mail->setFrom('phptesting2@gmail.com'); // Gmail address which you used as SMTP server
            $mail->addAddress($email); 

            $mail->isHTML(true);                                  
            $mail->Subject = 'Order Receipt';
            $mail->Body    = nl2br("Your order has been placed successfully.\n
            Your Order ID is $v_code.\n
            Kindly see your profile page in the website for status or wait for our email within 2-3 working day.");

            $mail->send();
            
          $_SESSION['success'] = "You have been registered successfully. 
          Please Verify through the link on your email.";
          } catch (Exception $e){
            $alert = '<div class="alert-error">
                        <span>Something Went wrong</span>
                      </div>';
          }      

    $changepayment = "UPDATE businessorder SET payment = '$payment' WHERE verification_code='$v_code'";
    mysqli_query($connection, $changepayment);
    // go($_POST['email'],$v_code);
    header('location: success.php');
 
  }
}

//fullpayment page
if (isset($_POST['fpayment'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $cnumber = mysqli_real_escape_string($db, $_POST['cnumber']);
  $expmonth = mysqli_real_escape_string($db, $_POST['expmonth']);
  $expyear = mysqli_real_escape_string($db, $_POST['expyear']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $cvv = mysqli_real_escape_string($db, $_POST['cvv']);
  $payment = 'Paid';
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
  	$query = "INSERT INTO fullpayment (email,orderid, name, cnumber, expmonth, expyear, cvv) 
  			  VALUES('$email','$v_code', '$name', '$cnumber', '$expmonth','$expyear','$cvv')";
          
          mysqli_query($db, $query);
    
          try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'phptesting2@gmail.com'; // Gmail address which you want to use as SMTP server
            $mail->Password = 'Qwerty@111'; // Gmail address Password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = '465';

            $mail->setFrom('phptesting2@gmail.com'); // Gmail address which you used as SMTP server
            $mail->addAddress($email); 

            $mail->isHTML(true);                                  
            $mail->Subject = 'Order Receipt';
            $mail->Body    = nl2br("Your order has been fully paid.\n
            Your Order ID is $v_code.\n
            Kindly see your profile page in the website for the video when the day of delivery has come.");

            $mail->send();
          } catch (Exception $e){
            $alert = '<div class="alert-error">
                        <span>Something Went wrong</span>
                      </div>';
          }      
    //update final quotation status to paid
    $changefpq = "UPDATE finalquotation SET status = '$payment' WHERE orderid='$v_code'";
    mysqli_query($connectadmin, $changefpq);
    //update quotation status to paid
    $changeq = "UPDATE quotation SET status = '$payment' WHERE orderid='$v_code'";
    mysqli_query($connectadmin, $changeq);
    // go($_POST['email'],$v_code);
    header('location: success.php');
 
  }
}
?>
