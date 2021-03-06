<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="styleadmin.css">
</head>
<body>
  <div class="header">
  	<h2>Admin Register</h2>
  </div>
  <form method="post" action="adminsignup.php" enctype="multipart/form-data">
  	<?php include('errors.php'); ?>
	  <?php if (isset($_SESSION['adminregis'])) : ?>
      <div class="error success" >
          <?php 
          	echo $_SESSION['adminregis']; 
          	unset($_SESSION['adminregis']);
          ?>
      </div>
  	<?php endif ?>
  	<div class="input-group">
  	  <label>Admin ID*</label>
  	  <input type="text" name="adminid" >
  	</div>
	  <div class="input-group">
  	  <label>Full Name*</label>
  	  <input type="text" name="fullname">
  	</div>
	<div class="input-group">
  	  <label>Email*</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password*</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password*</label>
  	  <input type="password" name="password_2">
  	</div>
	<div>
		<label >Profile picture*  (Only jpg, Not more than 5 MB)</label>
		<input type="file" name="aimage">
		<h6 style="color:red">*Picture is compulsory*</h6>
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