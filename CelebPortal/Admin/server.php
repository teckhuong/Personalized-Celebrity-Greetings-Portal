<?php
if(!isset($_SESSION)) { 
  session_start(); 
} 

// initializing variables
$adminid = "";
$fullname = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'LoginAdminSystem');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $adminid = mysqli_real_escape_string($db, $_POST['adminid']);
  $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($adminid)) { array_push($errors, "Admin ID is required"); }
  if (empty($fullname)) { array_push($errors, "Full Name is required"); }
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
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (adminid, password, fullname) 
  			  VALUES('$adminid','$password','$fullname')";
  	mysqli_query($db, $query);
  	$_SESSION['success'] = "You have been registered successfully";
  	header('location: adminsignup.php');
  }
}

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
          $_SESSION['fullname'] = $fullname;
          $_SESSION['success'] = "You are now logged in";
          header('location: adminhome.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }
  
  ?>
