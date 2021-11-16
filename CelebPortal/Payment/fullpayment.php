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
  <title>Full Payment</title>
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
  <div class="header">
  	<h2>Full Payment</h2>
  </div>
  <?php
  if(isset($_POST['fpay'])){
    $orderid = $_POST['orderid'];    
	$username = $_SESSION['username'];
	$connection = mysqli_connect("localhost","root","","LoginAdminSystem");
	$query="SELECT * FROM finalquotation WHERE orderid='$orderid'";
	$query_run = mysqli_query($connection, $query); 
	foreach($query_run as $row){
  ?>
  <form method="post" action="payment.php">
  <?php include('errors.php'); ?>
	<div class="col-50">        
		<label for="fname">Total Price: RM <?php echo $row['price']?></label><br>
        <label for="fname">We accept below Cards for payment.</label><br>
	</div>
	<div class="icon-container">
    <i class="fa fa-cc-visa" style="color:navy;"></i>
    <i class="fa fa-cc-amex" style="color:blue;"></i>
    <i class="fa fa-cc-mastercard" style="color:red;"></i>
    <i class="fa fa-cc-discover" style="color:orange;"></i>
    </div>
	<div class="input-group">
  	  <label>Email</label>
  	  <input type="text" name="email" value="<?php echo $row['useremail']?>" readonly>
  	</div>
	  <div class="input-group">
  	  <label>Order ID</label>
  	  <input type="text" name="edit_id" value="<?php echo $row['orderid']?>" readonly>	
  	</div>
  	<div class="input-group">
  	  <label>Name on Card</label>
  	  <input type="text" name="name">
  	</div>
	  <div class="input-group">
  	  <label>Card Number</label>
  	  <input type="number" name="cnumber" maxlength="16">
  	</div>
  	<div class="input-group">
  	  <label>Expiry Month</label>
  	  <input type="number" name="expmonth" maxlength="2">
  	</div>
  	<div class="input-group">
  	  <label>Expiry Year</label>
  	  <input type="number" name="expyear" maxlength="4">
  	</div>
  	<div class="input-group">
  	  <label>CVV</label>
  	  <input type="number" name="cvv" maxlength="3">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="fpayment">Pay</button>
  	</div>
	 <?php
	}
}
	?>
  </form>
 
</body>
</html>