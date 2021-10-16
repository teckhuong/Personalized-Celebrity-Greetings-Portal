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
  
  
    $mail1->isHTML(true);                                  
    $mail1->Subject = 'Email Verification from Celebrity Portal';
    $mail1->Body    = "Thanks for registration! 
    Click the link below to verify the email address
    <a href='http://localhost/CelebPortalNEW/verify.php?email=$email&v_code=$v_code'>Verify</a>";

    $mail1->send();
    return true;
  } 
    catch (Exception $e) {
    return false;
  }

  }
}

// initializing variables
$username = "";
$email    = "";
$fullname = "";
$dob = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'LoginSystem');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
  $dob = mysqli_real_escape_string($db, $_POST['dob']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($fullname)) { array_push($errors, "Full Name is required"); }
  if (empty($dob)) { array_push($errors, "Date of birth is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database
    $v_code =bin2hex(random_bytes(16));
  	$query = "INSERT INTO users (username, email, password, fullname, dob, verification_code, is_verified) 
  			  VALUES('$username', '$email', '$password','$fullname','$dob', '$v_code', '0')";
  	mysqli_query($db, $query) && go($_POST['email'],$v_code);
  	$_SESSION['success'] = "You have been registered successfully. 
    Please Verify through the link on your email.";
  	header('location: userSignup.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);

        $result_fetch=mysqli_fetch_assoc($results);
        if($result_fetch['is_verified']== 1){
          if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: homepage.php');
          }else {
              array_push($errors, "Wrong username/password combination");
          }
        }
        else{
          echo"
                    <script>
                    alert('Email not verified');
                    window.location.href='userlogin.php';
                    </script>
                    ";
        }
      
    }
  }
  
  ?>


