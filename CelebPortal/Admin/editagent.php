<?php 
  session_start();
  include_once 'dbh.php'; 

  if (!isset($_SESSION['adminid'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: adminlogin.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['adminid']);
  	header("location: adminlogin.php");
  }   

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" type="text/css" href="adminhome.css">
</head>
<body>
    <div class="admincontainer">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="play-circle"></ion-icon></span>
                        <span class="title">Celebrity Portal Admin Panel</span>
                    </a>
                </li>
                <li>
                    <a href="adminhome.php">
                        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                        <span class="title">Homepage</span>
                    </a>
                </li>
                <li>
                    <a href="completedorder.php">
                        <span class="icon"><ion-icon name="document-outline"></ion-icon></span>
                        <span class="title">Completed Deposit Orders</span>
                    </a>
                </li>
                <li>
                    <a href="userdatabase.php">
                        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                        <span class="title">User Profile Management</span>
                    </a>
                </li>
                <li>
                    <a href="agentdatabase.php">
                        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                        <span class="title">Agent Profile Management</span>
                    </a>
                </li>
                <li>
                    <a href="viewquotation.php">
                        <span class="icon"><ion-icon name="document-outline"></ion-icon></span>
                        <span class="title">View Quotation Form</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="document-outline"></ion-icon></span>
                        <span class="title">Add New Product</span>
                    </a>
                </li>
                <li>
                    <a href="agentregister.php">
                        <span class="icon"><ion-icon name="person-add-outline"></ion-icon></span>
                        <span class="title">Add New Agent</span>
                    </a>
                </li>
                <li>
                    <a href="index1.php?logout='1'">
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
                    if(isset($_SESSION["adminid"])){
                        echo "<img src='profilepicture/".$_SESSION["adminid"].".jpg'>"; 
                    }
                      
                    ?>  
                </div>
            </div>
            <link rel="stylesheet" type="text/css" href="form.css">
            <!-- order details list -->
            <div class="details">
                <div class="recentOrders">
                    <div class="header">
                        <h2>Edit Agent Details Page</h2>
                    </div>
                    <?php include('errors.php'); ?>
                    <?php if (isset($_SESSION['success'])) : ?>
                    <div class="error success" >
                        <?php 
                            echo $_SESSION['success']; 
                            // unset($_SESSION['success']);
                        ?>
                    </div>
                    <?php endif ?>
                    <!-- Edit User -->
                    <?php
                    $connection = mysqli_connect("localhost","root","","agentdatabase");
                    if(isset($_POST['editagent_btn'])){
                            $id = $_POST['edit_id'];
                            
                            $query = "SELECT * FROM agentprofiledetail WHERE id ='$id'";
                            $query_run = mysqli_query($connection, $query); 
                            
                     foreach($query_run as $row){
                                ?>

                    <form  action="server.php" method="post">   
                        <input type="hidden" name="edit_id" value="<?php echo $row['id']?>">                    
                    <div class="input-group">
                        <label >Username</label>
                        <input type="text" name="edit_username" value="<?php echo $row['username']?>" class="form-control" >
                    </div>
                    <div class="input-group">
                        <label >Password</label>
                        <input type="text" name="edit_password" value="<?php echo $row['password']?>" class="form-control" >
                    </div>
                    <div class="input-group">
                        <label >Agent Name</label>
                        <input type="text" name="edit_agentname" value="<?php echo $row['agentname']?>" class="form-control" >
                    </div>
                    <div class="input-group">
                        <label >Email</label>
                        <input type="text" name="edit_email" value="<?php echo $row['email']?>" class="form-control" >
                    </div>
                    <div class="input-group">
                        <label >Company Name</label>
                        <input type="text" name="edit_compname" value="<?php echo $row['compname']?>" class="form-control" >
                    </div>
                    <div class="input-group">
                        <label >Celebrity Name</label>
                        <input type="text" name="edit_celebname" value="<?php echo $row['celebname']?>" class="form-control" >
                    </div>
                    <div class="input-group">
                        <label >Phone Number</label>
                        <input type="text" name="edit_phonenum" value="<?php echo $row['phonenum']?>" class="form-control" >
                    </div>
                    <div class="input-group">
                        <label >Date of Contract</label>
                        <input type="date" name="edit_doc" value="<?php echo $row['doc']?>" class="form-control" >
                    </div>
                    <a href="agentdatabase.php" class="btn btn-danger"> Cancel </a>
                    <button type="submit" name="editagent_btn" class="btn btn-primary">Update</button>

                    </form>

                    <?php

                            }
                        }
                    ?>

                </div>
            </div>



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