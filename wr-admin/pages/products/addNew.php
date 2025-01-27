<?php
// Database configuration
$host = "localhost";
$dbname = "subserve_co_uksubserve_beta";
$username = "root";
$password = "";


// Function to create a slug from product name
function createSlug($string) {
    // Convert to lowercase
    $string = strtolower($string);
    // Replace spaces with hyphens
    $string = preg_replace('/\s+/', '-', $string);
    // Remove non-alphanumeric characters (excluding hyphens)
    $string = preg_replace('/[^a-z0-9\-]/', '', $string);
    // Trim any leading or trailing hyphens
    $string = trim($string, '-');
    
    return $string;
}

try {
    // Create a new PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $productAdded = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        
        // Retrieve form data
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
        
        $meta_keywords = $_POST['meta_keywords'];
        $meta_titles = $_POST['meta_titles'];
        $meta_description = $_POST['meta_description'];
        $schema_markup = $_POST['schema_markup'];
        $schema_markup2 = $_POST['schema_markup2'];
        $schema_markup3 = $_POST['schema_markup3'];
        $weight = $_POST['weight'];
        $slug = createSlug($_POST['product_name']);
        $brand_name = $_POST['brand_name'];
        
        $image_url = '';

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $upload_dir = '../../../assets/images/';                        
            $unique_name = time() . '_' . rand(1000, 9999) . '_' . basename($image_name);
            $image_url = $upload_dir . $unique_name;        
            if (!move_uploaded_file($image_tmp_name, $image_url)) {
                echo "Failed to upload image.";
            }    
            $image_url = 'http://' . $_SERVER['HTTP_HOST'] . '/subserve/assets/images/' . $unique_name;
        }

        $product_url_create = 'http://' . $_SERVER['HTTP_HOST'] . '/subserve/product/' . $slug;
        $product_url = $product_url_create;

        // Prepare the SQL query to insert data into the product table
        $sql = "INSERT INTO products (user_id, category_id, subcategory_id, brand_id, product_type_id, product_name, description, part_no, `condition`,
                purchase_price, sale_price, discount_price, discount_percentage, current_price, status, state, gtin, google_categories, image_url, 
                product_url, meta_keywords, meta_titles, meta_description, schema_markup, schema_markup2, schema_markup3, weight, slug, brand_name)
                VALUES (:user_id, :category_id, :subcategory_id, :brand_id, :product_type_id, :product_name, :description, :part_no, :condition, 
                :purchase_price, :sale_price, :discount_price, :discount_percentage, :current_price, :status, :state, :gtin, :google_categories, 
                :image_url, :product_url, :meta_keywords, :meta_titles, :meta_description, :schema_markup, :schema_markup2, :schema_markup3, 
                :weight, :slug, :brand_name)";

        $stmt = $pdo->prepare($sql);

        // Bind the form values to the SQL query
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':subcategory_id', $subcategory_id);
        $stmt->bindParam(':brand_id', $brand_id);
        $stmt->bindParam(':product_type_id', $product_type_id);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':part_no', $part_no);
        $stmt->bindParam(':condition', $condition);
        $stmt->bindParam(':purchase_price', $purchase_price);
        $stmt->bindParam(':sale_price', $sale_price);
        $stmt->bindParam(':discount_price', $discount_price);
        $stmt->bindParam(':discount_percentage', $discount_percentage);
        $stmt->bindParam(':current_price', $current_price);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':gtin', $gtin);
        $stmt->bindParam(':google_categories', $google_categories);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':product_url', $product_url);
        $stmt->bindParam(':meta_keywords', $meta_keywords);
        $stmt->bindParam(':meta_titles', $meta_titles);
        $stmt->bindParam(':meta_description', $meta_description);
        $stmt->bindParam(':schema_markup', $schema_markup);
        $stmt->bindParam(':schema_markup2', $schema_markup2);
        $stmt->bindParam(':schema_markup3', $schema_markup3);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':brand_name', $brand_name);

        // Execute the SQL query and set the productAdded flag if successful
        if ($stmt->execute()) {
            $productAdded = true;
            $product_id = $pdo->lastInsertId();
            
        }
        
        // Handle image upload
        if (!empty($_FILES['image'])) {
           
            $alt_text = isset($_POST['product_name']) ? $_POST['product_name'] : ''; // Default empty if no alt text
            $sptmt = $pdo->prepare("INSERT INTO product_images (product_id, image, alt) VALUES (:product_id, :image, :alt)");
            $sptmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $sptmt->bindParam(':image', $unique_name, PDO::PARAM_STR);
            $sptmt->bindParam(':alt', $alt_text, PDO::PARAM_STR);
        }
        $sptmt->execute();
       
        // Insert specifications into `product_specifications` table
        if (!empty($_POST['specifications'])) {
            $specStmt = $pdo->prepare("INSERT INTO product_specifications (category_id, product_id, field_name, field_value) VALUES (:category_id, :product_id, :field_name, :field_value)");
            foreach ($_POST['specifications'] as $spec) {
                $specStmt->execute([
                    ':category_id' => $category_id, // Assuming it's captured earlier
                    ':product_id' => $product_id,
                    ':field_name' => $spec['field_name'],
                    ':field_value' => $spec['field_value']
                ]);
            }
        }

        header('Location: addNew.php'); // Redirect to blogs list after update
            exit;
       
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/custom.css">
    <script src="https://cdn.tiny.cloud/1/9dyl4rpzecdyiji86ueiqbi2p9vz07o4f36hdb968lpe1bj5/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <button style="justify-content: right; margin-top: 20px; margin-bottom: 20px" type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                        Upload CSV
                    </button>

                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadModalLabel">Upload CSV</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="csvUpload.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="csv_file">Choose CSV file:</label>
                                            <input type="file" name="csv_file" id="csv_file" accept=".csv" required class="form-control">
                                        </div>
                                        <br>
                                        <input type="submit" value="Upload" class="btn btn-success">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2>Add New Product</h2>
                    <form id="product-form" action="" method="POST" enctype="multipart/form-data">

                        <!-- User ID -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required>
                        </div>

                        <!-- Category ID -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category ID</label>
                            <input type="text" class="form-control" id="category_id" name="category_id" required>
                        </div>

                        <!-- Subcategory ID -->
                        <div class="mb-3">
                            <label for="subcategory_id" class="form-label">Subcategory ID</label>
                            <input type="text" class="form-control" id="subcategory_id" name="subcategory_id" required>
                        </div>

                        <!-- Brand ID -->
                        <div class="mb-3">
                            <label for="brand_id" class="form-label">Brand ID</label>
                            <input type="text" class="form-control" id="brand_id" name="brand_id" required>
                        </div>

                        <!-- Product Type ID -->
                        <div class="mb-3">
                            <label for="product_type_id" class="form-label">Product Type ID</label>
                            <input type="text" class="form-control" id="product_type_id" name="product_type_id" required>
                        </div>

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" minlength="30" maxlength="70" required>
                            <small class="form-text text-muted">Product name must be between 30 and 70 characters.</small>
                        </div>

                        <!-- Description -->

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <div id="specifications-container">
                                <label>Product Specifications</label>
                                <div class="specification-row">
                                    <input type="text" name="specifications[0][field_name]" placeholder="Field Name" required>
                                    <input type="text" name="specifications[0][field_value]" placeholder="Field Value" required>
                                    <button type="button" class="remove-specification btn btn-danger">Remove</button>
                                </div>
                            </div>
                            <button type="button" id="add-specification" class="btn btn-success">Add More</button>
                        </div>
                        <!-- Part No -->
                        <div class="mb-3">
                            <label for="part_no" class="form-label">Part No</label>
                            <input type="text" class="form-control" id="part_no" name="part_no">
                        </div>

                        <!-- Condition -->
                        <div class="mb-3">
                            <label for="condition" class="form-label">Condition</label>
                            <select class="form-control"  id="condition" name="condition">
                                <option value="New">New</option>
                                <option value="New Open Box">New Open Box</option>
                                <option value="Used">Used</option>
                                <option value="Refurbished">Refurbished</option>
                            </select>
                        </div>

                        <!-- Purchase Price -->
                        <div class="mb-3">
                            <label for="purchase_price" class="form-label">Purchase Price</label>
                            <input type="number" step="0.01" class="form-control" id="purchase_price" name="purchase_price" required>
                        </div>

                        <!-- Sale Price -->
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" required>
                        </div>

                        <!-- Discount Price -->
                        <div class="mb-3">
                            <label for="discount_price" class="form-label">Discount Price</label>
                            <input type="number" step="0.01" class="form-control" id="discount_price" name="discount_price">
                        </div>

                        <!-- Discount Percentage -->
                        <div class="mb-3">
                            <label for="discount_percentage" class="form-label">Discount Percentage</label>
                            <input type="number" step="0.01" class="form-control" id="discount_percentage" name="discount_percentage">
                        </div>

                        <!-- Current Price -->
                        <div class="mb-3">
                            <label for="current_price" class="form-label">Current Price</label>
                            <input type="number" step="0.01" class="form-control" id="current_price" name="current_price" required>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- State -->
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>

                        <!-- GTIN -->
                        <div class="mb-3">
                            <label for="gtin" class="form-label">GTIN</label>
                            <input type="text" class="form-control" id="gtin" name="gtin">
                        </div>

                        <!-- Google Categories -->
                        <div class="mb-3">
                            <label for="google_categories" class="form-label">Google Categories</label>
                            <input type="text" class="form-control" id="google_categories" name="google_categories">
                        </div>

                        <!-- Image URL -->
                        <!-- <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="image_url" name="image_url">
                        </div> -->

                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image (WEBP, Max 40KB)</label>
                            <input type="file" class="form-control" id="image" name="image" accept=".webp" required>
                            <small class="form-text text-muted">Only WEBP images are allowed, and the size must not exceed 40 KB.</small>
                        </div>

                        <!-- Product URL -->
                        <!-- <div class="mb-3">
                            <label for="product_url" class="form-label">Product URL</label>
                            <input type="text" class="form-control" id="product_url" name="product_url">
                        </div> -->

                        <!-- Meta Keywords -->
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="2"></textarea>
                        </div>

                        <!-- Meta Titles -->
                        <div class="mb-3">
                            <label for="meta_titles" class="form-label">Meta Titles</label>
                            <input type="text" class="form-control" id="meta_titles" name="meta_titles">
                        </div>

                        <!-- Meta Description -->
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="2"></textarea>
                        </div>

                        <!-- Schema Markup -->
                        <div class="mb-3">
                            <label for="schema_markup" class="form-label">Schema Markup</label>
                            <textarea class="form-control" id="schema_markup" name="schema_markup" rows="2"></textarea>
                        </div>

                        <!-- Schema Markup 2 -->
                        <div class="mb-3">
                            <label for="schema_markup2" class="form-label">Schema Markup 2</label>
                            <textarea class="form-control" id="schema_markup2" name="schema_markup2" rows="2"></textarea>
                        </div>

                        <!-- Schema Markup 3 -->
                        <div class="mb-3">
                            <label for="schema_markup3" class="form-label">Schema Markup 3</label>
                            <textarea class="form-control" id="schema_markup3" name="schema_markup3" rows="2"></textarea>
                        </div>

                        <!-- Weight -->
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight">
                        </div>

                        <!-- Slug -->
                        <!-- <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug">
                        </div> -->

                        <!-- Brand Name -->
                        <div class="mb-3">
                            <label for="brand_name" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" id="brand_name" name="brand_name">
                        </div>

                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Product Added</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 3em;"></i>
                    <p>New product added successfully!</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="#">Subserve UK</a>.</strong> All rights reserved.
    </footer>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });
    </script>
    <script>
        // Show modal if product was added
        <?php if ($productAdded): ?>
            $(document).ready(function() {
                $('#successModal').modal('show');
            });
        <?php endif; ?>
    </script>

    <script>

        // Add validation logic
        document.getElementById('product-form').addEventListener('submit', function(event) {
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
            if (file) {
                const maxFileSize = 40 * 1024; // 40 KB
                const allowedType = "image/webp";

                if (file.size > maxFileSize) {
                    alert("Image size must not exceed 40 KB.");
                    event.preventDefault();
                    return;
                }

                if (file.type !== allowedType) {
                    alert("Only WEBP images are allowed.");
                    event.preventDefault();
                    return;
                }
            } else {
                alert("Please upload a valid image.");
                event.preventDefault();
            }
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
        document.querySelectorAll('.remove-specification').forEach(button => {
            button.addEventListener('click', function() {
                button.parentElement.remove();
            });
        });
    </script>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>