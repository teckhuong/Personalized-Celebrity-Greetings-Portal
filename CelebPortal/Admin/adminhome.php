<!-- starting from here is masterpage from admin -->
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
<!-- masterpage from admin ends here -->


            <!-- cards -->
            <div class="cardBox">
                <div class="card">
                <?php
                        $connection = mysqli_connect("localhost","root","","LoginAdminSystem");

                        $sql = "SELECT count(id) AS total FROM completedorder";
                        $result=mysqli_query($connection, $sql);
                        $values = mysqli_fetch_assoc($result);
                        $num_rows=$values['total'];                        
                    ?>
                    <div>
                        <div class="numbers"><?php echo $num_rows; ?></div>
                        <div class="cardName">Total Order</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="document-outline"></ionicon>
                    </div>
                </div>
                <div class="card">
                <?php
                        $connection = mysqli_connect("localhost","root","","LoginAdminSystem");

                        $sql = "SELECT count(id) AS total FROM completedorder WHERE status='Completed' AND agentstatus='Accepted'";
                        $result=mysqli_query($connection, $sql);
                        $values = mysqli_fetch_assoc($result);
                        $num_rows=$values['total'];                        
                    ?>
                    <div>
                        <div class="numbers"><?php echo $num_rows; ?></div>
                        <div class="cardName">Order in progress</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="document-outline"></ionicon>
                    </div>
                </div>
                <div class="card">
                <?php
                        $connection = mysqli_connect("localhost","root","","LoginAdminSystem");

                        $sql = "SELECT count(id) AS total FROM finalquotation WHERE status='Paid'";
                        $result=mysqli_query($connection, $sql);
                        $values = mysqli_fetch_assoc($result);
                        $num_rows=$values['total'];                        
                    ?>
                    <div>
                        <div class="numbers"><?php echo $num_rows; ?></div>
                        <div class="cardName">Order Fully Completed</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="document-outline"></ionicon>
                    </div>
                </div>
                <div class="card">
                <?php
                        $connection = mysqli_connect("localhost","root","","LoginAdminSystem");

                        $sql = "SELECT count(id) AS total FROM completedorder WHERE status='Dummy' OR agentstatus='Decline'";
                        $result=mysqli_query($connection, $sql);
                        $values = mysqli_fetch_assoc($result);
                        $num_rows=$values['total'];                        
                    ?>
                    <div>
                        <div class="numbers"><?php echo $num_rows; ?></div>
                        <div class="cardName">Failed Order</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="document-outline"></ionicon>
                    </div>
                </div>
                
            </div>
            
            <!-- order details list -->
            <div class="details">
                <div class="recentOrders">
                    <?php
                        $connection = mysqli_connect("localhost","root","","LoginSystem");

                        $query = "SELECT * FROM businessorder";
                        $query_run = mysqli_query($connection, $query);
                    ?>
                    <div class="cardHeader">
                        <h2>New Orders</h2>                        
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Username</td>
                                <td>Purpose</td>
                                <td>Celebrity</td>                                
                                <td>Phone No.</td>
                                <td>Payment</td>
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
                                <td><?php echo $row['verification_code']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['purpose']; ?></td>
                                <td><?php echo $row['celebrity']; ?></td>
                                <td><?php echo $row['phoneNum']; ?></td>
                                <td><?php echo $row['payment']; ?></td>
                                <td>
                                <form action="editorder.php" method="POST">
                                        <input type="hidden" name="edit_id" value="<?php echo $row['Old']; ?>">
                                        <button type = "submit" name="editorder_btn" class="ebtn btn-success">View</button>
                                    </form>
                                </td>
                                <td>
                                <form action="server.php" method="post">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['Old'];?>">
                                <button type = "submit" name="delete_btn" class="dbtn btn-danger">DELETE</button></td>
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
            </div>
        </div>

       
                                <!-- starting from here is masterpage from admin -->
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