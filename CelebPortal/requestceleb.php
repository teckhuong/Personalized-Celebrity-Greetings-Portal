<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Request Form</title>
  <?php include "header.php";?>
  <link rel="stylesheet" type="text/css" href="styleuser.css">
</head>
<body>
<br><br>
  <div class="header">
  	<h2>Request a Celebrity</h2>
  </div>
  <form method="post" action="requestceleb.php">
  	<?php include('errors.php'); ?>
	  <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      </div>
  	<?php endif ?>
  	<div class="input-group">
  	  <label>Your Email</label>
  	  <input type="email" name="email">
  	</div>
  	<div class="input-group">
  	  <label>Celebrity Name</label>
  	  <input type="text" name="celebname">
  	</div>
  	<div class="input-group">
  	  <label>Celebrity Country</label>
  	  <input type="text" name="celebcountry">
  	</div>
	  <div class="input-group">
  	  <label>Comments</label>
  	  <input type="message" name="comments">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reqceleb">Request</button>
  	</div>
  </form>
</body>
</html>
