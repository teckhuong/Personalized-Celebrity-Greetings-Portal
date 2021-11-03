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
            <form method="post" action="server.php">                
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
            </form>
</body>
</html> 