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
$agentid = "";
$email = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'LoginAdminSystem');
$connection = mysqli_connect('localhost', 'root', '', 'LoginSystem');
$connectagent = mysqli_connect('localhost', 'root', '', 'agentdatabase');

            //RESET PASSWORD STARTS HERE
//Check email exist or not then send code to user input email
if (isset($_POST['check-email'])) {
  $email = mysqli_real_escape_string($connectagent, $_POST['email']);
  $check_email = "SELECT * FROM agentprofiledetail WHERE email='$email'";
  $run_sql = mysqli_query($connectagent, $check_email);
  if(mysqli_num_rows($run_sql) > 0){
  $code = rand(999999, 111111);
  $insert_code = "UPDATE agentprofiledetail SET code = $code WHERE email = '$email'";
  $run_query =  mysqli_query($connectagent, $insert_code);
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
        $otp_code = mysqli_real_escape_string($connectagent, $_POST['otp']);
        $check_code = "SELECT * FROM agentprofiledetail WHERE code = $otp_code";
        $code_res = mysqli_query($connectagent, $check_code);
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
  $password = mysqli_real_escape_string($connectagent, $_POST['password']);
  $cpassword = mysqli_real_escape_string($connectagent, $_POST['cpassword']);
  if($password !== $cpassword){
      $errors['password'] = "Confirm password not matched!";
  }else{
      $code = 0;
      $email = $_SESSION['email']; //getting this email using session
      $encpass = md5($password);
      $update_pass = "UPDATE agentprofiledetail SET code = $code, password = '$encpass' WHERE email = '$email'";
      $run_query = mysqli_query($connectagent, $update_pass);
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

// LOGIN Agent
if (isset($_POST['login_agent'])) {
    $agentid = mysqli_real_escape_string($connectagent, $_POST['username']);
    $password = mysqli_real_escape_string($connectagent, $_POST['password']);
  
    if (empty($agentid)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM agentprofiledetail WHERE username='$agentid' AND password='$password'";
        $results = mysqli_query($connectagent, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['agentid'] = $agentid;
          $_SESSION['agentalert'] = $agentid;
          header('location: agenthome.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }

  //Accept Function
  if(isset($_POST['updatebtn'])){
    $orderid = $_POST['edit_orderid'];
    $status = 'Accepted';
    $query = "UPDATE completedorder SET agentstatus='$status' WHERE orderid='$orderid'";
    mysqli_query($db,$query);
    header('location: agenthome.php');
  }
  //Decline Function
  if(isset($_POST['declinebtn'])){
    $orderid = $_POST['edit_orderid'];
    $status = 'Decline';
    $query = "UPDATE completedorder SET agentstatus='$status' WHERE orderid='$orderid'";
    mysqli_query($db,$query);
    header('location: agenthome.php');
  }
  //quotation submit
  if(isset($_POST['quotsub'])){
    $celebname =  $_POST['celebname'];
    $orderid = $_POST['orderid'];
    $useremail = $_POST['useremail'];
    $dtd = $_POST['dtd'];
    $message = $_POST['message'];
    $price = $_POST['price'];
    $status = 'Not Paid';
    $markup = 'No';

    // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($dtd)) { array_push($errors, "Date to deliver is required"); }
  if (empty($price)) { array_push($errors, "Price is required"); }
  if (empty($message)) { array_push($errors, "Message is required"); }
 
  if (count($errors) == 0) {
    $updatecompletedorder="UPDATE completedorder SET markup='No' WHERE orderid='$orderid'";
    mysqli_query($db,$updatecompletedorder);
    
    $insertquot = "INSERT INTO quotation (orderid, useremail, celebrity, dtd, message, price, status, markup) VALUES ('$orderid','$useremail','$celebname','$dtd','$message','$price','$status','$markup')";
    $query_run=mysqli_query($db,$insertquot);    
    if($query_run){
    header('location: agenthome.php');
    }else{
      echo mysqli_error();
    }
  }else{
      echo"
                <script>
                alert('Please Fill in Correctly');
                window.location.href='createquotation.php';
                </script>
                ";
      echo mysqli_error();
    }
  }

  //upload video with orderid as video name
  if(isset($_POST['vidupload'])){
    $orderid = $_POST['orderid'];
    $useremail = $_POST['useremail'];
    $file = $_FILES['video'];

    $fileName=$file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('mp4');

    if(!in_array($fileActualExt, $allowed)){
      $_SESSION['uploadvideo'] ="You cannot upload file of this type!";
    }else{        
        $fileNameNew = $orderid.".".$fileActualExt;
        $databasename = 'Agent/video/'.$fileNameNew;
        $fileDestination = 'video/'.$fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);
        $query="INSERT INTO ordervideo (videoowner,videoname, location) VALUES ('$useremail','$orderid','$databasename')";
        mysqli_query($db,$query);
        $query_run = "UPDATE finalquotation SET vidstatus='Done' WHERE orderid='$orderid'";
        mysqli_query($db,$query_run);
        header('location: agenthome.php');          
        }
  }
?>