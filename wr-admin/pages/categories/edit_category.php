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

$success = false;
$category_id = $_GET['id'] ?? null;
$category = null;

if ($category_id) {
    // Fetch existing category data
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();
}

// Update category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $category_id) {
    $catname = $_POST['name'];
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
    // $category_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category_slug), '-'));

    // Ensure slug is unique
    // $slug_check_sql = "SELECT COUNT(*) AS slug_count FROM categories WHERE category_slug = '$category_slug'";
    // $slug_check_result = $conn->query($slug_check_sql);
    // if ($slug_check_result) {
    //     $row = $slug_check_result->fetch_assoc();
    //     if ($row['slug_count'] > 0) {
    //         // If slug exists, append a unique identifier
    //         $unique_id = time();
    //         $category_slug .= '-' . $unique_id;
    //     }
    // }

    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $tmp_name = $_FILES['image']['tmp_name'];
        $name = basename($_FILES['image']['name']);
        $image_url = $upload_dir . $name;

        if (!move_uploaded_file($tmp_name, $image_url)) {
            echo "Error uploading image.";
            exit;
        }
    } else {
        $image_url = $category['image']; // Retain the old image if no new upload
    }
    

    $update_sql = "UPDATE categories SET name=?, description=?, meta_keywords=?, meta_titles=?, meta_description=?, schema_markup=?, schema_markup2=?, schema_markup3=?, parent_id=?, image=?, status=?, category_slug=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssssssssi", $catname, $description, $meta_keywords, $meta_titles, $meta_description, $schema_markup, $schema_markup2, $schema_markup3, $parent_id, $image_url, $status, $category_slug, $category_id);

    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}

// echo 'asdasd';
// exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
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
                    <h2>Edit Category</h2>

                    <?php if ($category): ?>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($category['description']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="<?php echo htmlspecialchars($category['meta_keywords']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="meta_titles" class="form-label">Meta Titles</label>
                                <input type="text" class="form-control" id="meta_titles" name="meta_titles" value="<?php echo htmlspecialchars($category['meta_titles']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description"><?php echo htmlspecialchars($category['meta_description']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="schema_markup" class="form-label">Schema Markup</label>
                                <textarea class="form-control" id="schema_markup" name="schema_markup"><?php echo htmlspecialchars($category['schema_markup']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="schema_markup2" class="form-label">Schema Markup 2</label>
                                <textarea class="form-control" id="schema_markup2" name="schema_markup2"><?php echo htmlspecialchars($category['schema_markup2']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="schema_markup3" class="form-label">Schema Markup 3</label>
                                <textarea class="form-control" id="schema_markup3" name="schema_markup3"><?php echo htmlspecialchars($category['schema_markup3']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Category ID</label>
                                <input type="text" class="form-control" id="parent_id" name="parent_id" value="<?php echo htmlspecialchars($category['parent_id']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="image">Upload Image:</label>
                                <input type="file" class="form-control-file" id="image" name="image">
                                <small id="imageError" class="text-danger" style="display:none;">Image must be 800x600 pixels.</small>

                                <div id="image-preview-container" style="margin-top: 10px;">
                                <label for="preview" style="width: 100%;">Image Preview:</label>
                                <img id="image-preview" src="<?php echo $category['image']; ?>" alt="Image Preview" style="max-width: 100%; max-height: 300px; border: 1px solid #ddd;">
                            </div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="active" <?php echo $category['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo $category['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category_slug" class="form-label">Category Slug</label>
                                <input type="text" class="form-control" id="category_slug" name="category_slug" value="<?php echo htmlspecialchars($category['category_slug']); ?>" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </form>
                    <?php else: ?>
                        <p>Category not found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($success): ?>
        <script>
            alert("Category updated successfully!");
            window.location.href = "categories.php"; // Adjust this to redirect to the categories list
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script>
        tinymce.init({
            selector: '#description, #meta_description, #schema_markup, #schema_markup2, #schema_markup3',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });
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
