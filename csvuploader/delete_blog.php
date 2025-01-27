<?php
// delete_blog.php

// Check if ID parameter is set and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $blog_id = $_GET['id'];

    // Database connection settings
    $host = "localhost"; // Your database host
    $dbname = "subserve_co_uksubserve_beta"; // Your database name
    $username = "root"; // Your database username
    $password = ""; // Your database password

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to delete blog
        $sql = "DELETE FROM blogs WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $blog_id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect back to admin blogs page after deletion
            header("Location: admin_blog.php");
            exit();
        } else {
            echo "Error deleting blog.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid blog ID.";
}
?>
