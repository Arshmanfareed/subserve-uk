<?php

include 'src/connection.php';


if (headers_sent()) {
    echo "Headers already sent. Cannot perform redirection.";
    exit;
}

// Use mysqli_real_escape_string to prevent SQL injection
$product_slug = $conn->real_escape_string('3704327-Sun-20-GB-35-Internal-Hard-Drive1-PackIDE7200-rpm');

$current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Sanitize the current URL
$current_url_safe = $conn->real_escape_string($current_url);

// echo $current_url_safe;

// Query the `redirects` table for a matching `error_url` and its status code
$query = "SELECT redirect_url, status_code FROM redirects WHERE error_url = '$current_url_safe'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {

    
    // Fetch the redirect URL and status code
    $row = $result->fetch_assoc();
    $redirect_url = $row['redirect_url'];
    $status_code = $row['status_code'];
    

    // Validate and set the HTTP status code (default to 301 if invalid or not set)
    $valid_status_codes = [301, 307, 404];
    if (!in_array($status_code, $valid_status_codes)) {
        $status_code = 301;
    }
    // echo 'asdasdsad';
    // echo $status_code;
    // exit;
    // Perform the redirection or handle the status
    if ($status_code == 404) {
        header("HTTP/1.1 404 Not Found");
        // header("Location: $redirect_url");
       
        
    } else {
        header("HTTP/1.1 $status_code Moved " . ($status_code == 301 ? "Permanently" : "Temporarily"));
        header("Location: $redirect_url");
        
        // exit;
    }
       
    
}

include 'layouts/header.php';

// Execute this query before your main query to increase the limit for the current session
$conn->query("SET SQL_BIG_SELECTS=1");

// SQL query to fetch product details based on the slug with JOIN operations
$get_product_query = "SELECT DISTINCT
p.*,
c.name AS category_name,
c.category_slug AS category_slug,
s.name AS subcategory_name,
s.category_slug AS subcategory_slug,
b.name AS brand_name,
i.image,
i.Alt
FROM
products p
LEFT JOIN
categories c ON p.category_id = c.id
LEFT JOIN
categories s ON p.subcategory_id = s.id
LEFT JOIN
brands b ON p.brand_id = b.id
LEFT JOIN
product_images i ON p.id = i.product_id
WHERE
p.slug = '".$product_slug."'";

$get_product_result = $conn->query($get_product_query);


// exit();

