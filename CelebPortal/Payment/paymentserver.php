<?php
if(!isset($_SESSION)) { 
  session_start(); 
} 
// initializing variables
$name = "";
$cnumber    = "";
$expmonth = "";
$expyear = "";
$cvv = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'OrderSystem');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $cnumber = mysqli_real_escape_string($db, $_POST['cnumber']);
  $expmonth = mysqli_real_escape_string($db, $_POST['expmonth']);
  $expyear = mysqli_real_escape_string($db, $_POST['expyear']);
  $cvv = mysqli_real_escape_string($db, $_POST['cvv']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) { array_push($errors, "Name on Card is required"); }
  if (empty($cnumber)) { array_push($errors, "Card Number is required"); }
  if (empty($expmonth)) { array_push($errors, "Expiriy Month is required"); }
  if (empty($expyear)) { array_push($errors, "Expiriy Year is required"); }
  if (empty($cvv)) { array_push($errors, "CVV Number is required"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
//   $user_check_query = "SELECT * FROM orders WHERE username='$username' OR email='$email' LIMIT 1";
//   $result = mysqli_query($db, $user_check_query);
//   $user = mysqli_fetch_assoc($result);
  
//   if ($user) { // if user exists
//     if ($user['username'] === $username) {
//       array_push($errors, "Username already exists");
//     }

//     if ($user['email'] === $email) {
//       array_push($errors, "email already exists");
//     }
//   }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$query = "INSERT INTO orders (name, cnumber, expmonth, expyear, cvv) 
  			  VALUES('$name', '$cnumber', '$expmonth','$expyear','$cvv')";
  	mysqli_query($db, $query);
  	$_SESSION['success'] = "You money has been deposited sucessfully.";
  	header('location: payment.php');
  }
}
?>
