<?php
session_start();
include 'connection.php';

 if (isset($_POST["userPassword"])) {
     $hashedPassword = password_hash(trim($_POST["userPassword"]), PASSWORD_DEFAULT);
     $userToken = $_POST['tokenUser'];
     
     $query = "UPDATE users SET user_pass = '$hashedPassword' WHERE user_code = '$userToken' ";
     $update_user_query = $conn->prepare($query);
     
     if($update_user_query){ echo 'Password updated successfully.'; }
     else{ echo "Something went wrong. Please try again."; }
 }


?>