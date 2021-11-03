<?php
if(!isset($_SESSION)) { 
  session_start(); 
} 

// initializing variables
$adminid = "";
$fullname = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'LoginAdminSystem');
$connection = mysqli_connect('localhost', 'root', '', 'LoginSystem');
$connectagent = mysqli_connect('localhost', 'root', '', 'agentdatabase');
// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $adminid = mysqli_real_escape_string($db, $_POST['adminid']);
  $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  //profile pic
	$file = $_FILES['aimage'];

  $fileName=$file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg','jpeg','png','pdf');

  

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($adminid)) { array_push($errors, "Admin ID is required"); }
  if (empty($fullname)) { array_push($errors, "Full Name is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE adminid='$adminid'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['adminid'] === $adminid) {
      array_push($errors, "Admin ID already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (adminid, password, fullname) 
  			  VALUES('$adminid','$password','$fullname')";
  	mysqli_query($db, $query);

    $sql = "SELECT * FROM users WHERE adminid = '$adminid' AND fullname = '$fullname'";
    $result = mysqli_query($db, $sql);
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        $userid = $row['id'];
        $sql = "INSERT INTO profileimg (userid, status) 
        VALUES ('$userid', 0)";
        mysqli_query($db, $sql);
      }
    }else{
      echo "You have error!";
    }
    if(in_array($fileActualExt, $allowed)){
      if($fileError === 0){
        if($fileSize < 1000000){
        $fileNameNew = $adminid.".".$fileActualExt;
        $fileDestination = 'profilepicture/'.$fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);
        }else{
          echo "Your file is too big!";
        }    
    }else{
      echo "There was an error uploading your file!";
    }
  }else{
    echo "You cannot upload file of this type!";
  }
  	$_SESSION['success'] = "You have been registered successfully";
  	header('location: adminsignup.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $adminid = mysqli_real_escape_string($db, $_POST['adminid']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($adminid)) {
        array_push($errors, "Admin ID is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE adminid='$adminid' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['adminid'] = $adminid;
          $_SESSION['success'] = "You are now logged in";
          header('location: adminhome.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }

  //edit user
  if(isset($_POST['updatebtn'])){
    $id=$_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = md5($_POST['edit_password']);
    $fullname = $_POST['edit_fullname'];
    $dob = $_POST['edit_dob'];

    $query = "UPDATE users SET username='$username', email='$email', password='$password', fullname='$fullname',dob='$dob' WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run){
      $_SESSION['success'] = "Your Data is Updated!";
      header('location: userdatabase.php');
    }else{
      $_SESSION['success'] = "Your Data is Not Updated!";
      header('location: userdatabase.php');
    }
  }

  //delete user
  if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    $query = "DELETE FROM users WHERE id='$id'";
    $query_run=mysqli_query($connection, $query);

    if($query_run){
      $_SESSION['success'] = "Your Data is deleted";
      header('location: userdatabase.php');
    }else{
      $_SESSION['success'] = "Your data is not deleted";
      header('location: userdatabase.php');
    }
  }
  
  //completing order
  if(isset($_POST['editorder_btn'])){
    $id=$_POST['edit_id'];
    $username = mysqli_real_escape_string($db, $_POST['edit_username']);
    $orderid = mysqli_real_escape_string($db, $_POST['edit_orderid']);
    $purpose = mysqli_real_escape_string($db, $_POST['edit_purpose']);
    $recipient = mysqli_real_escape_string($db, $_POST['edit_password']);
    $celebrity = mysqli_real_escape_string($db, $_POST['edit_celebrity']);
    $instruction = mysqli_real_escape_string($db, $_POST['edit_instruction']);
    $phoneNo = mysqli_real_escape_string($db, $_POST['edit_phoneNum']);
    $status = mysqli_real_escape_string($db, $_POST['edit_status']);

    $query = "DELETE FROM businessorder WHERE Old='$id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run){
      $newquery = "INSERT INTO completedorder (username, purpose, recipient, celebrity, instruction, phoneNum, orderid, status) 
      VALUES('$username','$purpose', '$recipient', '$celebrity','$instruction','$phoneNo', '$orderid', '$status')";
      mysqli_query($db,$newquery);
      $_SESSION['success'] = "Order is completed!";
      header('location: completedorder.php');
    }else{
      $_SESSION['success'] = "Error happend! Could not insert!";
    }
  }
  //deleting order
  if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    $query = "DELETE FROM businessorder WHERE Old='$id'";
    $query_run=mysqli_query($connection, $query);

    if($query_run){
      $_SESSION['success'] = "Your Data is deleted";
      header('location: adminhome.php');
    }else{
      $_SESSION['success'] = "Your data is not deleted";
      header('location: adminhome.php');
    }
  }

  //register agent
  if(isset($_POST['agentreg'])){
    
  //initializing variable for agent register
  $agentusername = "";
  $agentpw = "";
  $agentname = "";
  $agentemail = "";
  $agentcompname = "";
  $agentcelebname = "";
  $agentphonenum = "";
  $agentdoc = "";

  //receive inputs value from form
  $agentusername = mysqli_real_escape_string($db, $_POST['username']);
  $agentpw = mysqli_real_escape_string($db, $_POST['password']);
  $agentname = mysqli_real_escape_string($db, $_POST['agentname']);
  $agentemail = mysqli_real_escape_string($db, $_POST['email']);
  $agentcompname = mysqli_real_escape_string($db, $_POST['compname']);
  $agentcelebname = mysqli_real_escape_string($db, $_POST['celebname']);
  $agentphonenum = mysqli_real_escape_string($db, $_POST['phonenum']);
  $agentdoc = mysqli_real_escape_string($db, $_POST['doc']);

  //form validation: to check form is filled or not
  if (empty($agentusername)) { array_push($errors, "Username is required"); }
  if (empty($agentpw)) { array_push($errors, "Password is required"); }
  if (empty($agentname)) { array_push($errors, "Agent's Name is required"); }
  if (empty($agentemail)) { array_push($errors, "Agent's Email is required"); }
  if (empty($agentcompname)) { array_push($errors, "Agent's Company is required"); }
  if (empty($agentcelebname)) { array_push($errors, "Celebrity Name is required"); }
  if (empty($agentphonenum)) { array_push($errors, "Agent's Phone Number is required"); }
  if (empty($agentdoc)) { array_push($errors, "Agent's Date of Contract is required"); }

  //Register agent into database if no error
  if (count($errors) == 0) {
  	$agentpassword = md5($agentpw);//encrypt the password before saving in the database
  	$insertagent = "INSERT INTO agentprofiledetail (username, password, agentname, email, compname, celebname, phonenum, doc) 
  			  VALUES('$agentusername', '$agentpassword','$agentname', '$agentemail','$agentcompname','$agentcelebname','$agentphonenum','$agentdoc')";
  	mysqli_query($connectagent, $insertagent);
  	header('location: agentdatabase.php');
  }else{
    echo mysqli_error();
  }
  }

    //edit agent
    if(isset($_POST['editagent_btn'])){
      $id=$_POST['edit_id'];
      $username = $_POST['edit_username'];
      $email = $_POST['edit_email'];
      $password = md5($_POST['edit_password']);
      $agentname = $_POST['edit_agentname'];
      $compname = $_POST['edit_compname'];
      $celebname = $_POST['edit_celebname'];
      $phonenum = $_POST['edit_phonenum'];
      $doc = $_POST['edit_doc'];
  
      $updatequery = "UPDATE agentprofiledetail SET username='$username', password='$password', agentname='$agentname', email='$email', compname='$compname', celebname='$celebname', phonenum='$phonenum', doc='$doc' WHERE id='$id'";
      $query_run = mysqli_query($connectagent, $updatequery);
  
      if($query_run){
        $_SESSION['success'] = "Your Data is Updated!";
        header('location: agentdatabase.php');
      }else{
        $_SESSION['success'] = "Your Data is Not Updated!";
        header('location: agentdatabase.php');
      }
    }
  
    //delete agent
    if(isset($_POST['delete_btn'])){
      $id = $_POST['delete_id'];
      $query = "DELETE FROM agentprofiledetail WHERE id='$id'";
      $query_run=mysqli_query($connectagent, $query);
  
      if($query_run){
        $_SESSION['success'] = "Your Data is deleted";
        header('location: agentdatabase.php');
      }else{
        $_SESSION['success'] = "Your data is not deleted";
        header('location: agentdatabase.php');
      }
    }
  ?>
