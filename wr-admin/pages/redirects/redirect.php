<?php
// Database connection settings
$host = 'localhost';
$db = 'subserve_co_uksubserve_beta';
$user = 'root';
$pass = '';

// Create a database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// // Handle redirection at the start of the script
// $requestUrl = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// $stmt = $conn->prepare("SELECT redirect_url, status_code FROM redirects WHERE error_url = :request_url");
// $stmt->bindParam(':request_url', $requestUrl);
// $stmt->execute();
// $redirect = $stmt->fetch(PDO::FETCH_ASSOC);

// if ($redirect) {
//     header("Location: " . $redirect['redirect_url'], true, $redirect['status_code']);
//     exit();
// }

$redirectSuccess = false; // Flag to show success message

// Handle form submission to add a redirect
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_redirect'])) {
    $errorUrl = trim($_POST['errorUrl']);
    $redirectUrl = trim($_POST['redirectUrl']);
    $statusCode = (int) $_POST['statusCode'];

    if ($errorUrl && $redirectUrl && $statusCode) {
        if (filter_var($errorUrl, FILTER_VALIDATE_URL) && filter_var($redirectUrl, FILTER_VALIDATE_URL)) {
            try {
                $stmt = $conn->prepare("INSERT INTO redirects (error_url, redirect_url, status_code) VALUES (:error_url, :redirect_url, :status_code)");
                $stmt->bindParam(':error_url', $errorUrl);
                $stmt->bindParam(':redirect_url', $redirectUrl);
                $stmt->bindParam(':status_code', $statusCode);
                if ($stmt->execute()) {
                    header("Location: " . $_SERVER['REQUEST_URI']);
                    exit();
                    $redirectSuccess = true;
                } else {
                    echo "Failed to add redirect.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid URL format. Please check the URLs.";
        }
    } else {
        echo "All fields are required.";
    }
}

// Handle AJAX deletion
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM redirects WHERE id = :id");
    $stmt->bindParam(':id', $deleteId);
    echo $stmt->execute() ? "Redirect deleted successfully!" : "Error deleting redirect.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Redirects</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/custom.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('../layout/sidebar.php'); ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <h2>Manage Redirects</h2>

                    <?php if ($redirectSuccess): ?>
                        <div class="alert alert-success">Redirect added successfully!</div>
                    <?php endif; ?>

                    <!-- Add Redirect Form -->
                    <form action="" method="post" class="mb-4">
                        <div class="form-group">
                            <label for="errorUrl">URL to Redirect:</label>
                            <input type="text" id="errorUrl" name="errorUrl" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="redirectUrl">Destination URL:</label>
                            <input type="text" id="redirectUrl" name="redirectUrl" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="statusCode">Redirect Type:</label>
                            <select id="statusCode" name="statusCode" class="form-control">
                                <option value="301">Permanent (301)</option>
                                <option value="307">Temporary (307)</option>
                                <option value="404">Not Found (404)</option>
                            </select>
                        </div>
                        <button type="submit" name="add_redirect" class="btn btn-primary">Save Redirect</button>
                    </form>

                    <!-- Display Redirects Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Error URL</th>
                                <th>Redirect URL</th>
                                <th>Status Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("SELECT * FROM redirects");
                            while ($redirect = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr id='row-{$redirect['id']}'>";
                                echo "<td>{$redirect['id']}</td>";
                                echo "<td>{$redirect['error_url']}</td>";
                                echo "<td>{$redirect['redirect_url']}</td>";
                                echo "<td>{$redirect['status_code']}</td>";
                                echo "<td><button class='btn btn-danger delete-btn' data-id='{$redirect['id']}'>Delete</button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>    
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle delete button click with AJAX
            $('.delete-btn').click(function() {
                const rowId = $(this).data('id');
                if (confirm("Are you sure you want to delete this redirect?")) {
                    $.post('', {
                        delete_id: rowId
                    }, function(response) {
                        alert(response);
                        $('#row-' + rowId).remove();
                    });
                }
            });
        });
    </script>
</body>

</html>