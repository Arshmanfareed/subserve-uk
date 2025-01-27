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


$current_qty = 72; // Default quantity if no record is found
try {
    $stmt = $conn->query("SELECT product_qty_in_page FROM setting LIMIT 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $current_qty = $result['product_qty_in_page'];
    }
} catch (PDOException $e) {
    echo "Error fetching current setting: " . $e->getMessage();
}

// Handle form submission to add a redirect
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_per_page = $_POST['product_per_page'];

    if ($product_per_page) {
        try {
            // Check if a record exists
            $stmt = $conn->query("SELECT COUNT(*) FROM setting");
            $exists = $stmt->fetchColumn();

            if ($exists > 0) {
                // Update existing setting
                $stmt = $conn->prepare("UPDATE setting SET product_qty_in_page = :product_per_page");
            } else {
                // Insert new setting
                $stmt = $conn->prepare("INSERT INTO setting (product_qty_in_page) VALUES (:product_per_page)");
            }

            $stmt->bindParam(':product_per_page', $product_per_page);

            if ($stmt->execute()) {
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                echo "Failed to save settings.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Please select a product quantity.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Settings</title>
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
                    <h2>Manage Settings</h2>

                    <?php if ($redirectSuccess): ?>
                        <div class="alert alert-success">Settings added successfully!</div>
                    <?php endif; ?>

                    <!-- Add Redirect Form -->
                    <form action="" method="post" class="mb-4">                        
                    <div class="form-group">
                        <label for="statusCode">Product Quantity Per Page:</label>
                        <div class="productselect">
                            <input type="text" name="product_per_page" value="<?php echo $current_qty; ?>">
                        <!-- <select id="product_per_page" name="product_per_page">
                            <option value="36" <?= $current_qty == 36 ? 'selected' : '' ?>>36 Products</option>
                            <option value="72" <?= $current_qty == 72 ? 'selected' : '' ?>>72 Products</option>
                            <option value="144" <?= $current_qty == 144 ? 'selected' : '' ?>>144 Products</option>
                        </select> -->
                        </div>
                    </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                    
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