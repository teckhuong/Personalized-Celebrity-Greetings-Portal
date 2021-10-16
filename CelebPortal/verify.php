<?php 

    $db = mysqli_connect('localhost', 'root', '', 'LoginSystem');

    if(isset($_GET['email']) && isset($_GET['v_code']))
    {
        $user_check_query = "SELECT * FROM users WHERE email='$_GET[email]' AND verification_code='$_GET[v_code]'";
        $result = mysqli_query($db, $user_check_query);
        if ($result)
        {
            if(mysqli_num_rows($result)==1)
            {
                $result_fetch=mysqli_fetch_assoc($result);
                if($result_fetch['is_verified']==0)
                {
                    $update = "UPDATE users SET is_verified = '1' WHERE email = '$result_fetch[email]'";
                    if(mysqli_query($db, $update))
                    {
                        echo"
                        <script>
                        alert('Email Verifiction Sucessful');
                        window.location.href='homepage.php';
                        </script>
                        ";

                    }
                    else {
                    echo"
                    <script>
                    alert('Email Already Registered');
                    window.location.href='homepage.php';
                    </script>
                    ";
                    }
                }
                else {
                    echo"
                    <script>
                    alert('Email Already Registered');
                    window.location.href='homepage.php';
                    </script>
                    ";
                }
            }
        }
        else{
            echo"
            <script>
            alert('Cannot run query');
            window.location.href='homepage.php';
            </script>
            ";
        }
    }


?>
