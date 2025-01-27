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




// Database configuration
$host = "localhost";
$dbname = "subserve_co_uksubserve_beta";
$username = "root";
$password = "";

try {
    // Create a new PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $productUpdated = false;

    // Fetch product details for editing
    if (isset($_GET['epslug'])) {
      $product_id = $conn->real_escape_string($_GET['epslug']);

        $productStmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $productStmt->execute([':product_id' => $product_id]);
        $product = $productStmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            die("Product not found.");
        }

        // Fetch existing specifications
        $specStmt = $pdo->prepare("SELECT * FROM product_specifications WHERE product_id = :product_id");
        $specStmt->execute([':product_id' => $product_id]);
        $specifications = $specStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Handle form submission for updating product
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_id = $_POST['user_id'];
        $category_id = $_POST['category_id'];
        $subcategory_id = $_POST['subcategory_id'];
        $brand_id = $_POST['brand_id'];
        $product_type_id = $_POST['product_type_id'];
        $product_name = $_POST['product_name'];
        $description = $_POST['description'];
        $part_no = $_POST['part_no'];
        $condition = $_POST['condition'];
        $purchase_price = $_POST['purchase_price'];
        $sale_price = $_POST['sale_price'];
        $discount_price = $_POST['discount_price'];
        $discount_percentage = $_POST['discount_percentage'];
        $current_price = $_POST['current_price'];
        $status = $_POST['status'];
        $state = $_POST['state'];
        $gtin = $_POST['gtin'];
        $google_categories = $_POST['google_categories'];
        $product_url = $_POST['product_url'];
        $meta_keywords = $_POST['meta_keywords'];
        $meta_titles = $_POST['meta_titles'];
        $meta_description = $_POST['meta_description'];
        $schema_markup = $_POST['schema_markup'];
        $schema_markup2 = $_POST['schema_markup2'];
        $schema_markup3 = $_POST['schema_markup3'];
        $weight = $_POST['weight'];
        $slug = $_POST['slug'];
        $brand_name = $_POST['brand_name'];

        $image_url = $product['image_url']; // Keep existing image URL by default

        // Handle image upload
        // if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        //     $image_name = $_FILES['image']['name'];
        //     $image_tmp_name = $_FILES['image']['tmp_name'];
        //     $upload_dir = 'uploads/';
        //     $image_url = $upload_dir . basename($image_name);

        //     if (!move_uploaded_file($image_tmp_name, $image_url)) {
        //         echo "Failed to upload image.";
        //     } else {
        //         $image_url = 'http://' . $_SERVER['HTTP_HOST'] . '/subserve/wr-admin/pages/products/' . $image_url;
        //     }
        // }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Image details
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $upload_dir = '../../../assets/images/';  // Upload directory relative to current script
            $unique_name = time() . '_' . rand(1000, 9999) . '_' . basename($image_name);
            $image_url = $upload_dir . $unique_name;
        
            // Move uploaded file to the desired directory
            if (!move_uploaded_file($image_tmp_name, $image_url)) {
                echo "Failed to upload image.";
            }
        
            // Image URL to store in the database (relative path)
            $image_url = 'http://' . $_SERVER['HTTP_HOST'] . '/subserve/assets/images/' . $unique_name;
        
            // Get alt text (default to product name if not set)
            $alt_text = isset($_POST['product_name']) ? $_POST['product_name'] : ''; 
        
            // Prepare SQL to insert new image (for new or editing existing)
            try {
                // Check if an image already exists for this product
                $check_stmt = $pdo->prepare("SELECT id FROM product_images WHERE product_id = :product_id LIMIT 1");
                $check_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $check_stmt->execute();
        
                if ($check_stmt->rowCount() > 0) {
                    // Image exists, update it
                    $update_stmt = $pdo->prepare("UPDATE product_images SET image = :image, alt = :alt WHERE product_id = :product_id");
                    $update_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                    $update_stmt->bindParam(':image', $unique_name, PDO::PARAM_STR);
                    $update_stmt->bindParam(':alt', $alt_text, PDO::PARAM_STR);
                    
                    // Execute the update
                    if ($update_stmt->execute()) {
                        echo "Image updated successfully!";
                    } else {
                        echo "Failed to update the image.";
                    }
                } else {
                    // No image exists, insert new image
                    $insert_stmt = $pdo->prepare("INSERT INTO product_images (product_id, image, alt) VALUES (:product_id, :image, :alt)");
                    $insert_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                    $insert_stmt->bindParam(':image', $unique_name, PDO::PARAM_STR);
                    $insert_stmt->bindParam(':alt', $alt_text, PDO::PARAM_STR);
        
                    // Execute the insert
                    if ($insert_stmt->execute()) {
                        echo "Image uploaded and saved successfully!";
                    } else {
                        echo "Failed to upload the image.";
                    }
                }
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        }

        $sql = "UPDATE products 
        SET user_id = :user_id, category_id = :category_id, subcategory_id = :subcategory_id, 
            brand_id = :brand_id, product_type_id = :product_type_id, product_name = :product_name, 
            description = :description, part_no = :part_no, `condition` = :condition, purchase_price = :purchase_price, 
            sale_price = :sale_price, discount_price = :discount_price, 
            discount_percentage = :discount_percentage, current_price = :current_price, 
            status = :status, state = :state, gtin = :gtin, google_categories = :google_categories, 
            image_url = :image_url, product_url = :product_url, meta_keywords = :meta_keywords, 
            meta_titles = :meta_titles, meta_description = :meta_description, schema_markup = :schema_markup, 
            brand_name = :brand_name, weight = :weight
        WHERE id = :product_id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':user_id' => $user_id,
    ':category_id' => $category_id,
    ':subcategory_id' => $subcategory_id,
    ':brand_id' => $brand_id,
    ':product_type_id' => $product_type_id,
    ':product_name' => $product_name,
    ':description' => $description,
    ':part_no' => $part_no,
    ':condition' => $condition,
    ':purchase_price' => $purchase_price,
    ':sale_price' => $sale_price,
    ':discount_price' => $discount_price,
    ':discount_percentage' => $discount_percentage,
    ':current_price' => $current_price,
    ':status' => $status,
    ':state' => $state,
    ':gtin' => $gtin,
    ':google_categories' => $google_categories,
    ':image_url' => $image_url,
    ':product_url' => $product_url,
    ':meta_keywords' => $meta_keywords,
    ':meta_titles' => $meta_titles,
    ':meta_description' => $meta_description,
    ':schema_markup' => $schema_markup,
    ':brand_name' => $brand_name,
    ':product_id' => $product_id,
    ':weight' => $weight
]);




