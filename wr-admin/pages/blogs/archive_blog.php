<?php
// Database connection settings
$host = "localhost";
$dbname = "subserve_co_uksubserve_beta";
$username = "root";
$password = "";

// $host = "localhost";
// $username = "subserve_co_uksubserve_beta";
// $password = 'Yahoo.com@123';
// $dbname = "subserve_co_uksubserve_beta";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if blog ID is passed
    if (isset($_GET['id'])) {
        $blogId = intval($_GET['id']);

        // Update query to set is_archive = 1
        $stmt = $pdo->prepare("UPDATE blogs SET is_archive = 1 WHERE id = ?");
        if ($stmt->execute([$blogId])) {
            header("Location: all-blogs.php?message=Blog archived successfully");
            exit;
        } else {
            echo "Error: Unable to archive the blog.";
        }
    } else {
        echo "Error: No blog ID provided.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}