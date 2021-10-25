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
        <section>
            <h2>Order page (Business)</h2>
            <form action="">
                <label for="purpose">Purpose: </label><input type="text" name="purpose" id="purpose" placeholder="The purpose of video" /><br/>
                <label for="recipient">Recipient: </label><input type="text" name="recipient" id="recipient" placeholder="Name of recipient" /><br/>
                <label for="celebrity">Celebrity: </label><input type="text" name="celebrity" id="celebrity" placeholder="Name of celebrity" /><br/>
                <label>Instruction: </label>
		        <textarea name="address" id="address" rows="3" cols="70" placeholder="Enter your instruction here."></textarea><br/>
                
                <label for="phoneNum">Phone Number (Optional): </label><input type="text" name="phoneNum" id="phoneNum" placeholder="Name of celebrity" /><br/>
                <input type="submit" name="order" />
            </form>
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