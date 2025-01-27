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

$success = false; // Flag to check if category was added successfully

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $name = $_POST['name'];
//     $description = $_POST['description'];
//     $meta_keywords = $_POST['meta_keywords'];
//     $meta_titles = $_POST['meta_titles'];
//     $meta_description = $_POST['meta_description'];
//     $schema_markup = $_POST['schema_markup'];
//     $schema_markup2 = $_POST['schema_markup2'];
//     $schema_markup3 = $_POST['schema_markup3'];
//     $parent_id = $_POST['parent_id'];
//     $image = $_POST['image'];
//     $status = $_POST['status'];
//     $category_slug = $_POST['category_slug'];

//     $insert_sql = "INSERT INTO categories (name, description, meta_keywords, meta_titles, meta_description, schema_markup, schema_markup2, schema_markup3, parent_id, image, status, category_slug) 
//                    VALUES ('$name', '$description', '$meta_keywords', '$meta_titles', '$meta_description', '$schema_markup', '$schema_markup2', '$schema_markup3', '$parent_id', '$image', '$status', '$category_slug')";

//     if ($conn->query($insert_sql) === TRUE) {
//         $success = true; // Set success flag to true if insert was successful
//     } else {
//         echo "Error: " . $conn->error;
//     }

//     $conn->close();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $meta_keywords = $_POST['meta_keywords'];
    $meta_titles = $_POST['meta_titles'];
    $meta_description = $_POST['meta_description'];
    $schema_markup = $_POST['schema_markup'];
    $schema_markup2 = $_POST['schema_markup2'];
    $schema_markup3 = $_POST['schema_markup3'];
    $parent_id = $_POST['parent_id'];
    $status = $_POST['status'];
    $category_slug = $_POST['category_slug'];

    // Generate slug from name
    $category_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category_slug), '-'));

    // Ensure slug is unique
    $slug_check_sql = "SELECT COUNT(*) AS slug_count FROM categories WHERE category_slug = '$category_slug'";
    $slug_check_result = $conn->query($slug_check_sql);
    if ($slug_check_result) {
        $row = $slug_check_result->fetch_assoc();
        if ($row['slug_count'] > 0) {
            // If slug exists, append a unique identifier
            $unique_id = time();
            $category_slug .= '-' . $unique_id;
        }
    }

    $image_url = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = 'uploads/';
        $image_url = $upload_dir . basename($image_name);

        // Move the uploaded image to the destination folder
        if (!move_uploaded_file($image_tmp_name, $image_url)) {
            echo "Failed to upload image.";
        }
    }

    $insert_sql = "INSERT INTO categories (name, description, meta_keywords, meta_titles, meta_description, schema_markup, schema_markup2, schema_markup3, parent_id, image, status, category_slug) 
                   VALUES ('$name', '$description', '$meta_keywords', '$meta_titles', '$meta_description', '$schema_markup', '$schema_markup2', '$schema_markup3', '$parent_id', '$image_url', '$status', '$category_slug')";

    if ($conn->query($insert_sql) === TRUE) {
        $success = true; // Set success flag to true if insert was successful
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}

?>
<style>
     small#imageError {
            font-size: 14px;
            font-weight: 500;
            margin-top: 10px;
        }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- TinyMCE -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/custom.css">
    <script src="https://cdn.tiny.cloud/1/9dyl4rpzecdyiji86ueiqbi2p9vz07o4f36hdb968lpe1bj5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
    <?php include('../../pages/layout/sidebar.php'); ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h2>Add New Category</h2>

                    <form id="addCategoryForm" method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords">
                        </div>
                        <div class="mb-3">
                            <label for="meta_titles" class="form-label">Meta Titles</label>
                            <input type="text" class="form-control" id="meta_titles" name="meta_titles">
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="schema_markup" class="form-label">Schema Markup</label>
                            <textarea class="form-control" id="schema_markup" name="schema_markup"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="schema_markup2" class="form-label">Schema Markup 2</label>
                            <textarea class="form-control" id="schema_markup2" name="schema_markup2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="schema_markup3" class="form-label">Schema Markup 3</label>
                            <textarea class="form-control" id="schema_markup3" name="schema_markup3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category ID</label>
                            <input type="text" class="form-control" id="parent_id" name="parent_id">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image URL</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <small id="imageError" class="text-danger" style="display:none;">Image must be 800x600 pixels.</small>

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
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Category Added</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 3em;"></i>
                    <p>New category added successfully!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>    <script>
        tinymce.init({
            selector: '#description, #meta_description, #schema_markup, #schema_markup2, #schema_markup3',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });
    </script>

    <script>
        // Show success modal if category added successfully
        <?php if ($success): ?>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        <?php endif; ?>
    </script>
       <script>
        document.getElementById('image').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const img = new Image();
            const minWidth = 800; // Minimum width
            const minHeight = 600; // Minimum height

            img.onload = function () {
                if (this.width < minWidth || this.height < minHeight) {
                    document.getElementById('imageError').style.display = 'block';
                    event.target.value = ''; // Clear the input field
                } else {
                    document.getElementById('imageError').style.display = 'none';
                }
            };

            img.src = URL.createObjectURL(file);
        });
    </script>
</body>

</html>
