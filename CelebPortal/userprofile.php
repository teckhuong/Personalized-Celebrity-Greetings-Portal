<!-- Prevent User to come in without log in -->
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
    <title>User Profile Page</title>
    <?php include "header.php";?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" type="text/css" href="homepage.css">
</head>
<body>
    <!-- To take out username -->
<?php
    $temp = $_SESSION['username'];
    $connect = mysqli_connect("localhost","root","","LoginSystem");
    $getcelebname = "SELECT * FROM users WHERE username='$temp'";
    $query_run= mysqli_query($connect,$getcelebname);
                
    foreach($query_run as $row){
        $useremail = $row['email'];
    }
?>
<!-- Start Avatar -->
<div class="wrapper">
    <div class="avatar">
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
    <!-- Show Order status -->
    <div class="secondlayer">
    <div class="secondtitle">
        <H1>Your Orders Details & Status</H1>
    </div>
    <?php
        $connection = mysqli_connect("localhost","root","","loginadminsystem");

        $query = "SELECT * FROM finalquotation WHERE markup='Yes' AND useremail='$useremail'";
        $query_run = mysqli_query($connection, $query);
        $getorder = "SELECT * FROM completedorder WHERE useremail='$useremail' AND agentstatus='Accepted' AND markup='No'";
        $query_runsec = mysqli_query($connection,$getorder);
        $getcompletedquot = "SELECT * FROM finalquotation WHERE useremail='$useremail' AND status='Paid'";
        $query_runthir = mysqli_query($connection,$getcompletedquot);
        $getvideo = "SELECT * FROM ordervideo WHERE videoowner='$useremail'";
        $query_runvid = mysqli_query($connection,$getvideo) or die( mysqli_error($connection));
    ?>
        <div class="rightside">            
            <div class="quottitle">
                <h2>Your Quotations</h2>            
            </div>
            <table>
                <thead>
                    <tr>
                        <td>Order ID</td>
                        <td>Price</td>
                        <td>Pay?</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                ?>
                    <tr>
                        <td><?php echo $row['orderid']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                        <form action="Payment/fullpayment.php" method="POST">
                                <input type="hidden" name="orderid" value="<?php echo $row['orderid']; ?>">
                                <button type = "submit" name="fpay" class="pbtn">Go</button>
                        </form>
                        </td>
                    </tr>   
                    <?php
                        }
                    }else{
                            echo "No Record Found!";
                        }
                    ?>                          
                </tbody>
            </table>
        </div>
        <div class="midside">
            <div class="pordertitle">
                <h2>Your Pending Orders Status</h2>            
            </div>
            <table>
                <thead>
                    <tr>
                        <td>Order ID</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(mysqli_num_rows($query_runsec) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_runsec))
                        {
                ?>
                    <tr>
                        <td><?php echo $row['orderid']; ?></td>
                        <td><?php echo $row['agentstatus']; ?></td>
                    </tr>   
                    <?php
                        }
                    }else{
                            echo "No Record Found!";
                        }
                    ?>                          
                </tbody>
            </table>
        </div>
        <div class="leftside">
            <div class="totalordertitle">
                <h2>Your Completed Orders</h2>            
            </div>
            <table>
                <thead>
                    <tr>
                        <td>Order ID</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(mysqli_num_rows($query_runthir) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_runthir))
                        {
                ?>
                    <tr>
                        <td><?php echo $row['orderid']; ?></td>
                    </tr>   
                    <?php
                        }
                    }else{
                            echo "No Record Found!";
                        }
                    ?>                          
                </tbody>
            </table>
        </div>
    </div>
    <!-- Start Video Showing -->
    <div class="thirdlayer">
        <div class="videotitle">
                <H1>Your Videos</H1>
                <h2>You can rightclick on video or click on the 3 dot in the video to download the video.</H2>
        </div>
            <?php
                if(mysqli_num_rows($query_runvid) > 0)
                {
                    while($row = mysqli_fetch_assoc($query_runvid))
                    {
            ?>
        <div class="videocontent">
            <div class="videoid">
                <h9>Order ID: <?php echo $row['videoname']?></h9>
            </div>
            <video class="videos" controls>
					<source src="<?php echo $row['location']?>">
			</video>              
        </div>
            <?php
                    }
                }else{
                        echo "No Record Found!";
                    }
            ?> 
    </div>
</div>
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