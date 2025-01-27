<?php
// Database connection
$servername = "localhost";
$username = "root"; // Update with your DB username
$password = ""; // Update with your DB password
$dbname = "subserve_co_uksubserve_beta"; // Update with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $parent_id = $_POST['parent_id'];
    $image = $_POST['image'];
    $status = $_POST['status'];
    $category_slug = $_POST['category_slug'];

    $insert_sql = "INSERT INTO categories (name, parent_id, image, status, category_slug) 
                   VALUES ('$name', '$parent_id', '$image', '$status', '$category_slug')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "New category added successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Add New Category</h2>

    <form id="addCategoryForm" method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Category ID</label>
            <input type="text" class="form-control" id="parent_id" name="parent_id">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image URL</label>
            <input type="text" class="form-control" id="image" name="image">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_slug" class="form-label">Category Slug</label>
            <input type="text" class="form-control" id="category_slug" name="category_slug">
        </div>

        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
