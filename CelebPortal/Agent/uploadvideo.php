<?php 
   session_start();

   if (!isset($_SESSION['agentid'])) {
   	$_SESSION['msg'] = "You must log in first";
   	header('location: agentlogin.php');
   }
   if (isset($_GET['logout'])) {
   	session_destroy();
   	unset($_SESSION['agentid']);
   	header("location: agentlogin.php");
   }   

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video Page</title>
    <link rel="stylesheet" type="text/css" href="agenthome.css">
</head>
<body>    
    <div class="admincontainer">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="play-circle"></ion-icon></span>
                        <span class="title">Celebrity Portal Agent Panel</span>
                    </a>
                </li>
                <li>
                    <a href="agenthome.php">
                        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                        <span class="title">Homepage</span>
                    </a>
                </li>
                <li>
                    <a href="createquotation.php">
                        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                        <span class="title">Quotation Form</span>
                    </a>
                </li>
                <li>
                    <a href="acceptedorder.php">
                        <span class="icon"><ion-icon name="document-outline"></ion-icon></span>
                        <span class="title">Accepted Order</span>
                    </a>
                </li>
                <li>
                    <a href="agentupload.php">
                        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                        <span class="title">Upload Video</span>
                    </a>
                </li>                             
                <li>
                    <a href="index2.php?logout='1'">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="title">logout</span>
                    </a>
                </li>
            </ul>
        </div>        
                <!-- To take out username -->
            <?php
                $temp = $_SESSION['agentid'];
                $connect = mysqli_connect("localhost","root","","agentdatabase");
                $getcelebname = "SELECT * FROM agentprofiledetail WHERE username='$temp'";
                $query_run= mysqli_query($connect,$getcelebname);
                            
                foreach($query_run as $row){
                    $celebname = $row['celebname'];
                }
            ?>
             <!-- main -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="admin">
                    <!-- username -->
                    <?php
                    if(isset($_SESSION["agentid"])){
                        echo "<img src='profilepicture/".$_SESSION["agentid"].".jpg'>"; 
                    }
                    ?>  
                </div>
            </div>
            <!-- Body starts from here -->
            <!-- Form starts here -->
            <link rel="stylesheet" type="text/css" href="form.css">
            <div class="details">
                <div class="recentOrders">
                    <?php
                        $connection = mysqli_connect("localhost","root","","LoginAdminSystem");
                        if(isset($_POST['passorderid'])){
                                $id = $_POST['id'];
                                
                                $query = "SELECT * FROM finalquotation WHERE id ='$id'";
                                $query_run = mysqli_query($connection, $query); 
                                
                         foreach($query_run as $row){;
                    ?>
                    <div class="header">
                        <h2>Upload Video Form</h2>
                    </div>
                    <!-- Read Order Id from Accepted Order -->
                    <form  action="server.php" method="post" enctype="multipart/form-data">   
                    <?php include('errors.php'); ?>
                    <?php if (isset($_SESSION['uploadvideo'])) : ?>
                    <div class="error success" >
                        <?php 
                            echo $_SESSION['uploadvideo']; 
                            unset($_SESSION['uploadvideo']);
                        ?>
                    </div>
                    <?php endif ?>
                    <input type="hidden" name="celebname" value="<?php echo $celebname ?>"/>
                    <div class="input-group">
                        <label >Order ID</label>                            
                        <input type="text" name="orderid" value="<?php echo $row['orderid']?>"> 
                        <input type="hidden" name="useremail" value="<?php echo $row['useremail']?>">
                    </div>
                    <div class="input-group">
                        <label >Video* (Only MP4 format, Not more than 400MB)</label>
                        <input type="file" name="video">
                    </div>
                    <div class="input-group">
                        <button type="submit" name="vidupload" class="btn btn-primary">Upload</button>                       
                        </div>
                    </form>
                    
                    <?php

                        }
                    }
                    ?>

                </div>
            </div>

            <!-- Body Ends here -->
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        //menutoggle
        let toggle = document.querySelector('.toggle');
        let navigation = document.querySelector('.navigation');
        let main = document.querySelector('.main');

        toggle.onclick = function(){
            navigation.classList.toggle('active');
            main.classList.toggle('active');
        }

        //add hovered class in selected list item
        let list = document.querySelectorAll('.navigation li');
        function activeLink(){
            list.forEach((item)=>
            item.classList.remove('hovered'));
            this.classList.add('hovered');
        }
        list.forEach((item)=>
        item.addEventListener('mouseover',activeLink));
    </script>
</body>
</html> 