if (!empty($_POST['specifications'])) {
    
    
    foreach ($_POST['specifications'] as $spec) {
            if (isset($spec['field_id'])) {           
                // Update existing specification using `field_id` and `product_id`
                $specStmt = $pdo->prepare("
                    UPDATE product_specifications 
                    SET field_name = :field_name, field_value = :field_value 
                    WHERE id = :id AND product_id = :product_id
                ");
                $specStmt->execute([
                    ':field_name' => $spec['field_name'],
                    ':field_value' => $spec['field_value'],
                    ':id' => $spec['field_id'],
                    ':product_id' => $product_id
                ]);
            } else {
                             
                    // Insert new specification if it does not already exist
                    $specStmt = $pdo->prepare("
                        INSERT INTO product_specifications (product_id, field_name, field_value) 
                        VALUES (:product_id, :field_name, :field_value)
                    ");
                    $specStmt->execute([
                        ':product_id' => $product_id,
                        ':field_name' => $spec['field_name'],
                        ':field_value' => $spec['field_value']
                    ]);                
            }
    }

}


  //     echo "<pre>";
  // print_r($_POST['specifications']);
  // exit;
      



  header('Location: edit-product.php?epslug=' . $_GET['epslug']); // Redirect to blogs list after update
  exit;

    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;


// // UPDATE PRODUCT ON FORM SUBMIT
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $product_name = $_POST['productName'];
//     $meta_title = $_POST['metaTitle'];
//     $meta_keywords = $_POST['metaKeywords'];
//     $product_slug = $_POST['productSlug'];
//     $meta_description = $_POST['metaDescription'];
//     $schema_markup = $_POST['schemaMarkup'];
//     $schema_markup2 = $_POST['schemaMarkup2'];
//     $schema_markup3 = $_POST['schemaMarkup3'];
//     $canonical_tag = $_POST['canonicaTag'];
    
//     $meta_description = str_replace("'", "''", $meta_description);
    
//     $update_query_product_data = "UPDATE `products` SET product_name = '$product_name', meta_titles = '$meta_title', meta_keywords = '$meta_keywords', slug = '$product_slug', meta_description = '$meta_description', schema_markup = '$schema_markup', schema_markup2 = '$schema_markup2', schema_markup3 = '$schema_markup3', canonical_tag = '$canonical_tag' WHERE id = '$product_id' ";
            
//     if(!$conn->query($update_query_product_data)){
//             $msgResponse = '<div class="alert alert-danger" role="alert">Something went wrong. Please try again.</div>';
//     }
//     else{
//             $msgResponse = '<div class="alert alert-success" role="alert">Product updated successfully.</div>';
//     }                
    
// }

// $get_product_query = "SELECT * FROM products WHERE id = '$product_id' ";
// $get_product_result = $conn->query($get_product_query);

// while($product = mysqli_fetch_assoc($get_product_result)){
//     $product_name = $product['product_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Product | <?php echo $product['product_name']; ?> |Subserve UK</title>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/custom.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.css">
  
  <style>
      #edit_product_form .col-md-6, #edit_product_form .col-md-12{
            float: left !important;    
        }
  </style>
  
</head>
<style>
.specification-row {
    margin-bottom: 10px;
}
.specification-row input {
    width: 37%;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
</style>
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
          <div class="col-sm-9">
            <h1><?php echo $product['product_name']; ?></h1>
          </div>
         <div class="col-sm-3">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Product</li>
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
              <?php if(isset($msgResponse)){ echo $msgResponse; } ?>
               
                <form id="edit_product_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" enctype="multipart/form-data">

                        <!-- User ID -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $product['user_id']; ?>" readonly>
                        </div>

                        <!-- Category ID -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category ID</label>
                            <input type="text" class="form-control" id="category_id" name="category_id" value="<?php echo $product['category_id']; ?>" required>
                        </div>

                        <!-- Subcategory ID -->
                        <div class="mb-3">
                            <label for="subcategory_id" class="form-label">Subcategory ID</label>
                            <input type="text" class="form-control" id="subcategory_id" name="subcategory_id"  value="<?php echo $product['subcategory_id']; ?>" required>
                        </div>

                        <!-- Brand ID -->
                        <div class="mb-3">
                            <label for="brand_id" class="form-label">Brand ID</label>
                            <input type="text" class="form-control" id="brand_id" name="brand_id"  value="<?php echo $product['brand_id']; ?>" required>
                        </div>

                        <!-- Product Type ID -->
                        <div class="mb-3">
                            <label for="product_type_id" class="form-label">Product Type ID</label>
                            <input type="text" class="form-control" id="product_type_id" name="product_type_id"  value="<?php echo $product['product_type_id']; ?>" required>
                        </div>

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name"  value="<?php echo $product['product_name']; ?>" minlength="30" maxlength="70" required>
                            <small class="form-text text-muted">Product name must be between 30 and 70 characters.</small>
                        </div>

                        <!-- Description -->

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="code_preview0" name="description"><?php echo $product['description']; ?></textarea>
                        </div>
                        <div class="mb-3">
                          <div id="specifications-container">
                                  <label>Product Specifications</label>
                                  
                                  <!-- Loop through the existing specifications -->
                                  <?php
                                  if (!empty($specifications)) {
                                      $i = 1;
                                      foreach ($specifications as $index => $spec) {
                                          ?>
                                          <div class="specification-row">
                                              <input type="hidden" name="specifications[<?php echo $i; ?>][field_id]" value="<?php echo $spec['id']; ?>">
                                              <input type="text" name="specifications[<?php echo $i; ?>][field_name]" value="<?php echo htmlspecialchars($spec['field_name']); ?>" placeholder="Field Name" required>
                                              <input type="text" name="specifications[<?php echo $i; ?>][field_value]" value="<?php echo htmlspecialchars($spec['field_value']); ?>" placeholder="Field Value" required>
                                              <button type="button" class="remove-specification btn btn-danger" data-id="<?php echo $spec['id']; ?>">Remove</button>
                                          </div>
                                          <?php
                                          $i++;
                                      }
                                  }
                                  ?>                                 

                              </div>
                              <button type="button" id="add-specification" class="btn btn-success">Add More</button>
                        </div>
                        <!-- Part No -->
                        <div class="mb-3">
                            <label for="part_no" class="form-label">Part No</label>
                            <input type="text" class="form-control" id="part_no" name="part_no"  value="<?php echo $product['part_no']; ?>">
                        </div>
                        
                        
                        <!-- Condition -->
                        <div class="mb-3">
                            <label for="condition" class="form-label">Condition</label>
                            <select class="form-control"  id="condition" name="condition">
                                <option value="New" <?php if($product['condition'] == "New"){echo 'selected'; } ?> >New</option>
                                <option value="New Open Box" <?php if($product['condition'] == "New Open Box"){echo 'selected'; } ?> >New Open Box</option>
                                <option value="Used" <?php if($product['condition'] == "Used"){echo 'selected'; } ?>>Used</option>
                                <option value="Refurbished" <?php if($product['condition'] == "Refurbished"){echo 'selected'; } ?>>Refurbished</option>
                            </select>
                        </div>



                        <!-- Purchase Price -->
                        <div class="mb-3">
                            <label for="purchase_price" class="form-label">Purchase Price</label>
                            <input type="number" step="0.01" class="form-control" id="purchase_price" name="purchase_price" value="<?php echo $product['purchase_price']; ?>" required>
                        </div>

                        <!-- Sale Price -->
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" value="<?php echo $product['sale_price']; ?>" required>
                        </div>

                        <!-- Discount Price -->
                        <div class="mb-3">
                            <label for="discount_price" class="form-label">Discount Price</label>
                            <input type="number" step="0.01" class="form-control" id="discount_price" name="discount_price" value="<?php echo $product['discount_price']; ?>">
                        </div>

                        <!-- Discount Percentage -->
                        <div class="mb-3">
                            <label for="discount_percentage" class="form-label">Discount Percentage</label>
                            <input type="number" step="0.01" class="form-control" id="discount_percentage" name="discount_percentage" value="<?php echo $product['discount_percentage']; ?>">
                        </div>

                        <!-- Current Price -->
                        <div class="mb-3">
                            <label for="current_price" class="form-label">Current Price</label>
                            <input type="number" step="0.01" class="form-control" id="current_price" name="current_price" value="<?php echo $product['current_price']; ?>" required>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php echo ($product['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                            <option value="0" <?php echo ($product['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>

                        <!-- State -->
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" value="<?php echo $product['state']; ?>">
                        </div>

                        <!-- GTIN -->
                        <div class="mb-3">
                            <label for="gtin" class="form-label">GTIN</label>
                            <input type="text" class="form-control" id="gtin" name="gtin" value="<?php echo $product['gtin']; ?>">
                        </div>

                        <!-- Google Categories -->
                        <div class="mb-3">
                            <label for="google_categories" class="form-label">Google Categories</label>
                            <input type="text" class="form-control" id="google_categories" name="google_categories" value="<?php echo $product['google_categories']; ?>">
                        </div>

                        <!-- Image URL -->
                        <!-- <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="image_url" name="image_url">
                        </div> -->

                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image (WEBP, Max 40KB)</label>
                            <input type="file" class="form-control" id="image" name="image" accept=".webp">
                            <small class="form-text text-muted">Only WEBP images are allowed, and the size must not exceed 40 KB.</small>

                            <!-- Image preview container -->
                            <div id="image-preview-container" style="margin-top: 10px;">
                                <label for="preview" style="width: 100%;">Image Preview:</label>
                                <img id="image-preview" src="<?php echo $product['image_url']; ?>" alt="Image Preview" style="max-width: 100%; max-height: 300px; border: 1px solid #ddd;">
                            </div>
                        </div>

                        <!-- Product URL -->
                        <div class="mb-3">
                            <label for="product_url" class="form-label">Product URL</label>
                            <input type="text" class="form-control" id="product_url" name="product_url" value="<?php echo $product['product_url']; ?>" readonly>
                        </div>

                        <!-- Meta Keywords -->
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="2"><?php echo $product['meta_keywords']; ?></textarea>
                        </div>

                        <!-- Meta Titles -->
                        <div class="mb-3">
                            <label for="meta_titles" class="form-label">Meta Titles</label>
                            <input type="text" class="form-control" id="meta_titles" name="meta_titles" value="<?php echo $product['meta_titles']; ?>">
                        </div>

                        <!-- Meta Description -->
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="2"><?php echo $product['meta_description']; ?></textarea>
                        </div>

                        <!-- Schema Markup -->
                        <div class="mb-3">
                            <label for="schema_markup" class="form-label">Schema Markup</label>
                            <textarea class="form-control" id="schema_markup" name="schema_markup" rows="2"><?php echo $product['schema_markup']; ?></textarea>
                        </div>

                        <!-- Schema Markup 2 -->
                        <div class="mb-3">
                            <label for="schema_markup2" class="form-label">Schema Markup 2</label>
                            <textarea class="form-control" id="schema_markup2" name="schema_markup2" rows="2"><?php echo $product['schema_markup2']; ?></textarea>
                        </div>

                        <!-- Schema Markup 3 -->
                        <div class="mb-3">
                            <label for="schema_markup3" class="form-label">Schema Markup 3</label>
                            <textarea class="form-control" id="schema_markup3" name="schema_markup3" rows="2"><?php echo $product['schema_markup3']; ?></textarea>
                        </div>

                        <!-- Weight -->
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="<?php echo $product['weight']; ?>">
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="<?php echo $product['slug']; ?>" readonly>
                        </div>

                        <!-- Brand Name -->
                        <div class="mb-3">
                            <label for="brand_name" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name" value="<?php echo $product['brand_name']; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Edit Product</button>
                </form>
          
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#code_preview0').summernote({height: 300});
        });
    </script>
    <script>
        // tinymce.init({
        //     selector: '#description',
        //     plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        //     toolbar_mode: 'floating',
        // });
    </script>
  

    <script>

        // Add validation logic
        document.getElementById('edit_product_form').addEventListener('submit', function(event) {
            const productName = document.getElementById('product_name').value.trim();
            const imageInput = document.getElementById('image');
            const purchase_price = document.getElementById('purchase_price');
            const sale_price = document.getElementById('sale_price');
            const discount_price = document.getElementById('discount_price');
            const current_price = document.getElementById('current_price');
            const file = imageInput.files[0];

            // Validate product name length
            if (productName.length < 30 || productName.length > 70) {
                alert("Product name must be between 30 and 70 characters.");
                event.preventDefault();
                return;
            }           

            // Validate image file
            // if (file) {
            //     const maxFileSize = 40 * 1024; // 40 KB
            //     const allowedType = "image/webp";

            //     if (file.size > maxFileSize) {
            //         alert("Image size must not exceed 40 KB.");
            //         event.preventDefault();
            //         return;
            //     }

            //     if (file.type !== allowedType) {
            //         alert("Only WEBP images are allowed.");
            //         event.preventDefault();
            //         return;
            //     }
            // } else {
            //     alert("Please upload a valid image.");
            //     event.preventDefault();
            // }
        });

        // Add new specification field
        document.getElementById('add-specification').addEventListener('click', function() {
            const container = document.getElementById('specifications-container');
            const index = container.children.length;
            const newField = document.createElement('div');
            newField.classList.add('specification-row');
            newField.innerHTML = `
                <input type="text" name="specifications[${index}][field_name]" placeholder="Field Name" required>
                <input type="text" name="specifications[${index}][field_value]" placeholder="Field Value" required>
                <button type="button" class="remove-specification btn btn-danger">Remove</button>
            `;
            container.appendChild(newField);

            // Attach event listener for "Remove" button
            newField.querySelector('.remove-specification').addEventListener('click', function() {
                newField.remove();
            });
        });

        // Initial "Remove" button functionality
        // document.querySelectorAll('.remove-specification-imd').forEach(button => {
        //     button.addEventListener('click', function() {
        //         button.parentElement.remove();
        //     });
        // });
    </script>
    <script>
       document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('specifications-container');

    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-specification')) {
            const row = e.target.closest('.specification-row');
            const specId = e.target.getAttribute('data-id');

            // Show a warning confirmation before deleting
            const confirmDelete = confirm("Are you sure you want to delete this specification?");
            if (!confirmDelete) return;

            if (specId) {
                // Send delete request to the server
                fetch('specification-handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ action: "delete", id: specId })
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            // Remove the row from the DOM
                            row.remove();

                            // Show success alert
                            alert("Specification deleted successfully!");
                        } else {
                            // Show error alert
                            alert('Failed to delete specification: ' + result.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the specification.');
                    });
            } else {
                // For rows not saved in DB, directly remove from the UI
                row.remove();
                alert("Specification removed successfully!");
            }
        }
    });
});

    </script>
    <script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(event) {
        var file = event.target.files[0];

        if (file) {
            // Check the file type (WEBP) and size (max 40KB)
            if (file.type === "image/webp" && file.size <= 40 * 1024) {
                // Show the preview container
                document.getElementById('image-preview-container').style.display = 'block';

                // Create a URL for the file and set it as the image preview source
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                // If the file is not WEBP or exceeds the size limit
                alert('Please select a valid WEBP image file under 40KB.');
                document.getElementById('image').value = ''; // Clear the file input
                document.getElementById('image-preview-container').style.display = 'none'; // Hide the preview
            }
        }
    });
</script>
<!-- <script src="../../plugins/jquery/jquery.min.js"></script> -->
    <!-- <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- <script src="../../dist/js/demo.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- Page specific script -->

</body>
</html>

