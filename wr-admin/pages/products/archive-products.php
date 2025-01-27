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

include("../src/connection.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Archive Products | Subserve UK</title>

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
  <?php include('../layout/sidebar.php');
  
  // SEARCH FILTER CATEOGRY
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_query_clause = '';
        
        if(!empty($_POST['cat_filter'])){
            $filter_cateogry = $_POST['cat_filter'];
            $product_query_clause .= "AND subcategory_id = '$filter_cateogry' ";
        }
        
        if(!empty($_POST['brand_filter'])){
            $filter_brand = $_POST['brand_filter'];
            $product_query_clause .= "AND brand_id = '$filter_brand' ";
        }
        
        if(!empty($_POST['part_num'])){
            $filter_part_num = $_POST['part_num'];
            $product_query_clause .= "AND part_no = '$filter_part_num' ";
        }
        
        if(!empty($_POST['memory_size'])){
            $filter_memory = $_POST['memory_size'];
            $product_query_clause .= "AND product_name LIKE '%$filter_memory%' ";
        }
        
        $product_query = 'SELECT id, product_name, image_url, sale_price, current_price, category_id, brand_id, slug, part_no, is_archive FROM products WHERE id IS NOT NULL AND is_archive = 1 '.$product_query_clause;
    }
    else{
        $product_query = 'SELECT id, product_name, image_url, sale_price, current_price, category_id, brand_id, slug, part_no, is_archive FROM products WHERE is_archive = 1 ';
        $product_query_clause = '';
    }
    
    $queryTotalCount = "SELECT COUNT(*) as total FROM products WHERE id IS NOT NULL AND is_archive = 1  $product_query_clause";
    $get_total_result = $conn->query($queryTotalCount);
    $totalCount = mysqli_fetch_row($get_total_result);

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="wr-admin-all-products-title">Archive Products <small>(total <?php echo $totalCount[0]; ?>)</small></h1>
          </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Archive Products</li>
            </ol>
          </div>
        </div>
        
        <div class="row mb-2">
            <!-- <form id="all_products_filter" action="" method="post">
                <div class="col-sm-3">
                    <div class="form-group">
                        <select name="cat_filter" class="form-control">
                            <option value="">Select Cateogry</option>
                            <?php
                                $get_all_categories = "SELECT id, name FROM categories WHERE parent_id IS NULL ";
                                $get_categories_result = $conn->query($get_all_categories);
                                if(mysqli_num_rows($get_categories_result) > 0){
                                    while($cat = mysqli_fetch_assoc($get_categories_result)){
                                        $catId = $cat['id'];
                                        echo '<optgroup label="'.$cat['name'].'">';
                                            $get_all_subcategories = "SELECT id, name FROM categories WHERE parent_id = '$catId' ";
                                            $get_subcategories_result = $conn->query($get_all_subcategories);
                                            if(mysqli_num_rows($get_subcategories_result) > 0){
                                                while($subCat = mysqli_fetch_assoc($get_subcategories_result)){
                                                    echo "<option value='".$subCat['id']."'>".$subCat['name']."</option>";
                                                }
                                            }
                                        echo '</optgroup>';
                                    }
                                }
                                else{
                                    echo "<option>No category found</option>";
                                }
                            ?>
                            
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <select name="brand_filter" class="form-control">
                            <option value="">Select Brand</option>
                            <?php
                                $get_all_brands = "SELECT id, name FROM brands WHERE status = '1' ";
                                $get_brands_result = $conn->query($get_all_brands);
                                if(mysqli_num_rows($get_brands_result) > 0){
                                    while($brand = mysqli_fetch_assoc($get_brands_result)){
                                        echo "<option value='".$brand['id']."'>".$brand['name']."</option>";
                                    }
                                }
                                else{
                                    echo "<option>No category found</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-2">
                    <div class="form-group">
                        <input type="text" name="part_num" placeholder="Enter Part No." class="form-control">
                    </div>
                </div>
                
                <div class="col-sm-2">
                    <div class="form-group">
                        <input type="text" name="memory_size" placeholder="Enter Memory" class="form-control">
                    </div>
                </div>
                
                <div class="col-sm-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form> -->
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
                    <th>ID</th>
                    <th>Product</th>
                    <th>Sale Price</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Part no.</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    
                        $limit = 10;  
                        if (isset($_GET["page"])) {$page  = $_GET["page"]; }
                        else { $page=1; } 
                        
                        $page_index = ($page-1) * $limit; 
                        
                        $get_all_products = "$product_query LIMIT $page_index, $limit ";
                        $get_product_result = $conn->query($get_all_products);
                        
                        if(mysqli_num_rows($get_product_result) > 0){
                            while($product = mysqli_fetch_assoc($get_product_result)){
                                $catId = $product['category_id'];
                                $get_category_name = "SELECT name FROM categories WHERE id = '$catId' ";
                                $get_category_result = $conn->query($get_category_name);
                                
                                while($cateogry = mysqli_fetch_assoc($get_category_result)){
                                    $categoryName = $cateogry['name'];
                                }
                                
                                $brandId = $product['brand_id'];
                                $get_brand_name = "SELECT name FROM brands WHERE id = '$brandId' ";
                                $get_brand_result = $conn->query($get_brand_name);
                                
                                while($brand = mysqli_fetch_assoc($get_brand_result)){
                                    $brandName = $brand['name'];
                                }
                                if(!isset($brandName)){ $brandName = '-';}
                    ?>
                          <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><img src="<?php echo $product['image_url']; ?>" style="width:50px"><?php echo $product['product_name']; ?></td>
                            <td>$<?php echo $product['sale_price']; ?></td>
                            <td><?php echo $categoryName; ?></td>
                            <td><?php echo $brandName; ?></td>
                            <td><?php echo $product['part_no']; ?></td>
                            <td>
                                <a href="/product/<?php echo $product['slug']; ?>" class="text-primary" target="_new">View</a> |
                                <a href="edit-product.php?epslug=<?php echo $product['id']; ?>" class="text-success">Edit</a> |                                
                                <a href="unarchive_product.php?id=<?php echo $product['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to archive this product?');">Unarchive</a> |
                                <a href="delete-product.php?id=<?php echo $product['id']; ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                            </td>
                          </tr>
                   <?php    
                            }
                        }
                        else{
                            echo "<tr><td colspan='7'>No product found!</td></tr>";
                        }
                   ?>
                </table>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 ">
                          <?php
                                $totalPages = ceil($totalCount[0] / $limit);
                                
                                $url = '/subserve/wr-admin/pages/products/archive-products.php';
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
   <strong>Copyright &copy; 2024 <a href="#">Subserve UK</a>.</strong> All rights reserved.
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
