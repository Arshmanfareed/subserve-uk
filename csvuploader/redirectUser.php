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

// Capture and standardize the requested URL
$requestedUrl = 'http://localhost' . $_SERVER['REQUEST_URI'];  // Assuming http and localhost for testing

// Check if the requested URL has a redirection set in the database
$stmt = $conn->prepare("SELECT redirect_url FROM redirects WHERE error_url = :error_url");
$stmt->bindParam(':error_url', $requestedUrl);
$stmt->execute();

// Perform redirect if a match is found
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $redirectUrl = $row['redirect_url'];
    header("Location: $redirectUrl", true, 301);
    exit(); // Make sure to exit after header to stop script execution
}

// Handle form submission to add a redirect
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_redirect'])) {
    $errorUrl = trim($_POST['errorUrl']);
    $redirectUrl = trim($_POST['redirectUrl']);

    if (filter_var($errorUrl, FILTER_VALIDATE_URL) && filter_var($redirectUrl, FILTER_VALIDATE_URL)) {
        $stmt = $conn->prepare("INSERT INTO redirects (error_url, redirect_url) VALUES (:error_url, :redirect_url)");
        $stmt->bindParam(':error_url', $errorUrl);
        $stmt->bindParam(':redirect_url', $redirectUrl);
        $stmt->execute();
        echo "<p>Redirect from <strong>$errorUrl</strong> to <strong>$redirectUrl</strong> has been set.</p>";
    } else {
        echo "<p>Invalid URLs provided.</p>";
    }
}

// Display a 404 if no redirect is found
if (!isset($_POST['errorUrl']) && !isset($_POST['errorUrlDelete'])) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
    echo "<p>The page you are looking for does not exist.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirect Setup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="container my-4">
    <h1 class="mb-4">Setup Redirect for URLs</h1>
    
    <!-- Add Redirect Form -->
    <form action="" method="post" class="mb-4">
        <div class="mb-3">
            <label for="errorUrl" class="form-label">URL to Redirect:</label>
            <input type="text" id="errorUrl" name="errorUrl" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="redirectUrl" class="form-label">Destination URL:</label>
            <input type="text" id="redirectUrl" name="redirectUrl" class="form-control" required>
        </div>

        <button type="submit" name="add_redirect" class="btn btn-primary">Save Redirect</button>
    </form>

    <!-- Display Redirects Table -->
    <h2>Existing Redirects</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Error URL</th>
                <th>Redirect URL</th>
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
                echo "<td><button class='btn btn-danger delete-btn' data-id='{$redirect['id']}'>Delete</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- AJAX to handle deletion -->
    <script>
        $(document).ready(function(){
            $('.delete-btn').click(function(){
                const rowId = $(this).data('id');
                if (confirm("Are you sure you want to delete this redirect?")) {
                    $.post('', { delete_id: rowId }, function(response) {
                        alert(response);
                        $('#row-' + rowId).remove();
                    });
                }
            });
        });
    </script>
</body>
</html>
