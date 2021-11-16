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
$username = "";
$email    = "";
$fullname = "";
$dob = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'LoginSystem');
$req = mysqli_connect('localhost', 'root', '', 'requestceleb');

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
  	
    //Register admin only when image is correct
    if(!in_array($fileActualExt, $allowed)){
      $_SESSION['usersignup'] ="You cannot upload file of this type!";
    }elseif($fileSize > 5*1024*1024){
      $_SESSION['usersignup'] ="Your file is too big!";
      }else{
         $fileNameNew = $username.".".$fileActualExt;
         $fileDestination = 'profilepicture/'.$fileNameNew;
         move_uploaded_file($fileTmpName, $fileDestination);
         //Register agent into database if no error
          if (count($errors) == 0) {
            $password = md5($password_1);//encrypt the password before saving in the database
            $v_code =bin2hex(random_bytes(16));
            $query = "INSERT INTO users (username, email, password, fullname, dob, verification_code, is_verified) 
                  VALUES('$username', '$email', '$password','$fullname','$dob', '$v_code', '0')"; 
            mysqli_query($db, $query) ; 
            // go($_POST['email'],$v_code);       
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
              $mail->Subject = 'Email Verification from Celebrity Portal';
              $mail->Body    = "Thanks for registration! 
              Click the link below to verify the email address
              <a href='http://localhost/Personalized-Celebrity-Greetings-Portal/CelebPortal/verify.php?email=$email&v_code=$v_code'>Verify</a>";

              $mail->send();
              
  	        $_SESSION['usersignup'] = "You have been registered successfully. 
            Please Verify through the link on your email.";
            } catch (Exception $e){
              $alert = '<div class="alert-error">
                          <span>Something Went wrong</span>
                        </div>';
            }
          }else{
            echo mysqli_error();
          }
        }  
    //imagefunction stops here 	
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
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND is_verified='1'";
        $results = mysqli_query($db, $query);
       
          if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['userloginalert'] = "You are now logged in";
            header('location: homepage.php');
          }else {
              array_push($errors, "Wrong Username/Password Combination/Email Not Verified");
            }
        }      
    
  }

                //RESET PASSWORD STARTS HERE
//Check email exist or not then send code to user input email
if (isset($_POST['check-email'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $check_email = "SELECT * FROM users WHERE email='$email'";
  $run_sql = mysqli_query($db, $check_email);
  if(mysqli_num_rows($run_sql) > 0){
  $code = rand(999999, 111111);
  $insert_code = "UPDATE users SET code = $code WHERE email = '$email'";
  $run_query =  mysqli_query($db, $insert_code);
      if($run_query){
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
          $mail->Subject = 'Password Reset Code';
          $mail->Body    = "Your password reset code is $code";
          $info = "We've sent a password reset otp to your email - $email";
          $_SESSION['info'] = $info;
          $_SESSION['email'] = $email;
          $mail->send();      
        
          header('location: reset-code.php');
        } catch (Exception $e){
          $alert = '<div class="alert-error">
                      <span>Something Went wrong</span>
                    </div>';
        }
          }else{
              $errors['db-error'] = "Something went wrong!";
            }
    }else{
        $errors['email'] = "This email address does not exist!";
      }
}
//check whether the otp that sent is matching with the database otp
if (isset($_POST['check-reset-otp'])) {
  $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($db, $_POST['otp']);
        $check_code = "SELECT * FROM users WHERE code = $otp_code";
        $code_res = mysqli_query($db, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: new-password.php');
            exit();
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
}
//check both password that was input is matched or not then insert to database and reset code to 0
if(isset($_POST['change-password'])){
  $_SESSION['info'] = "";
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);
  if($password !== $cpassword){
      $errors['password'] = "Confirm password not matched!";
  }else{
      $code = 0;
      $email = $_SESSION['email']; //getting this email using session
      $encpass = md5($password);
      $update_pass = "UPDATE users SET code = $code, password = '$encpass' WHERE email = '$email'";
      $run_query = mysqli_query($db, $update_pass);
      if($run_query){
          $info = "Your password changed. Now you can login with your new password.";
          $_SESSION['info'] = $info;
          header('Location: password-changed.php');
      }else{
          $errors['db-error'] = "Failed to change your password!";
      }
  }
}
                //^^ RESET PASSWORD ENDS HERE ^^

//upload image in userprofile
if(isset($_FILES['profilepic'])){
  $username = $_POST['username'];
  $file = $_FILES['profilepic'];

  $fileName=$file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg');

  if(!in_array($fileActualExt, $allowed)){
    $_SESSION['profilealert'] ="You cannot upload file of this type!";
  }elseif($fileSize > 5*1024*1024){
    $_SESSION['profilealert'] ="Your file is too big!";
    }else{
       $fileNameNew = $username.".".$fileActualExt;
       $fileDestination = 'profilepicture/'.$fileNameNew;
       move_uploaded_file($fileTmpName, $fileDestination);
      } 
      header('location: userprofile.php');
}

//Request NeW Celeb
if (isset($_POST['reqceleb'])) {
  // receive all input values from the form
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $celebname = mysqli_real_escape_string($db, $_POST['celebname']);
  $celebcountry = mysqli_real_escape_string($db, $_POST['celebcountry']);
  $comments = mysqli_real_escape_string($db, $_POST['comments']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($email)) { array_push($errors, "Your Email is required"); }
  if (empty($celebname)) { array_push($errors, "Celebrity Name is required"); }
  if (empty($celebcountry)) { array_push($errors, "Celebrity Country is required"); }


  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($req, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
 

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {

  	$query = "INSERT INTO users (email, celebname, celebcountry, comments) 
  			  VALUES('$email','$celebname','$celebcountry', '$comments')";
  	mysqli_query($req, $query);
  	$_SESSION['success'] = "Thanks for your request, We will look into it.";
  }
}
?>