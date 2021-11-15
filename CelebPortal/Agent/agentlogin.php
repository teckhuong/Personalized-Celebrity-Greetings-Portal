<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Agent Login Page</title>
  <link rel="stylesheet" type="text/css" href="styleadmin.css">
</head>
<body>
  <div class="header">
  	<h2>Agent Login</h2>
  </div>
            <form method="post" action="agentlogin.php"> 
            <?php include('errors.php'); ?> 
            <?php if (isset($_SESSION['agentalert'])) : ?>
            <div class="error success" >
                <?php 
                    echo $_SESSION['agentalert']; 
                    unset($_SESSION['agentalert']);
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
                    <button type="submit" class="btn" name="login_agent">Login</button>
                </div>
                <br>
	            <div style="font-size: 0.8em; text-align: center;"><a href="forgetpassword.php">Forgot Password?</a></div>
            </form>
</body>
</html> 