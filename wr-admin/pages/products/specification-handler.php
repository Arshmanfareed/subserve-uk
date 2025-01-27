<?php
header('Content-Type: application/json');
$host = "localhost";
$dbname = "subserve_co_uksubserve_beta";
$username = "root";
$password = "";
try {
    // Database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read input data
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data['action'] === 'delete') {
        // Delete a specification
        $stmt = $pdo->prepare("DELETE FROM product_specifications WHERE id = :id");
        $stmt->execute([':id' => $data['id']]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
