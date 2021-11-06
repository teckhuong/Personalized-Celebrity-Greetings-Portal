<?php
if(!isset($_SESSION)) { 
  session_start(); 
} 

// initializing variables
$username = "";
$useremail = "";
$orderid = "";
$purpose = "";
$recipient = "";
$celebrity = "";
$instruction = "";
$phoneNo = "";
$occassion = "";
$actionReq = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'LoginSystem');

// BUSINESS ORDER PAGE
if (isset($_POST['businessorder'])) {
    // receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $useremail = mysqli_real_escape_string($db, $_POST['useremail']);
    $purpose = mysqli_real_escape_string($db, $_POST['purpose']);
    $recipient = mysqli_real_escape_string($db, $_POST['recipient']);
    $celebrity = mysqli_real_escape_string($db, $_POST['celebname']);
    $instruction = mysqli_real_escape_string($db, $_POST['instruction']);
    $details = mysqli_real_escape_string($db, $_POST['details']);
    $phoneNo = mysqli_real_escape_string($db, $_POST['phoneNum']);
    $sender = mysqli_real_escape_string($db,$_POST['sender']);
    $payment = 'No';
  
  
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($purpose)) { array_push($errors, "Purpose is required"); }
    if (empty($recipient)) { array_push($errors, "Name of recipient is required"); }
    if (empty($sender)) { array_push($errors, "Name of sender is required"); }
    if (empty($celebrity)) { array_push($errors, "Name of Celebrity is required"); }
    if (empty($instruction)) { array_push($errors, "Instruction is required"); }
  
    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $v_code =bin2hex(random_bytes(2));
        $query = "INSERT INTO businessorder (username, useremail, purpose, recipient, sender, celebrity, instruction, details, phoneNum, verification_code, payment) 
                  VALUES('$username','$useremail', '$purpose','$recipient','$sender','$celebrity','$instruction','$details','$phoneNo','$v_code', '$payment')";
        mysqli_query($db, $query);
        //$_SESSION['received'] = "Your order has received successfully";
        header('location: Payment/payment.php');
    }
  }
  
  // PERSONAL ORDER PAGE
  if (isset($_POST['personalorder'])) {
      $username = mysqli_real_escape_string($db, $_POST['username']);
      $recipient = mysqli_real_escape_string($db, $_POST['recipient']);
      $celebrity = mysqli_real_escape_string($db, $_POST['celebrity']);
      $occassion = mysqli_real_escape_string($db, $_POST['occassion']);
      $instruction = mysqli_real_escape_string($db, $_POST['instruct']);
      $actionReq = mysqli_real_escape_string($db, $_POST['actionReq']);
      $phoneNo = mysqli_real_escape_string($db, $_POST['phoneNum']);
    
  
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
      if (empty($recipient)) {
          array_push($errors, "Name of recipient is required");
      }
      if (empty($celebrity)) {
          array_push($errors, "Name of Celebrity is required");
      }
      if (empty($occassion)) {
        array_push($errors, "Occassion is required");
      }
      if (empty($instruction)) {
        array_push($errors, "Instruction is required");
      }
  
    
      if (count($errors) == 0) {
        $query = "INSERT INTO personalorder (username, recipient, celebrity, occassion, instruction, actionReq, phoneNum) 
        VALUES('$username','$recipient','$celebrity','$occassion','$instruction','$actionReq' ,'$phoneNo')";
        mysqli_query($db, $query);
        $_SESSION['received'] = "Your order has received successfully";
        header('location: Payment/payment.php');
      }
    }
    ?>