<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
<?php include "header.php";?>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="styleuser.css">
</head>
<body>
<br><br>
  <div class="header">
  	<h2>Register</h2>
  </div>
  <form method="post" action="server.php" enctype="multipart/form-data">
  	<?php include('errors.php'); ?>
	  <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
          <?php 
          	echo $_SESSION['success']; 
          	// unset($_SESSION['success']);
          ?>
      </div>
  	<?php endif ?>
  	<div class="input-group" >
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
	  <div class="input-group">
  	  <label>Full Name</label>
  	  <input type="text" name="fullname">
  	</div>
	  <div class="input-group">
  	  <label>Date of Birth</label>
  	  <input type="date" name="dob">
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
	<div class="input-group">
		<label >Profile picture</label>
		<input type="file" name="userimage">
	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="userlogin.php">Login</a>
  	</p>
  </form>
</body>
</html>
