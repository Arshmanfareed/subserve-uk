<?php
// Include your database connection code here
include('connection.php');

// Sample backend query for searching products and categories
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = trim($_POST['search']);

    // Search in products table
    $productSql = "SELECT 
        p.product_name AS name, 
        p.slug AS slug, 
        p.image_url AS img, 
        c.name AS category_name, 
        c.category_slug AS category_slug, 
        'product' AS type
    FROM products p
    JOIN categories c ON p.category_id = c.id
    WHERE 
        p.product_name LIKE '%$searchTerm%' 
        OR p.part_no LIKE '%$searchTerm%' 
        OR c.name LIKE '%$searchTerm%'
    LIMIT 10";

    // Search in categories table
    $categorySql = "SELECT 
        c.name AS name, 
        c.category_slug AS slug, 
        c.image AS img,
        '' AS category_name,
        '' AS category_slug,
        'category' AS type
    FROM categories c
    WHERE 
        c.name LIKE '%$searchTerm%'
    LIMIT 10";

    // Combine the results from both queries
    $sql = "($productSql) UNION ($categorySql)";

    // Execute the combined query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Fetch results
        $results = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = [
                'name' => $row['name'],
                'slug' => $row['slug'],
                'img' => $row['img'],
                'type' => $row['type'],
                'category_name' => $row['category_name'],
                'category_slug' => $row['category_slug'],
            ];
        }

        // Return JSON-encoded results
        header('Content-Type: application/json');
        echo json_encode($results);
        exit();
    } else {
        // Handle the error if the query fails
        echo json_encode(['error' => mysqli_error($conn), 'sql' => $sql, 'params' => $searchTerm]);
        exit();
    }
}

// Close the database connection when done
mysqli_close($conn);
?>
