<?php
$host = 'localhost';
$dbname = 'subserve_co_uksubserve_beta';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $csvFile = $_FILES['csv_file']['tmp_name'];

        if (($handle = fopen($csvFile, 'r')) !== false) {
            fgetcsv($handle);
            $stmt = $pdo->prepare("
            INSERT INTO products (
                user_id, category_id, subcategory_id, brand_id, product_type_id, 
                product_name, description, part_no, purchase_price, 
                sale_price, discount_price, discount_percentage, current_price, 
                status, state, created_at, updated_at, gtin, google_categories, 
                image_url, product_url, meta_keywords, meta_titles, 
                meta_description, schema_markup, schema_markup2, schema_markup3,
                weight, slug, brand_name
            ) VALUES (
                :user_id, :category_id, :subcategory_id, :brand_id, :product_type_id, 
                :product_name, :description, :part_no, :purchase_price, 
                :sale_price, :discount_price, :discount_percentage, :current_price, 
                :status, :state, :created_at, :updated_at, :gtin, :google_categories, 
                :image_url, :product_url, :meta_keywords, :meta_titles, 
                :meta_description, :schema_markup, :schema_markup2, :schema_markup3,
                :weight, :slug, :brand_name
            )
        ");

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $stmt->bindParam(':user_id', $data[0]);
                $stmt->bindParam(':category_id', $data[1]);
                $stmt->bindParam(':subcategory_id', $data[2]);
                $stmt->bindParam(':brand_id', $data[3]);
                $stmt->bindParam(':product_type_id', $data[4]);
                $stmt->bindParam(':product_name', $data[5]);
                $stmt->bindParam(':description', $data[6]);
                $stmt->bindParam(':part_no', $data[7]);
                // Skipped :condition since it's not in use
                $stmt->bindParam(':purchase_price', $data[8]);
                $stmt->bindParam(':sale_price', $data[9]);
                $stmt->bindParam(':discount_price', $data[10]);
                $stmt->bindParam(':discount_percentage', $data[11]);
                $stmt->bindParam(':current_price', $data[12]);
                $stmt->bindParam(':status', $data[13]);
                $stmt->bindParam(':state', $data[14]);
                $stmt->bindParam(':created_at', $data[15]);
                $stmt->bindParam(':updated_at', $data[16]);
                $stmt->bindParam(':gtin', $data[17]);
                $stmt->bindParam(':google_categories', $data[18]);
                $stmt->bindParam(':image_url', $data[19]);
                $stmt->bindParam(':product_url', $data[20]);
                $stmt->bindParam(':meta_keywords', $data[21]);
                $stmt->bindParam(':meta_titles', $data[22]);
                $stmt->bindParam(':meta_description', $data[23]);
                $stmt->bindParam(':schema_markup', $data[24]);
                $stmt->bindParam(':schema_markup2', $data[25]);
                $stmt->bindParam(':schema_markup3', $data[26]);
                $stmt->bindParam(':weight', $data[27]);
                $stmt->bindParam(':slug', $data[28]);
                $stmt->bindParam(':brand_name', $data[29]);
                $stmt->execute();
            }
            fclose($handle);

            header("Location: addNew.php");
            exit();
        } else {
            echo "Failed to open the CSV file.";
        }
    } else {
        echo "Error uploading file.";
    }
}
