<?php
if(!isset($_SESSION)) { 
  session_start(); 
} 

// initializing variables
$email = "";
$celebname    = "";
$celebcountry = "";
$comments = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'RequestCeleb');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $celebname = mysqli_real_escape_string($db, $_POST['celebname']);
  $celebcountry = mysqli_real_escape_string($db, $_POST['celebcountry']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($email)) { array_push($errors, "Your Email is required"); }
  if (empty($celebname)) { array_push($errors, "Celebrity Name is required"); }
  if (empty($celebcountry)) { array_push($errors, "Celebrity Country is required"); }


  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
 

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {

  	$query = "INSERT INTO users (email, celebname, celebcountry, comments) 
  			  VALUES('$email','$celebname','$celebcountry', '$comments')";
  	mysqli_query($db, $query);
  	$_SESSION['success'] = "Thanks for your request, We will look into it.";
  }
}
  
  ?>
