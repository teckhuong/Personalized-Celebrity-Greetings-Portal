<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="styleadmin.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
  <form method="post" action="adminsignup.php" enctype="multipart/form-data">
  	<?php include('errors.php'); ?>
	  <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
          <?php 
          	echo $_SESSION['success']; 
          	// unset($_SESSION['success']);
          ?>
      </div>
  	<?php endif ?>
  	<div class="input-group">
  	  <label>Admin ID</label>
  	  <input type="text" name="adminid">
  	</div>
	  <div class="input-group">
  	  <label>Full Name</label>
  	  <input type="text" name="fullname">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
	<div>
		<label >Profile picture</label>
		<input type="file" name="aimage">
	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user" value="upload">Register</button>
  	</div>
  	<!-- <p>
  		Already a member? <a href="adminlogin.php">Login</a>
  	</p> -->
  </form>

</body>
</html>