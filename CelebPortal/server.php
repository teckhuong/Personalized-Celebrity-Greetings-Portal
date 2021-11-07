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
    <a href='http://localhost/CelebPortalNEWW/verify.php?email=$email&v_code=$v_code'>Verify</a>";

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

//profile pic
$file = $_FILES['userimage'];

$fileName=$file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileError = $file['error'];
$fileType = $file['type'];

$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

$allowed = array('jpg');
//profilepic ends here

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
  	
    ///imagefunction starts here
    if(in_array($fileActualExt, $allowed)){
      if($fileError === 0){
        if($fileSize < 1000000){
        $fileNameNew = $username.".".$fileActualExt;
        $fileDestination = 'profilepicture/'.$fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);
        }else{
          echo "Your file is too big!";
        }    
    }else{
      echo "There was an error uploading your file!";
    }
  }else{
    echo "You cannot upload file of this type!";
  }
  //imagefunction stops here
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

  /*
  Accept email of user whose password is to be reset
  Send email to user to reset their password
*/

if (isset($_POST['reset-password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  // ensure that the user exists on our system
  $query = "SELECT email FROM users WHERE email='$email'";
  $results = mysqli_query($db, $query);

  if (empty($email)) {
    array_push($errors, "Your email is required");
  }else if(mysqli_num_rows($results) <= 0) {
    array_push($errors, "Sorry, no user exists on our system with that email");
  }
  // generate a unique random token of length 100
  $token = bin2hex(random_bytes(50));

  if (count($errors) == 0) {
    // store token in the password-reset database table against the user's email
    $sql = "INSERT INTO password_resets(email, token) VALUES ('$email', '$token')";
    $results = mysqli_query($db, $sql);

    // Send email to user with the token in a link they can click on
    $to = $email;
    $subject = "Reset your password on examplesite.com";
    $msg = "Hi there, click on this <a href=\"new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
    $msg = wordwrap($msg,70);
    $headers = "From: phptesting2@gmail.com";
    mail($to, $subject, $msg, $headers);
    header('location: pending.php?email=' . $email);
  }
}

// ENTER A NEW PASSWORD
if (isset($_POST['new_password'])) {
  $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
  $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);

  // Grab to token that came from the email link
  $token = $_SESSION['token'];
  if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
  if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");
  if (count($errors) == 0) {
    // select email address of user from the password_reset table 
    $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
    $results = mysqli_query($db, $sql);
    $email = mysqli_fetch_assoc($results)['email'];

    if ($email) {
      $new_pass = md5($new_pass);
      $sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
      $results = mysqli_query($db, $sql);
      header('location: homepage.php');
    }
  }
} 

?>