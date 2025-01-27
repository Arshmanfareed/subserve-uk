<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "subserve_co_uksubserve_beta";

// $servername = "localhost";
// $username = "subserve_co_uksubserve_beta";
// $password = 'Yahoo.com@123';
// $dbname = "subserve_co_uksubserve_beta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set
if (!isset($_GET['id'])) {
    header('Location: all-blogs.php'); // Redirect to blogs list if no ID is provided
    exit;
}

$id = $_GET['id'];

// Prepare and execute the delete statement
$stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->bind_param("i", $id); // Bind the ID parameter

if ($stmt->execute()) {
    // Deletion successful
    header('Location: all-blogs.php'); // Redirect to blogs list after deletion
    exit;
} else {
    echo "Error deleting blog: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
