<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <title>Profile page</title>
        <?php include "header.php";?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" type="text/css" href="profile.css">
        <!--<script type="text/javascript">
            function businessOrder() {
		        window.location.replace("businessorder.php");
		        return false;
	        }

	        function personalOrder() {
		        window.location.replace("personalorder.php");
		        return false;
	        }
        </script>-->
    </head>
     <body> 
        
        <section class="profilerow">
            <div class="profile-container">
                <div class="col-profile-12">
                    <div class="profile-slider">
                        <!-- Image 1 -->
                        <input type="radio" name="slide_switch" id="img1" checked="checked" />
                        <label for="img1">
                            <img class="profileSlide" src="youtuberimage/laowu/laowu.png" alt="LAO WU" />
                        </label>
                        <img src="youtuberimage/laowu/laowu.png" alt="LAO WU" class="profile_pic" />

                        <!-- Image 2 -->
                        <input type="radio" name="slide_switch" id="img2" />
                        <label for="img2">
                            <img class="profileSlide" src="youtuberimage/laowu/laowu.png" alt="LAO WU" />
                        </label>
                        <img src="youtuberimage/laowu/laowu.png" alt="LAO WU" class="profile_pic" />

                        <!-- Image 3 -->
                        <input type="radio" name="slide_switch" id="img3" />
                        <label for="img3">
                            <img class="profileSlide" src="youtuberimage/laowu/laowu.png" alt="LAO WU" />
                        </label>
                        <img src="youtuberimage/laowu/laowu.png" alt="LAO WU" class="profile_pic" />
                    </div>
                </div>   
            </div>
        </section>
        <div class="profile-desc">
                <section class="radio-container">
                    <span class="celeb-name" >LAO WU</span><br/>
                    <span class="celeb-categ">Gamer - Youtube</span><br/>
                    <span class="celeb-desc">124567</span>
                    <h2>Choose an option</h2>
                    <form action="businessorder.php" method="POST">
                        <input  type="hidden" name="celebemail" value="laowu@gmail.com"/>
                        <input  type="hidden" name="celebname" value="Lao Wu"/>
                                        
                        <input type = "submit" name="business" class="businessclick" value="Business" onclick="return businessOrder();"/><br/>
                        <input type = "submit" name="personal" class="personalclick" value="Personal" onclick="return personalOrder();"/>
                    </form>
                </section>
        </div>
        

        
                
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