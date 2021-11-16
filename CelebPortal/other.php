<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <title>Other</title>
        <?php include "header.php";?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" type="text/css" href="categorypage.css">
        </head>
        <body>
            <section  class="secondrow">
        <div class="pagetitle">
                    <h1><span class="fab fa-youtube"></span> Other</h1>
            </div>
            <div class="container">
            <div class="filtercontainer">
                <form action="" method="POST">            
                <div class="filter">
                        <input type="text" name="celebname" placeholder="Type Celebrity Name here">
                        <button type="submit">Apply</button>
                </div>
                </form>
                </div>
                <!-- image row start -->
                <div class="row">
                        <?php
                        if(isset($_GET['page'])){
                                $page=$_GET['page'];
                            }
                            else{
                                $page = 1;
                            }
                            $num_per_page=03;
                            $start_from = ($page-1)*03;
                        $con = mysqli_connect("localhost","root","","loginadminsystem");
                        $getother = "SELECT * FROM wholeceleb WHERE tag='Other' LIMIT $start_from,$num_per_page";
                        if(isset($_POST['celebname'])){
                                $category=$_POST['celebname'];                            
                                $getother="SELECT * FROM wholeceleb WHERE celebname='$category'";
                        }
                        $result = mysqli_query($con,$getother);
                        if(mysqli_num_rows($result)>0){
                                while($row=mysqli_fetch_assoc($result)){
                        ?>
                    <!-- image start -->
                    <div class="cimage">
                            <img src="Admin/<?php echo $row['celebpicture']?>" alt="">
                            <div class="details">
                                <h2><?php echo $row['celebname']?></h2>
                                <p><?php echo $row['celebdescrip']?></p>
                                <div class="more">
                                    <form action="celebprofile.php" method="POST">
                                    <input type="hidden" name="celebname" value="<?php echo $row['celebname']?>">
                                    <button name="bring">Bring me there</button>
                                        <!-- <a href="#" class="read-more">Bring me there</a> -->
                                    </form>
                                </div>
                                <div class="icon-links">
                                        <a href="#"></a>
                                </div>
                            </div>
                    </div>
                    <?php 
                    }
                        }else{
			        echo "<h4>No Result Found</h4>"; 
                            } 
                    ?>
                    <!-- image end -->                    
                </div>
                <div class="paging"> 
                    <label >Page: </label>
                    <?php
                        $pr_query = "SELECT * FROM wholeceleb WHERE tag='Other'";
                        $pr_result = mysqli_query($con,$pr_query);
                        $total_record=mysqli_num_rows($pr_result);

                        $total_page = ceil($total_record/$num_per_page+1);

                        for($i=1;$i<$total_page;$i++){
                            echo "<a href='other.php?page=".$i."'class='number'>$i</a>";
                        }
                    ?>
                </div>

            </div>
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