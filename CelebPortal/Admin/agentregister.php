<?php 
  include('server.php');

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
    <title>Agent Register</title>
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
                    <a href="addceleb.php">
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
                    <a href="viewproduct.php">
                        <span class="icon"><ion-icon name="person-add-outline"></ion-icon></span>
                        <span class="title">Edit Product</span>
                    </a>
                </li>
                <li>
                    <a href="editwhatsnew.php">
                        <span class="icon"><ion-icon name="person-add-outline"></ion-icon></span>
                        <span class="title">Edit Whats New</span>
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
            <div class="header">
  	<h2>Register Agent</h2>
  </div>
            <form method="post" action="agentregister.php" enctype="multipart/form-data">
            <?php include('errors.php'); ?>
            <?php if (isset($_SESSION['agentregisteralert'])) : ?>
            <div class="error success" >
                <?php 
                    echo $_SESSION['agentregisteralert']; 
                     unset($_SESSION['agentregisteralert']);
                ?>
            </div>
            <?php endif ?>
                <div class="input-group">
                <label>Username*</label>
                <input type="text" name="username" >
                </div>
                <div class="input-group">
                <label>Password*</label>
                <input type="text" name="password">
                </div>
                <div class="input-group">
                <label>Agent Name*</label>
                <input type="text" name="agentname">
                </div>
                <div class="input-group">
                <label>Email*</label>
                <input type="email" name="email" >
                </div>
                <div class="input-group">
                <label>Company Name*</label>
                <input type="text" name="compname">
                </div>
                <div class="input-group">
                <label>Celebrity Name*</label>
                <input type="text" name="celebname">
                </div>
                <div class="input-group">
                <label>Phone Number*</label>
                <input type="number" name="phonenum">
                </div>
                <div class="input-group">
                <label>Date of Contract*</label>
                <input type="date" name="doc">
                </div>
                <div class="input-group">
		        <label >Profile picture* (Only jpg, Not more than 5 MB)</label>
		        <input type="file" name="agentimage">
                <h6 style="color:red">*Picture is compulsory*</h6>
	            </div>
                <div class="input-group">
                <button type="submit" class="btn" name="agentreg">Register</button>
                </div>
            </form>


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