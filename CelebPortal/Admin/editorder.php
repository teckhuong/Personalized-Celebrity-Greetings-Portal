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
    <?php
        // $sql = "SELECT * FROM users";
        // $result = mysqli_query($conn, $sql);
        // if(mysqli_num_rows($result)>0){
        //     //  while($row = mysqli_fetch_assoc($result)){
        //     //      $id = $row['id'];
        //     //      $sqlImg = "SELECT * FROM profileimg WHERE userid = '$id'";
        //     //      $resultImg= mysqli_query($conn,$sqlImg);
        //     //       while($rowImg = mysqli_fetch_assoc($resultImg)){
        //     //           echo "<div>";
        //     //           if($rowImg['status'] == 0 ){
        //     //               echo "<img src='profilepicture/".$id.".jpg'>";
        //     //           }else{
        //     //               echo "<img src='profilepicture/profiledefault.jpg'>";
        //     //           }
        //     //           echo $row['adminid'];
        //     //           echo "</div>";
        //     //       }
        //     //  }
        // }else{
        //     echo "There is no user yet";
        // }
    ?>
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
                    <a href="#">
                        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                        <span class="title">Agent Profile Management</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="document-outline"></ion-icon></span>
                        <span class="title">Quotation Form</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="document-outline"></ion-icon></span>
                        <span class="title">Add New Product</span>
                    </a>
                </li>
                <li>
                    <a href="#">
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
            <!-- order details list -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Edit User Details Page</h2>
                    </div>
                    <!-- Edit User -->
                    <?php
                    $connection = mysqli_connect("localhost","root","","LoginSystem");
                    if(isset($_POST['editorder_btn'])){
                            $id = $_POST['edit_id'];
                            
                            $query = "SELECT * FROM businessorder WHERE Old ='$id'";
                            $query_run = mysqli_query($connection, $query); 
                            
                     foreach($query_run as $row){
                                ?>

                    <form  action="server.php" method="post">   
                        <input type="hidden" name="edit_id" value="<?php echo $row['Old']?>">         
                    <div class="form-group">
                        <label >Order ID</label>
                        <input type="text" name="edit_orderid" value="<?php echo $row['verification_code']?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label >Username</label>
                        <input type="text" name="edit_username" value="<?php echo $row['username']?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label >Purpose</label>
                        <input type="text" name="edit_purpose" value="<?php echo $row['purpose']?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label >Recipient</label>
                        <input type="text" name="edit_password" value="<?php echo $row['recipient']?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label >Celebrity</label>
                        <input type="text" name="edit_celebrity" value="<?php echo $row['celebrity']?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label >Instruction</label>
                        <input type="text" name="edit_instruction" value="<?php echo $row['instruction']?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label >Phone No.</label>
                        <input type="text" name="edit_phoneNum" value="<?php echo $row['phoneNum']?>" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label >Order Status</label>
                        <select name="edit_status" id="purpose">
			            <option value="Completed">Completed</option>
                        <option value="Refunded">Refunded</option>
                        <option value="Dummy">Dummy</option>
		                </select>
                    </div>
                    <a href="adminhome.php" class="btn btn-danger"> Cancel </a>
                    <button type="submit" name="editorder_btn" class="btn btn-primary">Update</button>

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