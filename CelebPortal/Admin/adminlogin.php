<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" type="text/css" href="styleadmin.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
  <form method="post" action="adminlogin.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Admin ID</label>
  		<input type="text" name="adminid" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<!-- <p>
  		Not yet a member? <a href="adminsignup.php">Sign up</a>
  	</p> -->
  </form>
</body>
</html>
