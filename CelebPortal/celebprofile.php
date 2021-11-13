
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Celebrity Profile</title>
    <?php include "header.php";?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" href="homepage.css">
</head>
<body>
<!-- start content -->
<?php
    if(isset($_POST['bring'])){
        $getcelebname = $_POST['celebname'];
        $con = mysqli_connect("localhost","root","","loginadminsystem");
        $getceleb = "SELECT * FROM wholeceleb WHERE celebname='$getcelebname'";
        $query_run = mysqli_query($con,$getceleb);
        foreach($query_run as $row){   
?>
<div class="small-container single-product">
    <div class="cprow">
        <div class="col-2">
            <img src="Admin/<?php echo $row['celebpicture']?>" width="100%" id="ProductImg">
            <div class="small-img-row">
                <div class="small-img-col">
                    <img src="" width="100%" alt="" class="small-img">
                </div>
                <div class="small-img-col">
                    <img src="" width="100%" alt="" class="small-img">
                </div>
                <div class="small-img-col">
                    <img src="" width="100%" alt="" class="small-img">
                </div>
                <div class="small-img-col">
                    <img src="" width="100%" alt="" class="small-img">
                </div>
            </div>
        </div>
        <div class="col-2">
            <p>Home/<?php echo $row['tag']?>/</p>
            <br>
            <h3><?php echo $getcelebname?></h3>
            <br>
            <h2>Description of <?php echo $getcelebname?></h2>
            <br>
            <p><?php echo $row['celebdescrip']?></p>            
            
            <form action="businessorder.php" method="POST">
                <input  type="hidden" name="celebname" value="<?php echo $getcelebname?>"/>
                <button type="submit" name="business" class="btn">Order Now</button>                       
            </form>
            <div class="warning">
            <h4>Notice:<br>Every order requires RM 100 Deposit.This deposit will be deducted on your total payment.</h4>
            </div>           
        </div>
    </div>
</div>
<?php
        }
    }else{
        echo mysqli_error();
    }
?>

<!-- Footer -->
<div class="caution d-flex-r justify-content-space-around p-1 bg-grey" id="social">
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
                </div>
    <script>
        
            let toggle = document.querySelector('.toggle');
            let editimage = document.querySelector('.editimage');
            toggle.onclick = function(){
                editimage.classList.toggle('active');
            }
        
    </script>
</body>
</html>