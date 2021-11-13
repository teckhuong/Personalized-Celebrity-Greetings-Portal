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
        header('location: Payment/payment.php');
    }else{
        echo"
                    <script>
                    alert('Please Fill in Correctly');
                    window.location.href='homepage.php';
                    </script>
                    ";
    }
  }
?>