<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "subserve_co_uksubserve_beta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add brand
if (isset($_POST['add_brand'])) {
    $name = $_POST['name'];
    $status = 1; // Default status
    
    $sql = "INSERT INTO brands (name, status, created_at) VALUES ('$name', '$status', NOW())";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>New brand added successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Update brand
if (isset($_POST['edit_brand'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    
    $sql = "UPDATE brands SET name='$name' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Brand updated successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }
}

// Pagination setup
$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Calculate offset

// Fetch and display brands with pagination
$sql = "SELECT * FROM brands LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Get total number of rows for pagination
$total_sql = "SELECT COUNT(*) FROM brands";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Brands</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/custom.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include('../../pages/layout/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">    
                    <h2>Add Brand</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Brand Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" name="add_brand" class="btn btn-primary">Add Brand</button>
    </form>
    
    <h2 class="mt-5">Brands List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Brand Name</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td contenteditable='true' data-id='" . $row["id"] . "' class='edit-name'>" . $row["name"] . "</td>
                            <td>" . $row["status"] . "</td>
                            <td>" . $row["created_at"] . "</td>
                            <td>
                                <form method='POST' action='' class='d-inline'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <input type='hidden' name='name' value='" . $row["name"] . "' class='hidden-name'>
                                    <button type='submit' name='edit_brand' class='btn btn-primary btn-sm'>Save</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No brands found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination Links -->
    <nav>
        <ul class="pagination">
            <?php
            if ($page > 1) {
                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "'>Previous</a></li>";
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = $i == $page ? "active" : "";
                echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
            }
            if ($page < $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "'>Next</a></li>";
            }
            ?>
        </ul>
    </nav>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Save updated name on edit
    $('.edit-name').on('blur', function() {
        let newValue = $(this).text();
        $(this).closest('tr').find('.hidden-name').val(newValue);
    });
});
</script>
<script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
</body>
</html>

<?php $conn->close(); ?>
