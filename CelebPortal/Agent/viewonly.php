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
    <title>Agent Homepage</title>
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

            <link rel="stylesheet" type="text/css" href="form.css">
            <!-- order details list -->
            <div class="details">
                <div class="recentOrders">
                    <div class="header">
                        <h2>Order Details Page</h2>
                    </div>
                    <!-- Edit User -->
                    <?php
                    $connection = mysqli_connect("localhost","root","","LoginAdminSystem");
                    if(isset($_POST['editorder_btn'])){
                            $id = $_POST['edit_id'];
                            
                            $query = "SELECT * FROM completedorder WHERE id ='$id'";
                            $query_run = mysqli_query($connection, $query); 
                            
                     foreach($query_run as $row){
                                ?>

                    <form  action="server.php" method="post">   
                        <input type="hidden" name="edit_id" value="<?php echo $row['id']?>">         
                    <div class="input-group">
                        <label >Order ID</label>
                        <input type="text" name="edit_orderid" value="<?php echo $row['orderid']?>" class="form-control" placeholder ="Enter Username">
                    </div>
                    <div class="input-group">
                        <label >Category</label>
                        <input type="text" name="edit_purpose" value="<?php echo $row['purpose']?>" class="form-control" placeholder ="Enter Username">
                    </div>
                    <div class="input-group">
                        <label >To Who</label>
                        <input type="text" name="edit_recipient" value="<?php echo $row['recipient']?>" class="form-control" placeholder ="Enter Username">
                    </div>
                    <div class="input-group">
                        <label >From Who</label>
                        <input type="text" name="edit_sender" value="<?php echo $row['sender']?>" class="form-control" placeholder ="Enter Username">
                    </div>                    
                    <div class="input-group">
                        <label >What to do?</label>
                        <input type="hidden"  name="edit_instruction" value="<?php echo $row['instruction']?>" class="form-control" >
                        <p  allign="justify" ><?php echo nl2br($row['instruction']);?></p>
                    </div>
                    <div class="input-group">
                        <label >What are the Details?</label>
                        <input type="hidden"  name="edit_details" value="<?php echo $row['details']?>" class="form-control" >
                        <p  allign="justify" ><?php echo nl2br($row['details']);?></p>
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