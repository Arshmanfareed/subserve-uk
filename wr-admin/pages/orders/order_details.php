<?php 
    session_start();
    if (empty($_SESSION) || !isset($_SESSION['user_role'])) {
        header("Location: /wr-admin/login.php");
        exit();
    }

    
    if (empty($_SESSION) || !isset($_SESSION['user_role']) && $_SESSION['user_type'] == 'wr-user' && $_SESSION['user_role'] != 3) {
        header("Location: /wr-admin/login.php");
        exit();
    }

    include("../src/connection.php"); 

    if (!isset($_GET['orderId']) || empty($_GET['orderId'])) {
        echo $_GET['orderId'];
        //header("Location: all-orders.php");
        exit();
    }

    $orderId = $_GET['orderId'];

    // Fetch order details
    $orderQuery = "SELECT * FROM orders WHERE order_Id = '$orderId'";
    $orderResult = $conn->query($orderQuery);
    $order = mysqli_fetch_assoc($orderResult);

    // Fetch order details
    $orderDetailsQuery = "SELECT * FROM order_details WHERE order_Id = '$orderId'";
    $orderDetailsResult = $conn->query($orderDetailsQuery);
    $orderDetails = mysqli_fetch_assoc($orderDetailsResult);

    // Fetch order items
    $orderItemsQuery = "SELECT * FROM order_item WHERE item_order_id = '$orderId'";
    $orderItemsResult = $conn->query($orderItemsQuery);

    if (!$order || !$orderDetails) {
        header("Location: all-orders.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Order | Subserve USA</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../dist/css/custom.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include('../layout/sidebar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="wr-admin-all-orders-title">Order Details</h1>
          </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="all-orders.php">Orders</a></li>
              <li class="breadcrumb-item active">View Order</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body">
                <h3>Order Information</h3>
                <table class="table table-bordered">
                  <tr>
                    <th>Order ID</th>
                    <td><?php echo $order['order_Id']; ?></td>
                  </tr>
                  <tr>
                    <th>Order Amount</th>
                    <td>£<?php echo $order['order_amount'] * 0.78; ?></td>
                  </tr>
                  <tr>
                    <th>Order Date</th>
                    <td><?php echo $order['order_date']; ?></td>
                  </tr>
                </table>

                <h3 class="mt-5">Customer Information</h3>
                <table class="table table-bordered">
                  <tr>
                    <th>First Name</th>
                    <td><?php echo $orderDetails['customer_fname']; ?></td>
                  </tr>
                  <tr>
                    <th>Last Name</th>
                    <td><?php echo $orderDetails['customer_lname']; ?></td>
                  </tr>
                  <tr>
                    <th>Company Name</th>
                    <td><?php echo $orderDetails['company_name']; ?></td>
                  </tr>
                  <tr>
                    <th>Address 1</th>
                    <td><?php echo $orderDetails['street_address']; ?></td>
                  </tr>
                  <tr>
                    <th>Address 2</th>
                    <td><?php echo $orderDetails['appartment']; ?></td>
                  </tr>
                  <tr>
                    <th>Town</th>
                    <td><?php echo $orderDetails['town']; ?></td>
                  </tr>
                  <tr>
                    <th>State</th>
                    <td><?php echo $orderDetails['state']; ?></td>
                  </tr>
                  <tr>
                    <th>Postal Code</th>
                    <td><?php echo $orderDetails['postal_code']; ?></td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td><?php echo $orderDetails['customer_email']; ?></td>
                  </tr>
                  <tr>
                    <th>Phone</th>
                    <td><?php echo $orderDetails['customer_phone']; ?></td>
                  </tr>
                  <tr>
                    <th>Order Notes</th>
                    <td><?php echo $orderDetails['order_notes']; ?></td>
                  </tr>
                  <tr>
                    <th>Payment Method</th>
                    <td><?php echo $orderDetails['payment_method']; ?></td>
                  </tr>
                  <tr>
                    <th>Payment ID</th>
                    <td><?php echo $orderDetails['paymentId']; ?></td>
                  </tr>
                </table>

                <h3 class="mt-5">Order Items</h3>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Item Name</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if(mysqli_num_rows($orderItemsResult) > 0){
                          while($item = mysqli_fetch_assoc($orderItemsResult)){
                    ?>
                            <tr>
                              <td><?php echo $item['item_name']; ?></td>
                              <td><?php echo $item['item_qty']; ?></td>
                              <td>£<?php echo $item['item_price'] * 0.78; ?></td>
                              <td>$<?php echo $item['item_total']; ?></td>
                            </tr>
                    <?php    
                          }
                      } else {
                          echo "<tr><td colspan='4'>No items found!</td></tr>";
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
   <strong>Copyright &copy; 2024 <a href="#">Subserve USA</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->

</body>
</html>
