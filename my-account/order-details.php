<?php
session_start();
if (!isset($_SESSION['user']) || (isset($_SESSION['cart']) && empty($_SESSION['cart']))) {
    header("Location: /");
    exit();
}
include('../layouts/header.php');
require_once '../src/config.php'; 
include '../src/connection.php';

// Use mysqli_real_escape_string to prevent SQL injection
$order_id = $conn->real_escape_string($_GET['oslug']);
$customerID = $_SESSION['user']['user_id'];

//$order_data = "SELECT o.* , oi.item_name, oi.item_qty, oi.item_price, oi.item_total FROM orders o LEFT JOIN order_item oi ON o.order_Id = oi.item_order_id WHERE o.order_Id = '$order_id' ";

$order_data = "SELECT * FROM orders WHERE order_Id = '$order_id' AND order_user = '$customerID' ";
$get_order_results = $conn->query($order_data);

while($orderData = mysqli_fetch_assoc($get_order_results)){
    $orderAmount = $orderData['order_amount'];
    $orderDate = $orderData['order_date'];
    $street_address = $orderData['street_address'];
    $appartment = $orderData['appartment'];
    $town = $orderData['town'];
    $state = $orderData['state'];
    $postal_code = $orderData['postal_code'];
    
    // Combine the address fields
    $addressParts = array_filter([
        $street_address,
        $appartment,
        $town,
        $state,
        $postal_code
    ]);

    $formattedAddress = implode(', ', $addressParts);

}

?>

<div class="page-checkout">
    <div class="container col-sm-mt70 col-md-mt100">
        <div class="empty-space col-xs-b15 col-sm-b30"></div>
        <div class="breadcrumbs">
            <a href="/">home</a>
            <a href="/my-account/dashboard.php">My Account</a>
            <a href="">order id: <?php echo $order_id; ?></a>
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
                           <th>Item Name</th>
                           <th>Item Amount</th>
                           <th>Item Qty</th>
                           <th>Subtotal</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php
                            // GET ORDERS FOR CURRENT USER
                            $get_order_item_data = "SELECT * FROM `order_item` WHERE item_order_id = '$order_id' ";
                            
                           $get_order_item_results = $conn->query($get_order_item_data);
                           if(mysqli_num_rows($get_order_item_results) > 0){
                                while($order_items = mysqli_fetch_assoc($get_order_item_results)){
                        ?>
                                   <tr>
                                       <td><?php echo $order_items['item_name']; ?></td>
                                       <td>£<?php echo number_format($order_items['item_price'], 2); ?></td>
                                       <td><?php echo $order_items['item_qty']; ?></td>
                                       <td>£<?php echo number_format($order_items['item_total'], 2); ?></td>
                                   </tr>
                        <?php
                                } // END WHILE
                           } // END IF
                           else{ echo '<tr> <td colspan="5"><p>No item found</p></td> </tr>'; }
                           
                            // GET ORDERS FOR CURRENT USER
                            $get_order_details = "SELECT * FROM `order_details` WHERE order_id = '$order_id' ";
                            $get_order_details_results = $conn->query($get_order_details); 
                            while($order_data = mysqli_fetch_assoc($get_order_details_results)){
                                $payment_method = $order_data['payment_method'];
                                $payment_id = $order_data['paymentId'];
                            }
                           
                        ?>   
                            <tr>
                                <td></td>
                                <td colspan="2">Total Amount:</td>
                                <td>$<?php echo number_format($orderAmount, 2); ?></td>
                            </tr>
                   </tbody>
               </table>
               
               <table class="table table-striped">
                   <tr>
                       <td>Order Date: </td>
                       <td><?php echo $orderDate; ?></td>
                   </tr>
                   <tr>
                       <td>Shipping Address: </td>
                       <td><?php echo $formattedAddress; ?></td>
                   </tr>
                   <?php if(!empty($payment_method)){ ?>
                       <tr>
                           <td>Payment Method: </td>
                           <td><?php echo $payment_method; ?></td>
                       </tr>
                    <?php }
                        if(!empty($payment_id)){ ?>
                           <tr>
                               <td>Transaction ID: </td>
                               <td><?php echo $payment_id; ?></td>
                           </tr>
                    <?php } ?>
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