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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All Orders | Subserve USA</title>

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
            <h1 class="wr-admin-all-orders-title">Orders</h1>
          </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Orders</li>
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
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Amount</th>
                    <th>Payment Method</th>
                    <th>Order Date</th>
                    <th>Customer Email</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    
                        $limit = 10;  
                        if (isset($_GET["page"])) {$page  = $_GET["page"]; }
                        else { $page=1; } 
                        
                        $page_index = ($page-1) * $limit; 
                        
                        $get_all_orders = "SELECT * FROM orders LIMIT $page_index, $limit";
                        $get_order_result = $conn->query($get_all_orders);
                        
                        if(mysqli_num_rows($get_order_result) > 0){
                            while($order = mysqli_fetch_assoc($get_order_result)){
                                
                                $orderId = $order['order_Id'];
                                $orderAmount = $order['order_amount'];
                                $orderDate = $order['order_date'];
                                
                                $orderUpdate = $order['order_update'];
                                
                                $get_order_details = "SELECT * FROM order_details WHERE order_Id = '$orderId'";
                                $get_order_details_result = $conn->query($get_order_details);
                                $orderDetails = mysqli_fetch_assoc($get_order_details_result);

                                $customerName = $orderDetails['customer_fname'] . " " . $orderDetails['customer_lname'];
                                $paymentMethod = $orderDetails['payment_method'];
                                $customerEmail = $orderDetails['customer_email'];
                    ?>
                          <tr>
                            <td><?php echo !empty($orderId) ? $orderId : 'Not Defined'; ?></td>
                            <td><?php echo !empty($customerName) ? $customerName : 'Not Defined'; ?></td>
                            <td>£<?php echo $orderAmount * 0.78; ?></td>
                            <td><?php echo !empty($paymentMethod) ? $paymentMethod : 'Not Defined'; ?></td>
                            <td><?php echo !empty($orderDate) ? $orderDate : 'Not Defined'; ?></td>
                            <td><?php echo !empty($customerEmail) ? $customerEmail : 'Not Defined'; ?></td>
                            <td>
                                <a href="order_details.php?orderId=<?php echo $orderId; ?>" class="text-primary" target="_new">View</a>
                                <!--|-->
                                <!--<a href="#" class="text-danger">Archive</a>-->
                            </td>
                          </tr>
                   <?php    
                            }
                        }
                        else{
                            echo "<tr><td colspan='6'>No orders found!</td></tr>";
                        }
                   ?>
                </table>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 ">
                          <?php
                                $totalCountQuery = "SELECT COUNT(*) as total FROM orders";
                                $totalCountResult = $conn->query($totalCountQuery);
                                $totalCount = mysqli_fetch_row($totalCountResult);

                                $totalPages = ceil($totalCount[0] / $limit);
                                
                                $url = '/wr-admin/pages/orders/orders.php';
                                $links = "";
                                
                                if ($totalPages >= 1 && $page <= $totalPages) {
                                    $links .= "<li class='page-item'><a class='page-link' href=\"{$url}?page=1\">1</a></li>";
                                    $i = max(2, $page - 5);
                                    if ($i > 2)
                                        $links .= " ... ";
                                    for (; $i < min($page + 6, $totalPages); $i++) {
                                        $links .= "<li class='page-item'><a class='page-link' href=\"{$url}?page={$i}\">{$i}</a></li>";
                                    }
                                    if ($i != $totalPages)
                                        $links .= " ... ";
                                    $links .= "<li class='page-item'><a class='page-link' href=\"{$url}?page={$totalPages}\">{$totalPages}</a></li>";
                                }
                                echo $links;
                          ?>
                          
                        </ul>
                  </div>
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
