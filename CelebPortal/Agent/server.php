<?php
if(!isset($_SESSION)) { 
  session_start(); 
} 

// initializing variables
$agentid = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'LoginAdminSystem');
$connection = mysqli_connect('localhost', 'root', '', 'LoginSystem');
$connectagent = mysqli_connect('localhost', 'root', '', 'agentdatabase');


// LOGIN Agent
if (isset($_POST['login_agent'])) {
    $agentid = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
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
    $dtd = $_POST['dtd'];
    $message = $_POST['message'];
    $price = $_POST['price'];
    $status = 'Not Paid';
    $markup = 'No';
    
    $insertquot = "INSERT INTO quotation (orderid, celebrity, dtd, message, price, status, markup) VALUES ('$orderid','$celebname','$dtd','$message','$price','$status','$markup')";
    $query_run=mysqli_query($db,$insertquot);    
    if($query_run){
    header('location: agenthome.php');
    }else{
      echo mysqli_error();
    }
  }
?>