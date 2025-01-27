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
    if(!empty($_POST['user_full_name']) && !empty($_POST['user_email_address']) && !empty($_POST['user_street']) && !empty($_POST['user_appartment']) && !empty($_POST['user_city']) && !empty($_POST['user_state']) && !empty($_POST['user_zip']) && !empty($_POST['user_phone_number'])){
        
        $user_fname = $_POST['user_full_name'];
        $user_email = $_POST['user_email_address'];
        $user_street = $_POST['user_street'];
        $user_appt = $_POST['user_appartment'];
        $user_city = $_POST['user_city'];
        $user_state = $_POST['user_state'];
        $user_zip = $_POST['user_zip'];
        $user_phone_number = $_POST['user_phone_number'];
        
        $update_query_user_data = "UPDATE `users` SET user_fname = '$user_fname', user_email = '$user_email', user_street = '$user_street' , user_apartment = '$user_appt', user_city = '$user_city', user_state = '$user_state', user_zip = '$user_zip' , user_phone = '$user_phone_number' WHERE user_id = '$customerID' ";
        
        if(!$conn->query($update_query_user_data)){
            $msgResponse = "<p class='responseErr'>Something went wrong. Please try again.</p>";
        }
        else{
            $msgResponse = "<p class='responseSuccess'>Profile updated successfully.</p>";
        }
        
    }
    else{
        $msgResponse = "<p class='responseErr'>Please fill all the fields</p>";
    }
}

$user_data_query = "SELECT * FROM users WHERE user_id = '$customerID' ";
$get_user_data_results = $conn->query($user_data_query);

while($user = mysqli_fetch_assoc($get_user_data_results)){
    $user_name = $user['user_fname'];
    $user_email = $user['user_email'];
    $user_street = $user['user_street'];
    $user_apartment = $user['user_apartment'];
    $user_city = $user['user_city'];
    $user_state = $user['user_state'];
    $user_zip = $user['user_zip'];
    $user_phone = $user['user_phone'];
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
                   <div class="col-sm-6 col-xs-12">
                       <div class="form-group">
                           <label>Full Name</label>
                           <input type="text" id="user_full_name" name="user_full_name" value="<?php echo $user_name; ?>" class="form-control" />
                       </div>
                   </div>
                   
                   <div class="col-sm-6 col-xs-12">
                       <div class="form-group">
                           <label>Email Address</label>
                           <input type="text" id="user_email_address" name="user_email_address" value="<?php echo $user_email; ?>" class="form-control" />
                       </div>
                   </div>
                   
                   <div class="col-sm-6 col-xs-12">
                       <div class="form-group">
                           <label>Street Address</label>
                           <input type="text" id="user_street" name="user_street" value="<?php echo $user_street; ?>" class="form-control" />
                       </div>
                   </div>
                   
                   <div class="col-sm-6 col-xs-12">
                       <div class="form-group">
                           <label>Appartment</label>
                           <input type="text" id="user_appartment" name="user_appartment" value="<?php echo $user_apartment; ?>" class="form-control" />
                       </div>
                   </div>
                   <div class="col-sm-6 col-xs-12">
                       <div class="form-group">
                           <label>City</label>
                           <input type="text" id="user_city" name="user_city" value="<?php echo $user_city; ?>" class="form-control" />
                       </div>
                   </div>
                   
                   <div class="col-sm-6 col-xs-12">
                       <div class="form-group">
                           <label>State</label>
                           <input type="text" id="user_state" name="user_state" value="<?php echo $user_state; ?>" class="form-control" />
                       </div>
                   </div>
                   
                   <div class="col-sm-6 col-xs-12">
                       <div class="form-group">
                           <label>ZIP</label>
                           <input type="text" id="user_zip" name="user_zip" value="<?php echo $user_zip; ?>" class="form-control" />
                       </div>
                   </div>
                   
                   <div class="col-sm-6 col-xs-12">
                       <div class="form-group">
                           <label>Phone Number</label>
                           <input type="text" id="user_phone_number" name="user_phone_number" value="<?php echo $user_phone; ?>" class="form-control" />
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

<script>
    $(document).ready(function(){
        $(document).on("click", "#customer_profile_edit_btn",function() { 
           $("#customer_profile_form").submit();
        });
    });
</script>