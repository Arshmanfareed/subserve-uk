<?php
// add_product.php

// Database connection settings
$host = "localhost"; // Your database host
$dbname = "subserve_co_uksubserve_beta"; // Your database name
$username = "root"; // Your database username
$password = ""; // Your database password

try {
    // Create a new PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        $purchase_price = $_POST['purchase_price'];
        $sale_price = $_POST['sale_price'];
        $discount_price = $_POST['discount_price'];
        $discount_percentage = $_POST['discount_percentage'];
        $current_price = $_POST['current_price'];
        $status = $_POST['status'];
        $state = $_POST['state'];
        $gtin = $_POST['gtin'];
        $google_categories = $_POST['google_categories'];
        $image_url = $_POST['image_url'];
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

        // Prepare the SQL query to insert data into the product table
        $sql = "INSERT INTO products (user_id, category_id, subcategory_id, brand_id, product_type_id, product_name, description, part_no, 
                purchase_price, sale_price, discount_price, discount_percentage, current_price, status, state, gtin, google_categories, image_url, 
                product_url, meta_keywords, meta_titles, meta_description, schema_markup, schema_markup2, schema_markup3, weight, slug, brand_name)
                VALUES (:user_id, :category_id, :subcategory_id, :brand_id, :product_type_id, :product_name, :description, :part_no, 
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

        // Execute the SQL query
        $stmt->execute();

        echo "New product added successfully!";
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
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Product</h2>
        <form action="" method="POST">

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
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <!-- Part No -->
            <div class="mb-3">
                <label for="part_no" class="form-label">Part No</label>
                <input type="text" class="form-control" id="part_no" name="part_no">
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
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url">
            </div>

            <!-- Product URL -->
            <div class="mb-3">
                <label for="product_url" class="form-label">Product URL</label>
                <input type="text" class="form-control" id="product_url" name="product_url">
            </div>

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
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug">
            </div>

            <!-- Brand Name -->
            <div class="mb-3">
                <label for="brand_name" class="form-label">Brand Name</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name">
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
