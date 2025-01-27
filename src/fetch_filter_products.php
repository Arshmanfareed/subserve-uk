<?php
// Assume you have a database connection named $conn
include "connection.php";
// Specify the category IDs
$categoryIds = [11, 12, 32, 44, 38, 80, 51, 58];

// Fetch categories based on specified IDs
$query = "SELECT id, name FROM categories WHERE id IN (" . implode(",", $categoryIds) . ")";
$result = mysqli_query($conn, $query);

// Check if there are categories
if (mysqli_num_rows($result) > 0) {
    $response = array(
        'categories' => array(),
        'products' => array()
    );

    // Fetch products for all categories (2 products each)
    $allProductsQuery = "SELECT p.id, p.product_name, p.description, p.sale_price, p.purchase_price, pi.image, b.name AS brand_name
                        FROM products p
                        JOIN product_images pi ON p.id = pi.product_id
                        JOIN brands b ON p.brand_id = b.id
                        WHERE p.category_id IN (" . implode(",", $categoryIds) . ") AND pi.status = 1
                        LIMIT 8";

    $allProductsResult = mysqli_query($conn, $allProductsQuery);

    $response['products']['all'] = array();
    while ($product = mysqli_fetch_assoc($allProductsResult)) {
        $response['products']['all'][] = $product;
    }

    // Fetch products for each category
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryId = $row['id'];

        $categoryProductsQuery = "SELECT p.* , pi.image, b.name AS brand_name
                                FROM products p
                                JOIN product_images pi ON p.id = pi.product_id
                                JOIN brands b ON p.brand_id = b.id
                                WHERE p.category_id = $categoryId AND pi.status = 1
                                LIMIT 2";

        $categoryProductsResult = mysqli_query($conn, $categoryProductsQuery);

        $response['categories'][] = array(
            'id' => $categoryId,
            'name' => $row['name']
        );

        $response['products'][$categoryId] = array();
        while ($product = mysqli_fetch_assoc($categoryProductsResult)) {
            $response['products'][$categoryId][] = $product;
        }

        mysqli_free_result($categoryProductsResult);
    }

    // Output the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Free the result set
    mysqli_free_result($allProductsResult);
    mysqli_free_result($result);
} else {
    echo 'No categories found.';
}

// Close the database connection
mysqli_close($conn);
?>
