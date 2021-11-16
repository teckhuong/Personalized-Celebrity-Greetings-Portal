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
        <title>Order page</title>
        <?php include "header.php";?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" type="text/css" href="profile.css">
    </head>
    <body> 
    <?php
        $temp=$_SESSION['username'];
         $connection = mysqli_connect("localhost","root","","LoginSystem");
        if(isset($_POST['business'])){
            $celebname = $_POST['celebname'];

            $getemail = "SELECT * FROM users WHERE username='$temp'";
            $query_run=mysqli_query($connection,$getemail);
            foreach($query_run as $row){
                $useremail = $row['email'];
            }
    ?>
        <section class="orderow">
            <h2>Order Form</h2>
            <div class="form-container">
            <form action="orderserver.php" method="POST">
                <input type="hidden" name="useremail" value="<?php echo $useremail ?>"/> 
                <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>" />
                <input type="hidden" name="celebname" value="<?php echo $celebname ?>"/> 
                <div class="wrapper">
                    <div class="one">
                <?php
                    if(isset($_POST["business"])) {
                        $type = "Business";
                        echo "<label for='purpose'>Category: <br/></label>";
                        echo "<select name='purpose' id='purpose'>";
			            echo "<option value=''>Choose Category</option>";
			            echo "<option value='Event'>Event</option>";
			            echo "<option value='Marketing'>Marketing</option>";
                        echo "<option value='Advertising'>Advertising</option>";
			            echo "<option value='Internal Comms & HR'>Internal Comms & HR</option>";
			            echo "<option value='Sales'>Sales</option>";
                        echo "<option value='Birthday'>Birthday</option>";
                        echo "<option value='Normal Greetings'>Normal Greetings</option>";
			            echo "<option value='Others'>Others</option>";
		                echo "</select><br/>";
                    }
                ?>
                    </div>
                
                    <div class="two">
                    <label>To Who?:<br/> </label><input type="text" name="recipient"/><br/>
                    </div>
                    <div class="three">
                    <label>From Who?:<br/>  </label><input type="text" name="sender" /><br/>
                    </div>
                    <div class="four">
                    <label>What do you want <?php  echo $celebname ?> to do?<br/> </label>
		            <textarea name="instruction" id="instruction" rows="3" cols="70" placeholder="Enter your instruction here."></textarea><br/>
                    </div>
                    <div class="five">
                    <label >What are the details you want <?php  echo $celebname ?> to know? (Optional)<br/></label>
                    <textarea name="details" id="details" rows="3" cols="70" placeholder="Write here."></textarea><br/>
                    </div>
                    <div class="six">
                    <label >Phone Number (Optional): <br/></label><input type="number" name="phoneNum" id="phoneNum" placeholder="Phone no of user" /><br/><br/>
                    </div>
                    <div class="seven">
                    <button type="submit" class="businessorder" name="businessorder">Submit</button>
                    </div>
                    
                </div>
                <!--<input type="submit" name="businessorder" />-->
            </form>
            </div>
            <?php
                    }
            ?>
        </section>
             <!-- footer -->
            <section class="d-flex-r justify-content-space-around p-1 bg-grey" id="social">
                <ul class="footerforhome d-flex-c" id="footer">
                    <p class="wsnc">For more: </p>
                    <li class="rnc"><a href="requestceleb.php" >Request New Celebrity</a></li>
                    <li class="rnc"><a href="howto.php" >How to Order?</a></li>
                    <li class="rnc"><a href="Contact.php" >Contact Us</a></li>
                         </br>
                    <p>&copy; celebportal.com | Designed by Farmer Team</p>
                </ul>
                <ul class="d-flex-r">
                    <li>
                    <p>Follow us for more!</p>
                    <p>Our Social Media Platform:</p>
                        <a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
                     </li>            
                </ul>
            </section>
     </body>
    
</html>