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
<!-- Start Avatar -->
<div class="wrapper">
    <div class="avatar">
        <?php include('errors.php'); ?>
        <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success" >
            <?php 
                echo $_SESSION['success']; 
                // unset($_SESSION['success']);
            ?>
        </div>
        <?php endif ?>
        <div class="image">
            <?php
                if(isset($_SESSION["username"])){
                    echo "<img src='profilepicture/".$_SESSION["username"].".jpg'>";
                }
            ?>            
        </div>
        <div class="toggle">
            <button >Edit Picture</button>
        </div>
        <div class="editimage">
            <form action="userprofile.php" method="post" enctype="multipart/form-data">
                <input type="file" name="profilepic" onchange="this.form.submit();"/>
                <!-- <button type="submit" class="btn" name="changeimage" >Upload</button> -->
            </form>
        </div>
    </div>
        <!-- Start Video Showing -->
    <div class="videocontainer">
        <div class="videotitle">
                <h2>Your Videos</h2>
        </div>
        <div class="videocontent">
                
        </div>
    </div>
</div>
<!-- Footer -->
<section class="d-flex-r justify-content-space-around p-1 bg-grey" id="social">
    <ul class="footerforhome d-flex-c" id="footer">
            <p class="wsnc">For more: </p>
            <li class="rnc"><a href="RequestCeleb/requestceleb.php" >Request New Celebrity</a></li>
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
    <script>
        
            let toggle = document.querySelector('.toggle');
            let editimage = document.querySelector('.editimage');
            toggle.onclick = function(){
                editimage.classList.toggle('active');
            }
        
    </script>
</body>
</html>