// Check for errors in the query execution
if (!$get_product_result) {
    echo "Error executing query: " . $conn->error;
    exit();
} else {
    // Check if a product is found
    if ($get_product_result->num_rows > 0) {
        $product_details = $get_product_result->fetch_assoc();
       
        $is_archive = $product_details['is_archive'];
        if ($is_archive != 0) {
            // Use JavaScript for redirection
            echo '<script type="text/javascript">';
            echo 'window.location.href = "http://localhost/subserve/404.php";';
            echo '</script>';
            exit();
        }        
           // Get the category and subcategory IDs
           $category_id = $product_details['category_id'];
           $subcategory_id = $product_details['subcategory_id'];
           $slug_Category_Final = $product_details['category_slug'];
           $slug_Sub_Category_final = $product_details['subcategory_slug'];
        // Retrieve other necessary information (e.g., brand, images)

        // Display the dynamic content based on product details
        ?>

        <div class="container col-sm-mt70 col-md-mt100 page-product">
            <div class="empty-space col-xs-b15 col-sm-b30"></div>
            <div class="breadcrumbs">
                <a href="">home</a>
                <a href="">Shop</a>
                <?php if (!empty($product_details['category_name'])): ?>
                    <a href="category/<?php echo $slug_Category_Final ?>">
                        <?php echo $product_details['category_name']; ?>
                    </a>
                <?php endif; ?>

                <?php if (!empty($product_details['subcategory_name'])): ?>
                    <a href="category/<?php echo $slug_Sub_Category_final ?>">
                        <?php echo $product_details['subcategory_name']; ?>
                    </a>
                <?php endif; ?>

                <?php if (!empty($product_details['product_name'])): ?>
                    <a href="product/<?php echo $product_details['slug'] ?>">
                        <?php echo $product_details['product_name']; ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="empty-space col-xs-b15 col-sm-b30 col-md-b50"></div>
            <div class="row">
                <div class="col-md-12 ">
                    <form id="addToCart">
                        <div class="row">
                            <div class="col-sm-4 col-xs-b30 col-sm-b0">
                                <div class="main-product-image-wrapper">
                                    <!-- Display product images -->
                                    <?php if (!empty($product_details['image'])): ?>
                                        <img id="pro-img" src="assets/images/<?php echo $product_details['image']; ?>"
                                            alt="<?php echo $product_details['Alt']; ?>" />
                                    <?php endif; ?>
                                </div>

                            </div>
                            <div class="col-sm-8">
                                <div class="simple-article size-3 grey col-xs-b5 single-product-categories">
                                    <?php if (!empty($product_details['category_name'])): ?>
                                        <a href="#">
                                            <?php echo $product_details['category_name']; ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($product_details['subcategory_name'])): ?>
                                        <a href="#">
                                            <?php echo $product_details['subcategory_name']; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="h3 col-xs-b25">
                                    <span id="cartProductName">
                                        <h1 class="h3"><?php echo $product_details['product_name']; ?></h1>
                                    </span>
                                </div>
                                <div class="row col-xs-b25">
                                    <div class="col-sm-2">
                                        <div class="simple-article size-5 grey">PRICE: </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="simple-article size-5 grey">
                                            <!-- <span class="color d-block mb-0">$<span id="price_ex">
                                                    <?php //echo $product_details['sale_price']; ?> </span>(Exc. Vat)
                                            </span> -->
                                            <span class="color d-block">£<span id="price_in">
                                                    <?php 
                                                        $produt_price = $product_details['current_price'] * 0.8;
                                                        echo number_format($produt_price, 2); 
                                                    ?> </span>
                                                </span>
                                        </div>
                                    </div>
                                    <!--<div class="col-sm-5 col-sm-text-right">-->
                                    <!--    <div class="rate-wrapper align-inline">-->
                                    <!--        <i class="fa fa-star" aria-hidden="true"></i>-->
                                    <!--        <i class="fa fa-star" aria-hidden="true"></i>-->
                                    <!--        <i class="fa fa-star" aria-hidden="true"></i>-->
                                    <!--        <i class="fa fa-star" aria-hidden="true"></i>-->
                                    <!--        <i class="fa fa-star-o" aria-hidden="true"></i>-->
                                    <!--    </div>-->
                                    <!--    <div class="simple-article size-2 align-inline">128 Reviews</div>-->
                                    <!--</div>-->
                                </div>
                                <div class="row col-xs-b10">
                                    <div class="col-sm-6">
                                    <?php

                                    // Database configuration
                                    $host = "localhost";
                                    $dbname = "subserve_co_uksubserve_beta";
                                    $username = "root";
                                    $password = "";

                                    // Assuming `$product_details['id']` contains the product ID
                                    $product_id = $product_details['id'];

                                    // Query to fetch specifications
                                    $get_product_specifications = "SELECT * FROM `product_specifications` WHERE product_id = $product_id";
                                    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $result = $pdo->query($get_product_specifications);

                                    if ($result->rowCount() > 0) {
                                        while ($spec = $result->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<div class="simple-article size-3 col-xs-b5">';
                                            echo htmlspecialchars($spec['field_name']) . ': <span class="grey">' . htmlspecialchars($spec['field_value']) . '</span>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo '<p class="simple-article size-3 col-xs-b5">No specifications found for this product.</p>';
                                    }
                                       
                                    ?>
                                        <div class="simple-article size-3 col-xs-b5">Brand: <span class="grey">
                                                <?php echo $product_details['brand_name']; ?>
                                            </span>
                                        </div>
                                        <div class="simple-article size-3 col-xs-b5">Part No: <span class="grey">
                                                <?php echo $product_details['part_no']; ?>
                                            </span>
                                        </div>
                                        <div class="simple-article size-3 col-xs-b5">Availability: <span class="grey"> IN
                                                STOCK</span>
                                        </div>
                                        <div class="simple-article size-3 col-xs-b5">Condition: <span class="grey">
                                                <?php echo $product_details['condition']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="simple-article size-3 col-xs-b30">Vivamus in tempor eros. Phasellus rhoncus in nunc sit amet mattis. Integer in ipsum vestibulum, molestie arcu ac, efficitur tellus. Phasellus id vulputate erat.</div> -->

                                <div class="row col-xs-b40">
                                    <div class="col-sm-3">
                                        <div class="h6 detail-data-title size-1">quantity:</div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="quantity-select">
                                            <span class="minus"></span>
                                            <span class="number" id="qty-product">1</span>
                                            <span class="plus"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m5 col-xs-b40">
                                    <div class="col-sm-6 col-xs-b10 col-sm-b0">
                                        <a class="button size-2 style-2 block" id="product-cart">
                                            <span class="button-wrapper">
                                                <span class="icon"><img src="assets/img/extra-img/icon-2.png" alt=""></span>
                                                <span class="text">add to cart</span>
                                            </span>
                                        </a>
                                    </div>
                                    <!-- <div class="col-sm-6">
                                        <a class="button size-2 style-1 block noshadow" href="#">
                                            <span class="button-wrapper">
                                                <span class="icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                                                <span class="text">Checkout</span>
                                            </span>
                                        </a>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="simple-article size-3 col-xs-b30">Looking for a different quantity for
                                            (H106060SDSUN600G) Please email us at <a class="color"
                                                href="mailto:sales@subserve.co.uk">sales@subserve.co.uk</a> alternatively please
                                            call <a class="color" href="tel:+441216303624">+441216303624</a>.</div>
                                    </div>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-sm-3">
                                        <div class="h6 detail-data-title size-2">share:</div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="follow light">
                                            <a class="entry" href="#"><i class="fa fa-facebook"></i></a>
                                            <a class="entry" href="#"><i class="fa fa-twitter"></i></a>
                                            <a class="entry" href="#"><i class="fa fa-linkedin"></i></a>
                                            <a class="entry" href="#"><i class="fa fa-google-plus"></i></a>
                                            <a class="entry" href="#"><i class="fa fa-pinterest-p"></i></a>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </form>
                    <div class="row gap-10">
                        <div class="col-sm-12 col-md-4">
                            <img class="img-fluid" src="assets/img/ads-img/stripCheckout.png" alt="" />
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <img class="img-fluid" src="assets/img/ads-img/Paypal.png" alt="" />
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <img class="img-fluid" src="assets/img/ads-img/Freeshipping2.png" alt="" />
                        </div>

                    </div>

                    <div class="empty-space col-xs-b35 col-md-b70"></div>

                    <div class="tabs-block">
                        <div class="tabulation-menu-wrapper ">
                            <div class="tabulation-title simple-input">specification </div>
                            <ul class="tabulation-toggle">
                                <li><a class="tab-menu active">Specification </a></li>
                                <!--<li><a class="tab-menu">Reviews</a></li>-->
                            </ul>
                        </div>
                        <div class="empty-space col-xs-b20 col-sm-b30"></div>
                        <div class="tab-entry visible">
                            <div class="simple-article size-2  pl-3 pr-3 product-description">
                                <?php echo htmlspecialchars_decode($product_details['description']); ?>
                            </div>

                            <div class="empty-space col-xs-b15"></div>                         
                          

                        </div>  
                    </div>
                    <style>
                        img.loaders {
                            width: 70px;
                            /* display: inline-block; */
                            margin: auto;
                            margin-top: 50px;
                            margin-bottom: 50px;
                        }
                    </style>
                    <!-- RELATED PRODUCTS START-->
                     <input type="hidden" id="category_id" value="<?php echo $product_details['category_id']; ?>">
                     <input type="hidden" id="subcategory_id" value="<?php echo $product_details['subcategory_id']; ?>">
                     <input type="hidden" id="product_id" value="<?php echo $product_details['id']; ?>">
                    <div class="row" id="related-products">
                          
                          
                            
                    </div>
                    <!-- <img class="loaders" src="https://subserve.co.uk/assets/img/loader.gif" alt="Loading..." /> -->
                    <!-- RELATED PRODUCTS END-->

                </div> 
            </div>
        </div>
        <?php
        
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href = "http://localhost/subserve/404.php";';
        echo '</script>';
        exit();
        echo "No product found for slug: " . $get_product_query;
    }

    // Close the result set
    $get_product_result->close();
}
?>
<?php
include('layouts/footer-scripts2.php');
?>
<!-- Single Product Page -->
<script>
    $(document).ready(function () {
        $('.page-product .product-description h2').removeAttr('style');
    });

    document.addEventListener("DOMContentLoaded", function() {
        // AJAX request related products laanay kay liye
        fetchRelatedProducts();
    });

    function fetchRelatedProducts() {
        $("#related-products").html('<img class="loaders" src="https://subserve.co.uk/assets/img/loader.gif" alt="Loading..." />');
        // Get dynamic values from hidden input fields
        const categoryId = $("#category_id").val();
        const subcategoryId = $("#subcategory_id").val();
        const productId = $("#product_id").val();
        $.ajax({
            url: "/src/get-related-products.php",
            type: "GET",
            dataType: "html",
            data: {
                category_id: categoryId,
                subcategory_id: subcategoryId,
                product_id: productId
            },
            success: function(response) {
                $("#related-products").html(response); // Load related products into the container
            },
            error: function(error) {
                console.log("Error loading related products: ", error);
            }
        });
    }
</script>

<?php
include('layouts/footer-end.php');
?>