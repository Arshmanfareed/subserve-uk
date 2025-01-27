<?php
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

// Handle AJAX request to update category data
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $name = $_POST['name'];
    $parent_id = $_POST['parent_id'];
    $image = $_POST['image'];
    $status = $_POST['status'];
    $category_slug = $_POST['category_slug'];

    $update_sql = "UPDATE categories SET 
                    name = '$name', 
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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit, .delete, .save {
            cursor: pointer;
            color: #007bff;
        }
        .delete {
            color: #dc3545;
        }
        .save {
            color: #28a745;
        }
        .editable {
            background-color: #f9f9f9;
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
<body>

<h2>Categories (Inline Editing with Pagination)</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
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
                echo "<td class='editable' data-field='name'>" . $row['name'] . "</td>";
                echo "<td class='editable' data-field='parent_id'>" . $row['parent_id'] . "</td>";
                echo "<td class='editable' data-field='image'>" . $row['image'] . "</td>";
                echo "<td class='editable' data-field='status'>" . $row['status'] . "</td>";
                echo "<td class='editable' data-field='category_slug'>" . $row['category_slug'] . "</td>";
                echo "<td>
                    <span class='edit'><i class='fas fa-pencil-alt'></i></span>
                    <span class='save' style='display:none'><i class='fas fa-save'></i></span>
                    <a href='?delete_id=" . $row['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this item?\");'><i class='fas fa-trash-alt'></i></a>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No categories found</td></tr>";
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

<script>
$(document).ready(function() {
    // Edit button click event
    $('.edit').on('click', function() {
        var row = $(this).closest('tr');
        row.find('.editable').each(function() {
            var text = $(this).text();
            var field = $(this).data('field');
            $(this).html('<input type="text" value="' + text + '" data-field="' + field + '" />');
        });
        row.find('.edit').hide();
        row.find('.save').show();
    });

    // Save button click event
    $('.save').on('click', function() {
        var row = $(this).closest('tr');
        var edit_id = row.data('id');
        var data = { edit_id: edit_id };

        row.find('input').each(function() {
            var field = $(this).data('field');
            var value = $(this).val();
            data[field] = value;
        });

        $.ajax({
            url: '', // same page
            method: 'POST',
            data: data,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    row.find('.editable').each(function() {
                        var field = $(this).data('field');
                        $(this).text(data[field]);
                    });
                    row.find('.save').hide();
                    row.find('.edit').show();
                } else {
                    alert(result.message);
                }
            }
        });
    });
});
</script>

</body>
</html>
