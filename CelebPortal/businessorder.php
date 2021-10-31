<?php include('orderserver.php');
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: userlogin.php');
    }
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: userlogin.php");
    } 

    $usernameOrder = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <title>Business Order page</title>
        <?php include "header.php";?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" type="text/css" href="profile.css">
    </head>
    <body> 
    <?php
                    $connection = mysqli_connect("localhost","root","","LoginSystem");
                    if(isset($_POST['business'])){
                            $celebemail = $_POST['celebemail'];
                                ?>
        <section>
            <h2>Order page (Business)</h2>
            <form action="" method="POST">
                <?php include('errors.php'); ?>
                
                <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>" />
                <input type="hidden" name="celebemail" value="<?php echo $celebemail ?>"/> 
                <label for="purpose">Purpose: </label>
                <select name="purpose" id="purpose">
			        <option value="">Choose purpose</option>
			        <option value="Event">Event</option>
			        <option value="Marketing">Marketing</option>
			        <option value="Internal Comms & HR">Internal Comms & HR</option>
			        <option value="Sales">Sales</option>
			        <option value="Others">Others</option>
		        </select><br/>

                <label for="recipient">Recipient: </label><input type="text" name="recipient" id="recipient" placeholder="Name of recipient" /><br/>
                <label for="celebrity">Celebrity: </label><input type="text" name="celebrity" id="celebrity" placeholder="Name of celebrity" /><br/>
                <label>Instruction: </label>
		        <textarea name="instruction" id="instruction" rows="3" cols="70" placeholder="Enter your instruction here."></textarea><br/>

                <label for="phoneNum">Phone Number (Optional): </label><input type="text" name="phoneNum" id="phoneNum" placeholder="Phone no of user" /><br/>
                <button type="submit" class="btn" name="businessorder">Submit</button>
                <!--<input type="submit" name="businessorder" />-->
            </form>
            <?php
                    }
            ?>
        </section>
             <!-- footer -->
            <section class="d-flex-r justify-content-space-around p-1 bg-grey" id="social">
                <ul class="footerforhome d-flex-c" id="footer">
                    <p class="wsnc">For more: </p>
                    <li class="rnc"><a href="#" >Request New Celebrity</a></li>
                    <li class="rnc"><a href="#" >How to Order?</a></li>
                    <li class="rnc"><a href="#" >Contact Us</a></li>
                         </br>
                    <p>&copy; celebportal.com | Designed by Farmer Team</p>
                </ul>
                <ul class="d-flex-r">
                    <li>
                    <p>Follow us for more!</p>
                    <p>Our Social Media Platform:</p>
                        <a href="face"><i class="fab fa-facebook"></i></a>
                        <a href="twi"><i class="fab fa-twitter"></i></a>
                        <a href="ins"><i class="fab fa-instagram"></i></a>
                        <a href="you"><i class="fab fa-youtube"></i></a>
                     </li>            
                </ul>
            </section>
     </body>
    
</html>