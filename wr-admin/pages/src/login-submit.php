<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['username']) || !empty($_POST['userpass'])){
        $userName = $_POST['username'];
        $userPass = $_POST['userpass'];
        

        
     
        $get_user_query = "SELECT user_id, user_email, user_pass, user_role FROM `users` WHERE user_email = '$userName' AND user_role = 3 ";
        $get_user_result = $conn->query($get_user_query);
        
         
       
        
        if(mysqli_num_rows($get_user_result) > 0){
           
            while($user = mysqli_fetch_assoc($get_user_result)){
                $user_Password = $user['user_pass'];
                
                if (password_verify($userPass, $user_Password)) {
                    session_start();
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_type'] = 'wr-user';
                    $_SESSION['user_role'] = $user['user_role'];
                    $redirectUrl = "location:/wr-admin/index.php";
                }
                else{
                    $redirectUrl = "location:/wr-admin/login.php?status=auth-failed";
                }
            }
        }
        else{
           $redirectUrl = "location:/wr-admin/login.php?status=user-failed";
        }
    }
    else{
       $redirectUrl ="location:/wr-admin/login.php?status=valid-failed";
    }
    
    header($redirectUrl);
    
}

?>