<?php require_once "server.php"; ?>
<?php
if($_SESSION['info'] == false){
    header('Location: userlogin.php');  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="adminhome.css">
</head>
<body>
    <div class="fpcontainer">
        <div class="fprow">
            <div class="col-md-4 offset-md-4 fpform login-form">
            <?php 
            if(isset($_SESSION['info'])){
                ?>
                <div class="alert alert-success text-center">
                <?php echo $_SESSION['info']; ?>
                </div>
                <?php
            }
            ?>
                <form action="adminlogin.php" method="POST">
                    <div class="fpform-group">
                        <input class="fpform-control button" type="submit" name="login-now" value="Login Now">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>