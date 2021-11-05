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
                    <a href="userdatabase.php">
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
                    <a href="#">
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
        <?php
            $temp = $_SESSION['agentid'];
            $connectagent = mysqli_connect("localhost","root","","agentdatabase");
            $getcelebname = "SELECT * FROM agentprofiledetail WHERE username='$temp'";
             $query_run= mysqli_query($connectagent,$getcelebname);
                        
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
                        echo "<img src='profilepicture/".$_SESSION["agentid"].".png'>"; 
                    }
                      
                    ?>  
                </div>
            </div>
            <!-- Body starts from here -->


            <!-- New Order List -->
            <div class="details">
                <div class="recentOrders">
                    <?php
                        $connection = mysqli_connect("localhost","root","","loginadminsystem");
                        $query = "SELECT * FROM completedorder WHERE celebrity='$celebname' AND agentstatus='Accepted'";
                        $query_run = mysqli_query($connection, $query);
                    ?>
                    <div class="cardHeader">
                        <h2>New Orders</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Category</td>
                                <td>To Who?</td>
                                <td>From Who?</td>
                                <td>What to do</td>
                                <td>What are the details</td>
                                <td>Status</td>
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
                                <td><?php echo $row['purpose']; ?></td>
                                <td><?php echo $row['recipient']; ?></td>
                                <td><?php echo $row['sender']; ?></td>
                                <td><?php echo $row['instruction']; ?></td>
                                <td><?php echo $row['details']; ?></td>
                                <td><?php echo $row['agentstatus']; ?></td>
                                <td>
                                <form action="viewonly.php" method="POST">
                                        <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                        <button type = "submit" name="editorder_btn" class="ebtn btn-success">View</button>
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