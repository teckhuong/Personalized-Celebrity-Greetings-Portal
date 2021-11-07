<?php include('server.php')?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
   <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">
      <meta charset="utf-8">
      <title>Celebrity Portal</title>
      <link rel="stylesheet" href="header2.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="headercontainer">
      <nav>
         <div class="logo">Celebrity Portal</n> <span class="fa fa-play-circle"></span></div>
         <label for="btn" class="icon">
            <span class="fa fa-bars"></span>
         </label>
         <input class ="cb" type="checkbox" id="btn">
         <ul>
            <li>
               <a href="homepage.php">Home</a></li>
            <li>
               <label for="btn-1" class="show">Celebrity Categories</label>
               <a href="#">Celebrity Categories</a>
               <input class ="cb" type="checkbox" id="btn-1" >
                  <ul>
                     <li><a href="tiktokstarpage.php">TikTok Stars</a></li>
                     <li><a href="youtuberpage.php">Youtubers</a></li>
                     <li><a href="Actorpage.php">Actors</a></li>
                  </ul>
            </li>
            <li>
               <label for="btn-2" class="show">Need Help?</label>
               <a href="#">Need Help?</a>
               <input class ="cb" type="checkbox" id="btn-2">
                  <ul>
                     <li><a href="howto.php">Order Guide</a></li>
                     <li><a href="Contact.php">Contact Us</a></li>
                  </ul>
            </li>
            <?php
               if(isset($_SESSION["username"])){
                  // echo "<li>". $_SESSION["username"] ."</li>";
                  echo "<li class='admin'><img  src='profilepicture/".$_SESSION["username"].".jpg'></li>"; 
                  echo "<li><a href='index.php?logout='1''>Log out</a></li>";
               }
               else{
                  echo "<li><a href='userlogin.php'>Login</a></li>";
               }
            ?>
            <!-- <li><a href="userlogin.php">Login</a></li> -->
         </ul>
      </nav>
      </div>
      <section></section>
   </body>
</html>
