<?php
session_start();
include("../src/connection.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];
    
    // Prepare delete query
    $deleteQuery = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        // Redirect back to products list page
        header("Location: all-products.php?message=deleted");
    } else {
        echo "Error deleting product: " . $conn->error;
    }
} else {
    header("Location: all-products.php?message=error");
}

$conn->close();
exit();
?>
