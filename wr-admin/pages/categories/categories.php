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
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "subserve_co_uksubserve_beta"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete functionality
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Sanitize input

    // Prepare the DELETE query
    $delete_sql = "DELETE FROM categories WHERE id = $delete_id";

    // Execute the query
    if ($conn->query($delete_sql) === TRUE) {
        // echo "<script>alert('Category deleted successfully');</script>";
        // echo "<script>window.location.href = 'your_current_page.php';</script>"; // Redirect to avoid resubmission
    } else {
        echo "<script>alert('Error deleting category: " . $conn->error . "');</script>";
    }
}

// Handle AJAX request to update category data
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $parent_id = $_POST['parent_id'];
    $image = $_POST['image'];
    $status = $_POST['status'];
    $category_slug = $_POST['category_slug'];

    $update_sql = "UPDATE categories SET 
                    name = '$name', 
                    description = '$description',
                    parent_id = '$parent_id', 
                    image = '$image', 
                    status = '$status', 
                    category_slug = '$category_slug' 
                    WHERE id = $edit_id";
    if ($conn->query($update_sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Record updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating record: ' . $conn->error]);
    }
    exit;
}

// Pagination logic
$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch categories data for table display with pagination
$total_result = $conn->query("SELECT COUNT(*) AS total FROM categories");
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Fetch current page data
$sql = "SELECT * FROM categories LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Table with Inline Editing and Pagination</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/custom.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .edit,
        .delete {
            cursor: pointer;
            color: #007bff;
        }

        .delete {
            color: #dc3545;
        }

        .pagination {
            margin: 20px 0;
            text-align: center;
        }

        .pagination a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('../../pages/layout/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">

                    <h2>Categories (Inline Editing with Pagination)</h2>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Parent ID</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Category Slug</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr data-id='" . $row['id'] . "'>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['description'] . "</td>";
                                    echo "<td>" . $row['parent_id'] . "</td>";
                                    echo "<td>" . $row['image'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "<td>" . $row['category_slug'] . "</td>";
                                    echo "<td>
                                        <a href='edit_category.php?id=" . $row['id'] . "' class='edit'><i class='fas fa-pencil-alt'></i> Edit</a>
                                        <a href='?delete_id=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this item?\");'><i class='fas fa-trash-alt'></i> Delete</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>No categories found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="pagination">
                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active_class = ($i == $page) ? 'active' : '';
                            echo "<a class='$active_class' href='?page=$i'>$i</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // You can still handle editing and saving in a different way if needed
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
</body>

</html>
