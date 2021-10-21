<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <title>Profile page</title>
        <?php include "header.php";?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" type="text/css" href="profile.css">
        <link rel="stylesheet" type="text/css" href="categorypage.css">
        </head>
     <body > 
        <section class="profilerow">
        <div class="profile-container">
            <div class="profile-content">
                <img class="profileSlide" scr="youtuberimage/laowu/laowu.png" alt="LAO WU" />
                <img class="profileSlide" scr="youtuberimage/laowu/laowu.png" alt="LAO WU" />
                <img class="profileSlide" scr="youtuberimage/laowu/laowu.png" alt="LAO WU" />

                <div class="profile-row-padding w3-section">
                    <div class="profile-col s4">
                        <img class="demo profile-opacity profile-hover-opacity-off" scr="youtuberimage/laowu/laowu.png" onclick="currDiv(1)" />
                    </div>
                    <div class="profile-col s4">
                        <img class="demo profile-opacity profile-hover-opacity-off" scr="youtuberimage/laowu/laowu.png" onclick="currDiv(2)" />
                    </div>
                    <div class="profile-col s4">
                        <img class="demo profile-opacity profile-hover-opacity-off" scr="youtuberimage/laowu/laowu.png" onclick="currDiv(3)" />
                    </div>
                </div>
            </div>

        <script>
            function currDiv(i){
                showDivs(slideIndex = i);
            }

            function showDivs(n) {
                var x;
                var y = document.getElementsByClassName("profileSlide");
                var dots = document.getElementsByClassName("demo");
                if (n > y.length) {slideIndex = 1;}
                if(n < 1) {slideIndex = y.length;}
                for(x = 0; x < y.length; x++) {
                    y[x].style.display = "none";
                }
                for(x = 0; x < dots.length; x++) {
                    dots[x].className = dots[x].className.replace(" profile-opacity-off", "")
                }
                y[slideIndex-1].style.display = "block";
                dots[slideIndex-1].className += " profile-opacity-off";
            }
        </script>
        </div>
         <div class="slideshow"></div>
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