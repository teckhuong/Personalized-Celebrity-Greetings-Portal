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
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="userlogin.php">
  	<?php include('errors.php'); ?>
	  	<?php if (isset($_SESSION['userloginalert'])) : ?>
            <div class="error success" >
                <?php 
                    echo $_SESSION['userloginalert']; 
                    // unset($_SESSION['success']);
                ?>
            </div>
        <?php endif ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="userSignup.php">Sign up</a>
  	</p>
	  <br>
	  <div style="font-size: 0.8em; text-align: center;"><a href="enter_email.php">Forgot Password?</a></div>
  </form>
</body>
</html>