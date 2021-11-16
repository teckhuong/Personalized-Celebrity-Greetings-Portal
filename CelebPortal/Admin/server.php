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
$adminid = "";
$fullname = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'LoginAdminSystem');
$connection = mysqli_connect('localhost', 'root', '', 'LoginSystem');
$connectagent = mysqli_connect('localhost', 'root', '', 'agentdatabase');
// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $adminid = mysqli_real_escape_string($db, $_POST['adminid']);
  $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  //profile pic
	$file = $_FILES['aimage'];

  $fileName=$file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg');
  //profilepic ends here  

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE adminid='$adminid' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['adminid'] === $adminid) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($adminid)) { array_push($errors, "Admin ID is required"); }
  if (empty($fullname)) { array_push($errors, "Full Name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE adminid='$adminid'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['adminid'] === $adminid) {
      array_push($errors, "Admin ID already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) { 
    if(!in_array($fileActualExt, $allowed)){
      $_SESSION['success'] ="You cannot upload file of this type!";
    }elseif($fileSize > 5*1024*1024){
      $_SESSION['success'] ="Your file is too big!";
      }else{
         $fileNameNew = $adminid.".".$fileActualExt;
         $fileDestination = 'profilepicture/'.$fileNameNew;
         move_uploaded_file($fileTmpName, $fileDestination);
         //Register agent into database if no error
          if (count($errors) == 0) {
            $password = md5($password_1);//encrypt the password before saving in the database
            $query = "INSERT INTO users (adminid, fullname, email, password) 
  			    VALUES('$adminid','$fullname','$email','$password')";
          	mysqli_query($db, $query);            
  	        $_SESSION['adminregis'] = "You have been registered successfully";
          }else{
            echo mysqli_error();
          }
        }  
  //imagefunction stops here
  	header('location: adminsignup.php');
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

// LOGIN USER
if (isset($_POST['login_user'])) {
    $adminid = mysqli_real_escape_string($db, $_POST['adminid']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($adminid)) {
        array_push($errors, "Admin ID is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE adminid='$adminid' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['adminid'] = $adminid;
          header('location: adminhome.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }

  //edit user
  if(isset($_POST['updatebtn'])){
    $id=$_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = md5($_POST['edit_password']);
    $fullname = $_POST['edit_fullname'];
    $dob = $_POST['edit_dob'];

    $query = "UPDATE users SET username='$username', email='$email', password='$password', fullname='$fullname',dob='$dob' WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run){
      $_SESSION['success'] = "Your Data is Updated!";
      header('location: userdatabase.php');
    }else{
      $_SESSION['success'] = "Your Data is Not Updated!";
      header('location: userdatabase.php');
    }
  }

  //delete user
  if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    $query = "DELETE FROM users WHERE id='$id'";
    $query_run=mysqli_query($connection, $query);

    if($query_run){
      $_SESSION['success'] = "Your Data is deleted";
      header('location: userdatabase.php');
    }else{
      $_SESSION['success'] = "Your data is not deleted";
      header('location: userdatabase.php');
    }
  }
  
  //completing order
  if(isset($_POST['editorder_btn'])){
    $id=$_POST['edit_id'];
    $username = mysqli_real_escape_string($db, $_POST['edit_username']);
    $useremail = mysqli_real_escape_string($db, $_POST['edit_useremail']);
    $orderid = mysqli_real_escape_string($db, $_POST['edit_orderid']);
    $purpose = mysqli_real_escape_string($db, $_POST['edit_purpose']);
    $sender = mysqli_real_escape_string($db, $_POST['edit_sender']);
    $recipient = mysqli_real_escape_string($db, $_POST['edit_recipient']);
    $celebrity = mysqli_real_escape_string($db, $_POST['edit_celebrity']);
    $instruction = mysqli_real_escape_string($db, $_POST['edit_instruction']);
    $details = mysqli_real_escape_string($db, $_POST['edit_details']);
    $phoneNo = mysqli_real_escape_string($db, $_POST['edit_phoneNum']);
    $status = mysqli_real_escape_string($db, $_POST['edit_status']);
    $markup = '';

    $query = "DELETE FROM businessorder WHERE Old='$id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run){
      $newquery = "INSERT INTO completedorder (username, useremail, purpose, recipient, sender, celebrity, instruction, details, phoneNum, orderid, status,markup) 
      VALUES('$username', '$useremail', '$purpose', '$recipient', '$sender','$celebrity','$instruction','$details','$phoneNo', '$orderid', '$status','$markup')";
      mysqli_query($db,$newquery);
      $_SESSION['success'] = "Order is completed!";
      header('location: completedorder.php');
    }else{
      $_SESSION['success'] = "Error happend! Could not insert!";
    }
  }
  //deleting order
  if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    $query = "DELETE FROM businessorder WHERE Old='$id'";
    $query_run=mysqli_query($connection, $query);

    if($query_run){
      $_SESSION['success'] = "Your Data is deleted";
      header('location: adminhome.php');
    }else{
      $_SESSION['success'] = "Your data is not deleted";
      header('location: adminhome.php');
    }
  }

  //register agent
  if(isset($_POST['agentreg'])){
  //initializing variable for agent register
  $agentusername = "";
  $agentpw = "";
  $agentname = "";
  $agentemail = "";
  $agentcompname = "";
  $agentcelebname = "";
  $agentphonenum = "";
  $agentdoc = "";

  //receive inputs value from form
  $agentusername = mysqli_real_escape_string($db, $_POST['username']);
  $agentpw = mysqli_real_escape_string($db, $_POST['password']);
  $agentname = mysqli_real_escape_string($db, $_POST['agentname']);
  $agentemail = mysqli_real_escape_string($db, $_POST['email']);
  $agentcompname = mysqli_real_escape_string($db, $_POST['compname']);
  $agentcelebname = mysqli_real_escape_string($db, $_POST['celebname']);
  $agentphonenum = mysqli_real_escape_string($db, $_POST['phonenum']);
  $agentdoc = mysqli_real_escape_string($db, $_POST['doc']);

  //profile pic
	 $file = $_FILES['agentimage'];

   $fileName=$file['name'];
   $fileTmpName = $file['tmp_name'];
   $fileSize = $file['size'];
   $fileError = $file['error'];
   $fileType = $file['type'];

   $fileExt = explode('.', $fileName);
   $fileActualExt = strtolower(end($fileExt));
   $allowed = array('jpg');
  //profilepic ends here

  //form validation: to check form is filled or not
  if (empty($agentusername)) { array_push($errors, "Username is required"); }
  if (empty($agentpw)) { array_push($errors, "Password is required"); }
  if (empty($agentname)) { array_push($errors, "Agent's Name is required"); }
  if (empty($agentemail)) { array_push($errors, "Agent's Email is required"); }
  if (empty($agentcompname)) { array_push($errors, "Agent's Company is required"); }
  if (empty($agentcelebname)) { array_push($errors, "Celebrity Name is required"); }
  if (empty($agentphonenum)) { array_push($errors, "Agent's Phone Number is required"); }
  if (empty($agentdoc)) { array_push($errors, "Agent's Date of Contract is required"); }
  
//   //imagefunction starts here
  if(!in_array($fileActualExt, $allowed)){
    $_SESSION['agentregisteralert'] ="You cannot upload file of this type!";
  }elseif($fileSize > 5*1024*1024){
    $_SESSION['agentregisteralert'] ="Your file is too big!";
    }else{
      if (count($errors) == 0) {
       $fileNameNew = $agentusername.".".$fileActualExt;
       $fileDestination = '../Agent/profilepicture/'.$fileNameNew;
       move_uploaded_file($fileTmpName, $fileDestination);
       //Register agent into database if no error
        
          $agentpassword = md5($agentpw);//encrypt the password before saving in the database
          $insertagent = "INSERT INTO agentprofiledetail (username, password, agentname, email, compname, celebname, phonenum, doc) 
                VALUES('$agentusername', '$agentpassword','$agentname', '$agentemail','$agentcompname','$agentcelebname','$agentphonenum','$agentdoc')";
          mysqli_query($connectagent, $insertagent);
          
          header('location: agentregister.php');
        }else{
          echo"
                    <script>
                    alert('Please Fill in Correctly');
                    window.location.href='agentregister.php';
                    </script>
                    ";
          echo mysqli_error();
        }
      }  
}

    //edit agent
    if(isset($_POST['editagent_btn'])){
      $id=$_POST['edit_id'];
      $username = $_POST['edit_username'];
      $email = $_POST['edit_email'];
      $password = md5($_POST['edit_password']);
      $agentname = $_POST['edit_agentname'];
      $compname = $_POST['edit_compname'];
      $celebname = $_POST['edit_celebname'];
      $phonenum = $_POST['edit_phonenum'];
      $doc = $_POST['edit_doc'];
  
      $updatequery = "UPDATE agentprofiledetail SET username='$username', password='$password', agentname='$agentname', email='$email', compname='$compname', celebname='$celebname', phonenum='$phonenum', doc='$doc' WHERE id='$id'";
      $query_run = mysqli_query($connectagent, $updatequery);
  
      if($query_run){
        $_SESSION['success'] = "Your Data is Updated!";
        header('location: agentdatabase.php');
      }else{
        $_SESSION['success'] = "Your Data is Not Updated!";
        header('location: agentdatabase.php');
      }
    }
  
    //delete agent
    if(isset($_POST['delete_btn'])){
      $id = $_POST['delete_id'];
      $query = "DELETE FROM agentprofiledetail WHERE id='$id'";
      $query_run=mysqli_query($connectagent, $query);  
      if($query_run){
        $_SESSION['success'] = "Your Data is deleted";
        header('location: agentdatabase.php');
      }else{
        $_SESSION['success'] = "Your data is not deleted";
        header('location: agentdatabase.php');
      }
    }
    
    //markup quotation
    if(isset($_POST['updatequot'])){
      $id=$_POST['edit_id'];
      $quotid = $_POST['quotid'];
      $useremail = $_POST['email'];
      $celebrity = $_POST['celebrity'];
      $dtd = $_POST['dtd'];
      $message = $_POST['message'];
      $price = $_POST['price'];
      $status = $_POST['status'];
      $markup = 'Yes';
      //Update markup status in completedorder table
      $updatecompletedorder="UPDATE completedorder SET markup='$markup' WHERE orderid='$quotid'";
      mysqli_query($db, $updatecompletedorder); 
      //Insert into final quotation to take record this order is being sent to user
      $insertquot = "INSERT INTO finalquotation (orderid, useremail,celebrity,dtd,message,price,status,markup) VALUES ('$quotid','$useremail','$celebrity','$dtd','$message','$price','$status','$markup')";
      mysqli_query($db, $insertquot);  
      //Update on agent side to prevent agent from sending twice same order id
      $updatequot = "UPDATE quotation SET markup='$markup' WHERE orderid='$quotid'";
      mysqli_query($db,$updatequot);
      //email generate and send
      try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'phptesting2@gmail.com'; // Gmail address which you want to use as SMTP server
        $mail->Password = 'Qwerty@111'; // Gmail address Password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '465';

        $mail->setFrom('phptesting2@gmail.com'); // Gmail address which you used as SMTP server
        $mail->addAddress($useremail); 

        $mail->isHTML(true);                                  
        $mail->Subject = 'Quotation';
        $mail->Body    = nl2br("This is the Quotation from the Celebrity.\n
        Your Order ID is $quotid.\n
        Celebrity that you have choose is $celebrity.\n
        Date to Deliver is $dtd.\n
        Message from Celebrity is $message.\n
        The full price for this Quotation is $price.\n
        Kindly visit your profile page for making full payment.\n
        Quotation will only be available within 1 week time. If not made, the quotation shall be naught.\n
        If Payment is not made, even the $dtd is within 7 days, the video will not be available to you.");

        $mail->send();
        
      $_SESSION['success'] = "Final Quotation Made";
      } catch (Exception $e){
        $alert = '<div class="alert-error">
                    <span>Something Went wrong</span>
                  </div>';
      }
      header('location: viewquotation.php');
      
    }

  //Add new Celebrity to all celeb page
  if(isset($_POST['celebreg'])){
    $celebname=$_POST['celebname'];
    $celebdescrip=$_POST['celebdescrip'];
    $tag=$_POST['tag'];
    $file = $_FILES['celebpic'];

    $fileName=$file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg');

    
    //validate empty
    if (empty($celebname)) { array_push($errors, "Celebrity Name is required"); }
    if (empty($celebdescrip)) { array_push($errors, "Celebrity Description is required"); }
    if (empty($tag)) { array_push($errors, "Category is required"); }
    
    
    if(!in_array($fileActualExt, $allowed)){
      $_SESSION['addcelebalert'] ="You cannot upload file of this type!";
    }elseif($fileSize > 5*1024*1024){
      $_SESSION['addcelebalert'] ="Your file is too big!";
      }else{         
        //Register agent into database if no error 
        if (count($errors) == 0) {
         $fileNameNew = $celebname.".".$fileActualExt;
         $fileDestination = 'categorypic/'.$fileNameNew;
         move_uploaded_file($fileTmpName, $fileDestination);        
            $insertceleb = "INSERT INTO wholeceleb (celebname,celebdescrip,celebpicture,tag) 
                  VALUES('$celebname','$celebdescrip','$fileDestination','$tag')";
            mysqli_query($db, $insertceleb);            
            header('location: addceleb.php');
          }else{
            echo"
                    <script>
                    alert('Please Fill in Correctly');
                    window.location.href='addceleb.php';
                    </script>
                    ";
            echo mysqli_error();
          }
      } 
  }

  //edit product
  if(isset($_POST['editprod'])){
    $id=$_POST['edit_id'];
    $celebname=$_POST['celebname'];
    $celebdescrip=$_POST['celebdescrip'];
    $tag=$_POST['tag'];
     $file = $_FILES['celebpic'];

     $fileName=$file['name'];
     $fileTmpName = $file['tmp_name'];
     $fileSize = $file['size'];
     $fileError = $file['error'];
     $fileType = $file['type'];

     $fileExt = explode('.', $fileName);
     $fileActualExt = strtolower(end($fileExt));
     $allowed = array('jpg');

    
    //validate empty
    if (empty($celebname)) { array_push($errors, "Celebrity Name is required"); }
    if (empty($celebdescrip)) { array_push($errors, "Celebrity Description is required"); }
    if (empty($tag)) { array_push($errors, "Category is required"); }
    
    
     if(!in_array($fileActualExt, $allowed)){
       $_SESSION['addcelebalert'] ="You cannot upload file of this type!";
     }elseif($fileSize > 5*1024*1024){
       $_SESSION['addcelebalert'] ="Your file is too big!";
       }else{         
        //update agent into database if no error 
        if (count($errors) == 0) {
         $fileNameNew = $celebname.".".$fileActualExt;
         $fileDestination = 'categorypic/'.$fileNameNew;
         move_uploaded_file($fileTmpName, $fileDestination);        
            $insertceleb = "UPDATE wholeceleb SET celebname='$celebname',celebdescrip='$celebdescrip',celebpicture='$fileDestination',tag='$tag' WHERE id='$id'";
            mysqli_query($db, $insertceleb);            
            header('location: viewproduct.php');
          }else{
            echo"
                    <script>
                    alert('Please Fill in Correctly');
                    window.location.href='viewproduct.php';
                    </script>
                    ";
            echo mysqli_error();
          }
       } 
  }

  //Edit whats new slide picture
  if(isset($_POST['newsreg'])){
    $picname = $_POST['picname'];
    $file = $_FILES['newpic'];

    $fileName=$file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg');

    if(!in_array($fileActualExt, $allowed)){
      $_SESSION['slide'] ="You cannot upload file of this type!";
    }elseif($fileSize > 5*1024*1024){
      $_SESSION['slide'] ="Your file is too big!";
      }else{
         $fileNameNew = $picname.".".$fileActualExt;
         $fileDestination = 'whatsnew/'.$fileNameNew;
         move_uploaded_file($fileTmpName, $fileDestination);
         //Register agent into database if no error
          if (count($errors) == 0) {
            $insertnews = "UPDATE whatsnew SET slidename='$picname',slidepicture='$fileDestination'"; 
            mysqli_query($db, $insertnews);
            
            header('location: editwhatsnew.php');
          }else{
            echo mysqli_error();
          }
        } 
  }
  ?>
