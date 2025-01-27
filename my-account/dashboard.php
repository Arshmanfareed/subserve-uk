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

?>

<div class="page-checkout">
    <div class="container col-sm-mt70 col-md-mt100">
        <div class="empty-space col-xs-b15 col-sm-b30"></div>
        <div class="breadcrumbs">
            <a href="">home</a>
            <a href="">dashboard</a>
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
               <table id="customer-order-table" class="table table-striped">
                   <thead>
                       <tr>
                           <th>S. no</th>
                           <th>Order ID</th>
                           <th>Order Total</th>
                           <th>Order Date</th>
                           <th>Action</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php
                            // GET ORDERS FOR CURRENT USER
                            $get_customer_orders = "SELECT * FROM `orders` WHERE order_user = '$customerID' ";
                            
                            $get_customer_orders_results = $conn->query($get_customer_orders);
                            $orderCount = 1;
                           
                           if(mysqli_num_rows($get_customer_orders_results) > 0){
                                while($orders = mysqli_fetch_assoc($get_customer_orders_results)){
                        ?>
                                   <tr>
                                       <td><?php echo $orderCount; ?></td>
                                       <td><?php echo $orders['order_Id']; ?></td>
                                       <td>£<?php echo number_format($orders['order_amount'], 2); ?></td>
                                       <td><?php echo $orders['order_date']; ?></td>
                                       <td><a href="/my-account/order-details/<?php echo $orders['order_Id']; ?>" ><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                                   </tr>
                        <?php
                            $orderCount++;    
                                } // END WHILE
                           } // END IF
                           else{ echo '<tr> <td colspan="5"><p>No order found</p></td> </tr>'; }
                        ?>   
                   </tbody>
               </table>
           </div>
       </div>
    </div>

    <div class="empty-space col-xs-b35 col-md-b70"></div>
</div>
<?php
include('../layouts/footer-scripts2.php');

?>



<?php
include('../layouts/footer-end.php');
?>