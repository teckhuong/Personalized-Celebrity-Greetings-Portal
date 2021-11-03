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

?>