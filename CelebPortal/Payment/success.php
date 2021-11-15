<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: userlogin.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: userlogin.php");
  }
?> 

<?php include('paymentserver.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Success</title>
  <link rel="stylesheet" type="text/css" href="stylepayment.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
      .col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}
  </style>
</head>
<body>
<br><br>
  <?php include('errors.php'); ?>
	  <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
          <?php 
          	echo $_SESSION['success'] = "You money has been deposited sucessfully.\nA receipt has been sent to your email address\n You will be directed to the homepage in 5 Sec...";
          	// unset($_SESSION['success']);
          ?>
      </div>
  	<?php endif ?>
      <?php 
  header( "refresh:5; url=../homepage.php" ); 
?>

</body>
</html>
