<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $totalLimit = 15;

    $categoriesQuery = "SELECT c.id AS category_id, c.category_slug, c.name AS category_name, p.*, pi.image, b.name AS brand_name
        FROM categories c
        JOIN products p ON c.id = p.category_id
        JOIN product_images pi ON p.id = pi.product_id
        JOIN brands b ON p.brand_id = b.id
        WHERE pi.status = 1
        LIMIT 12";

    $result = mysqli_query($conn, $categoriesQuery);
    $response = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = [
            'category' => $row['category_name'],
            'product' => [
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'category_id' => $row['category_id'],
                'category_slug' => $row['category_slug'],
                'subcategory_id' => $row['subcategory_id'],
                'brand_id' => $row['brand_id'],
                'product_type_id' => $row['product_type_id'],
                'product_name' => $row['product_name'],
                'description' => $row['description'],
                'part_no' => $row['part_no'],
                'condition' => $row['condition'],
                'purchase_price' => $row['purchase_price'],
                'sale_price' => $row['sale_price'],
                'discount_price' => $row['discount_price'],
                'discount_percentage' => $row['discount_percentage'],
                'current_price' => $row['current_price'],
                'status' => $row['status'],
                'state' => $row['state'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
                'gtin' => $row['gtin'],
                'google_categories' => $row['google_categories'],
                'image_url' => $row['image_url'],
                'product_url' => $row['product_url'],
                'meta_keywords' => $row['meta_keywords'],
                'meta_titles' => $row['meta_titles'],
                'meta_description' => $row['meta_description'],
                'weight' => $row['weight'],
                'slug' => $row['slug'],
                'brand_name' => $row['brand_name'],
                'image' => $row['image'],
            ]
        ];
    }

    mysqli_free_result($result);

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

