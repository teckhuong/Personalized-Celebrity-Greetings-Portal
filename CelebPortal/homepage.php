<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>CelebPortalHomepage</title>
    <?php include "header.php";?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" href="homepage.css">
</head>
<body>
    <!-- Banner Section -->
    <section class="container-fluid bg-landing" id="landing">
        <div class="overlay">
                <div class="wrapper">
                        <div class="banner-text">
                                <h1>Welcome to Celebrity Portal</h1>
                                <h1>Where you can pick any Celebrities</h1>
                                <h1>To perform your desired greetings!</h1>
                                <p class="font-md my-2">Scroll down for more!</p>
                        </div>
                        
                </div>
        </div>
    </section>

    <section class="container-fulid d-flex-c" id="whatsnew">
        <div class="text-center text-container">
                <h2>Whats New?</h2>
        </div>
        <!-- FIRST ROW -->
        <div class = "d-flex-r">
                <div class="slider">
                    <div class="slides">
                        <!-- Start of radio button -->
                            <input type="radio" name="radio-btn" id="radio1">
                            <input type="radio" name="radio-btn" id="radio2">
                            <input type="radio" name="radio-btn" id="radio3">
                            <input type="radio" name="radio-btn" id="radio4">
                        <!-- End of radio button -->
                        <!-- Start of images -->
                        <div class="slide first">
                            <img src="youtuberimage/laowu/SitFirstShot.jpg">
                        </div>
                        <div class="slide">
                            <img src="youtuberimage/laowu/testback.png" alt="">
                        </div>
                        <div class="slide">
                            <img src="youtuberimage/laowu/SitFirstShot.jpg" alt="">
                        </div>
                        <div class="slide">
                            <img src="youtuberimage/laowu/SitFirstShot.jpg" alt="">
                        </div>
                        <!-- End of Image -->
                        <!-- Auto Nav -->
                        <div class="navigation-auto">
                            <div class="auto-btn1"></div>
                            <div class="auto-btn2"></div>
                            <div class="auto-btn3"></div>
                            <div class="auto-btn4"></div>
                        </div>
                        <!-- Auto Nav End -->
                        <!-- manual navi -->
                        <div class="navigation-manual">
                            <label for="radio1" class="manual-btn"></label>
                            <label for="radio2" class="manual-btn"></label>
                            <label for="radio3" class="manual-btn"></label>
                            <label for="radio4" class="manual-btn"></label>
                        </div>
                        <!-- manual navi End -->
                    </div>
                    <!-- image slider ends here -->
                    <script type="text/javascript">
                        var counter = 1;
                        setInterval(function(){
                            document.getElementById('radio' + counter).checked = true;
                            counter++;
                            if(counter>4){
                                counter = 1;
                            }
                        },5000);
                    </script>
                </div>
            </div>
        <!-- FIRST ROW Ends Here-->
    </section>
    <!-- Second Row start -->
    <section class="secondrow">
    <div class="text-center text-container">
                <h2>Latest Celebrity that just join us</h2>
        </div>
        <div class="container">
            <!-- image row start -->
            <div class="row">
                <!-- image start -->
                <div class="cimage">
                        <img src="youtuberimage/laowu/laowu.png" alt="">
                        <div class="details">
                            <h2>LAO WU</h2>
                            <p>Youtuber who has been around for 10 years. mjor on streaming video games</p>
                            <div class="more">
                                    <a href="#" class="read-more">Bring me there</a>
                            </div>
                            <div class="icon-links">
                                    <a href="#"></a>
                            </div>
                        </div>
                </div>
                <!-- image end -->
                <!-- image start -->
                <div class="cimage">
                        <img src="youtuberimage/laowu/laowu.png" alt="">
                        <div class="details">
                            <h2>LAO WU</h2>
                            <p>Youtuber who has been around for 10 years. mjor on streaming video games</p>
                            <div class="more">
                                    <a href="#" class="read-more">Bring me there</a>
                            </div>
                            <div class="icon-links">
                                    <a href="#"></a>
                            </div>
                        </div>
                </div>
                <!-- image end -->
                <!-- image start -->
                <div class="cimage">
                        <img src="youtuberimage/laowu/laowu.png" alt="">
                        <div class="details">
                            <h2>LAO WU</h2>
                            <p>Youtuber who has been around for 10 years. mjor on streaming video games</p>
                            <div class="more">
                                    <a href="#" class="read-more">Bring me there</a>
                            </div>
                            <div class="icon-links">
                                    <a href="#"></a>
                            </div>
                        </div>
                </div>
                <!-- image end -->
            </div>

        </div>
    </section>
    <!-- Footer -->
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
