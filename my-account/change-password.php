<?php
session_start();
if (!isset($_SESSION['user']) || (isset($_SESSION['cart']) && empty($_SESSION['cart']))) {
    header("Location: /");
    exit();
}
include('../layouts/header.php');
require_once '../src/config.php'; 
include '../src/connection.php';

$customerID = $_SESSION['user']['user_id'];

// FORM SUBMIT - CUSTOMER UPDATE
if ($_SERVER["REQUEST_METHOD"] === "POST" ) {
    if(!empty($_POST['user_new_password']) && !empty($_POST['confirm_new_password']) ){
        
        $user_new_pass = password_hash(trim($_POST["user_new_password"]), PASSWORD_DEFAULT);
        $user_confirm_pass = password_hash(trim($_POST["confirm_new_password"]), PASSWORD_DEFAULT);
        
        
        if($_POST["user_new_password"] !== $_POST["confirm_new_password"]){
            $msgResponse = "<p class='responseErr'>New password and confirm new password does not match.</p>";
        }
        else{
                $update_query_user_data = "UPDATE `users` SET user_pass = '$user_new_pass' WHERE user_id = '$customerID' ";
            
                if(!$conn->query($update_query_user_data)){
                    $msgResponse = "<p class='responseErr'>Something went wrong. Please try again.</p>";
                }
                else{
                    $msgResponse = "<p class='responseSuccess'>Your password has been updated successfully.</p>";
                }
        }
        
    }
    else{
        $msgResponse = "<p class='responseErr'>Please fill all the fields</p>";
    }
}

?>

<div class="page-checkout">
    <div class="container col-sm-mt70 col-md-mt100">
        <div class="empty-space col-xs-b15 col-sm-b30"></div>
        <div class="breadcrumbs">
            <a href="/">home</a>
            <a href="/my-account/dashboard.php">dashboard</a>
            <a href="">Profile</a>
        </div>
        <div class="empty-space col-xs-b15 col-sm-b30 col-md-b50"></div>
        <div class="text-center">
            <div class="simple-article size-3 grey uppercase col-xs-b5">my account</div>
            <div class="h2">customer dashboard</div>
            <div class="title-underline center"><span></span></div>
        </div>
    </div>

    <div class="empty-space col-xs-b35 col-md-b70"></div>

    <div class="container ">
       <div class="row">
           <div class="col-sm-3">
               <div class="customer-sidebar">
                   <div class="customer-sidebar-header">
                       <h3>Hi, <?php echo $_SESSION['user']['fname']; ?></h3>
                   </div>
                   <div class="customer-sidebar-nav">
                       <?php include("inc/customer-sidebar.php"); ?>
                   </div>
               </div>
           </div>
           <div class="col-sm-9">
               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="customer_profile_form">
                    <div class="col-sm-8 col-xs-12">
                       <div class="form-group">
                           <label>Enter New Password</label>
                           <input type="password" name="user_new_password" class="form-control" />
                       </div>
                   </div>
                   
                   <div class="col-sm-8 col-xs-12">
                       <div class="form-group">
                           <label>Confirm New Password</label>
                           <input type="password" name="confirm_new_password" class="form-control" />
                       </div>
                   </div>
                   
                   
                   <?php
                        if(isset($msgResponse)){ echo '<div class="col-xs-12">'.$msgResponse.'</div>'; }
                   ?>
                   <div class="col-sm-6 col-xs-12">
                       <input type="submit" id="customer_profile_edit_btn" name="update" class="btn btn-info" value="Update">
                   </div>
                </form>   
           </div>
       </div>
    </div>

    <div class="empty-space col-xs-b35 col-md-b70"></div>
</div>
<?php
    include('../layouts/footer-scripts2.php');
    include('../layouts/footer-end.php');
?>
