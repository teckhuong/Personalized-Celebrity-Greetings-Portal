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
    $useremail = $_POST['useremail'];
    $dtd = $_POST['dtd'];
    $message = $_POST['message'];
    $price = $_POST['price'];
    $status = 'Not Paid';
    $markup = 'No';
    $updatecompletedorder="UPDATE completedorder SET markup='No' WHERE orderid='$orderid'";
    mysqli_query($db,$updatecompletedorder);
    
    $insertquot = "INSERT INTO quotation (orderid, useremail, celebrity, dtd, message, price, status, markup) VALUES ('$orderid','$useremail','$celebname','$dtd','$message','$price','$status','$markup')";
    $query_run=mysqli_query($db,$insertquot);    
    if($query_run){
    header('location: agenthome.php');
    }else{
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
      $_SESSION['success'] ="You cannot upload file of this type!";
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