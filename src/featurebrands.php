<?php
include('connection.php');
$cat_slug = $_POST['cslug'];
$current_page = 1;
$Category_ID = isset($_POST['category_id']) ? $_POST['category_id'] : 0;
$selectedBrands = isset($_POST['selected_brands']) ? $_POST['selected_brands'] : 0;
$brandCondition = !empty($selectedBrands) ? "AND brand_id IN (" . $selectedBrands . ")" : "";
// Use mysqli_real_escape_string to prevent SQL injection
$escaped_cat_slug = $conn->real_escape_string($cat_slug);

// Getting Slug with ID
$get_categories_slug = "SELECT * FROM categories WHERE category_slug = '$escaped_cat_slug'";
$slug_categories_result = $conn->query($get_categories_slug);

// Check for errors in the query execution
if (!$slug_categories_result) {
    echo "Error executing query: " . $conn->error;
    exit();
} else {
    // Check if a row is fetched
    if ($slug_categories_result->num_rows > 0) {
        $category_id_result = $slug_categories_result->fetch_assoc();
        $Category_ID = $category_id_result['id'];
        $Category_Name = $category_id_result['name'];
        // echo $Category_ID;
    } else {
        echo "No results found for category slug: " . $cat_slug;
        exit();
    }

    // Close the result set
    $slug_categories_result->close();
}

// SQL query to fetch categories and subcategories
$get_categories_query = "SELECT * FROM categories";
$get_categories_result = $conn->query($get_categories_query);

// SQL query to fetch product list for category ID 
// Number of products to display per page
$productsPerPage = 15;
// Determine the current page
$offset = ($current_page - 1) * $productsPerPage;
// SQL query to fetch products for the current page
$get_product_list_query = "SELECT * FROM products 
                           WHERE (category_id = $Category_ID OR subcategory_id = $Category_ID)
                           $brandCondition
                           LIMIT $offset, $productsPerPage";
$get_product_result = $conn->query($get_product_list_query);
// print_r($get_product_list_query);


$product_sqlCount = "SELECT COUNT(*) as total FROM products 
                           WHERE (category_id = $Category_ID OR subcategory_id = $Category_ID)
                           $brandCondition";
$product_countResult = $conn->query($product_sqlCount);
$totalProducts_count = $product_countResult->fetch_assoc()['total'];
?>
<div class="align-inline spacing-1">
    <div class="h4">
        <?php echo $Category_Name ?>
    </div>
</div>
<div class="align-inline spacing-1">
    <div class="simple-article size-1">SHOWING <b class="grey">15</b> OF <b class="grey">
            <span id="total_products_count"><?php echo $totalProducts_count ?></span>
        </b> RESULTS
    </div>
</div>
<!--<div class="align-inline spacing-1 hidden-xs">-->
<!--    <a class="pagination toggle-products-view active"><img src="assets/img/extra-img/icon-14.png"-->
<!--            alt="" /><img src="assets/img/extra-img/icon-15.png" alt="" /></a>-->
<!--    <a class="pagination toggle-products-view"><img src="assets/img/extra-img/icon-16.png"-->
<!--            alt="" /><img src="assets/img/extra-img/icon-17.png" alt="" /></a>-->
<!--</div>-->

<div class="empty-space col-xs-b25 col-sm-b60"></div>

<div class="products-content">
    <div class="products-wrapper">
        <div class="row nopadding">
            <!-- Your PHP code for displaying products -->
            <?php
        if ($get_product_result->num_rows > 0) {
            // Output HTML structure for each product
            while ($product = $get_product_result->fetch_assoc()) {
                $Product_ID = $product['id'];
                $getProductPicture = "SELECT * FROM product_images WHERE product_id = $Product_ID";
                $product_ImgResult = $conn->query($getProductPicture);
                $totalProducts_Img = $product_ImgResult->fetch_assoc();
                $UrlImage = $totalProducts_Img['image'];
                $product_BrandID = $product['brand_id'];

                $getting_brand = "SELECT * FROM brands WHERE id = $product_BrandID";
                $product_BrandResult = $conn->query($getting_brand);
                $row_BrandResult = $product_BrandResult->fetch_assoc();
                $ProductBrand_name = $row_BrandResult['name'];
                // echo $ProductBrand_name;
              
                echo '<div class="col-sm-4">';
                echo '<form class="AddToCartForm">';
                echo '  <input type="hidden" name="TicProductID" class="TicProductID" value="' . $product['id'] . '">
                <input type="hidden" name="TicProductName" class="TicProductName" value="' . $product['product_name'] . '">
                <input type="hidden" name="TicProductPartNO" class="TicProductPartNO" value="' . $product['product_name'] . '">
                <input type="hidden" name="TicCategoryName" class="TicCategoryName" value="' . $product['category_id'] . '">
                <input type="hidden" name="TicProductImg" class="TicProductImg" value="' . $product['image_url'] . '">
                <input type="hidden" name="TicProductPriceInc" class="TicProductPriceInc" value="' . $product['purchase_price'] . '"> 
                <input type="hidden" name="TicProductPriceExc" class="TicProductPriceExc" value="' . $product['sale_price'] . '">
                <input type="hidden" name="TicProductBrand" class="TicProductBrand" value="' . $product['brand_id'] . '">
                <input type="hidden" name="TicProductCondition" class="TicProductCondition" value="' . $product['condition'] . '">
                <input type="hidden" name="TicProductQuantity" class="TicProductQuantity" value="1">
                <input type="hidden" name="TicProductSlug" class="TicProductSlug" value="' . $product['slug'] . '">';
                echo '<div class="product-shortcode text-center style-1">';
                echo '<div class="preview">';
                echo '<a href="product/' . $product['slug'] . '">';
                echo '<img id="pro-img" src="assets/images/' . $UrlImage . '" alt="">'; // Static image
                echo '</div>';
                echo '</a>';
                echo '<div class="product-item-content">';
                echo '<div class="h6 product-item-name animate-to-green"><a href="product/' . $product['slug'] . '">' . $product['product_name'] . '</a></div>';
                echo '<div class="simple-article product-item-price size-4">';
                echo '<span class="price-1 color"><del>$' . $product['purchase_price'] . ' (Exc. Vat)</del> </span>';
                echo '<span class="price-2 color">$' . $product['sale_price'] . ' (Inc. Vat) </span>';
                echo '</div>';
                echo '<div class="icons">';
                echo '<a class="entry AddToCartTiccatg"><i class="fa fa-check" aria-hidden="true"></i></a>';
                // Add the "View Details" link with data-product attribute
                echo '<a class="entry open-popup" data-rel="3"  data-product=\'';
                echo json_encode($product);
                echo '\' data-brand=' . $ProductBrand_name . '><i class="fa fa-eye" aria-hidden="true"></i></a>';
                echo '<a class="entry" ><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "<h5 style='text-align:center'>No products found</h5>";
        }
        // Calculate the total number of pages
        $sqlCount = "SELECT COUNT(*) as total FROM products 
                           WHERE (category_id = $Category_ID OR subcategory_id = $Category_ID)
                           $brandCondition";
        $countResult = $conn->query($sqlCount);
        $totalProducts = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalProducts / $productsPerPage);
        ?>
        </div>
    </div>
</div>
<div class="empty-space col-xs-b35 col-sm-b0"></div>
<div class="row">
    <div class="col-sm-3 hidden-xs">
        <!--<a class="button size-1 style-5"-->
        <!--    href="category/<?php echo $cat_slug ?>?page=<?php echo max($current_page - 1, 1); ?>">-->
        <a class="button size-1 style-5" id="coming-page" data-page="<?php echo max($current_page - 1, 1); ?>">
            <span class="button-wrapper">
                <span class="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                <span class="text">prev page</span>
            </span>
        </a>
    </div>
    <div class="col-sm-6 text-center">

        <div class="pagination-wrapper">
            <?php
            $pagesToShow = 4; // Adjust as needed
            $halfPagesToShow = floor($pagesToShow / 2);
        
            // Correct the calculation of total pages
            $totalPages = ceil($totalProducts_count / $productsPerPage);
        
            $startPage = max(1, $current_page - $halfPagesToShow);
            $endPage = min($totalPages, $startPage + $pagesToShow - 1);
        
            if ($startPage > 1) {
                echo '<a class="pagination" data-page="1" id="coming-page">1</a>';
                echo '<span class="pagination">...</span>';
            }
        
            for ($page = $startPage; $page <= $endPage; $page++) {
                echo '<a class="pagination ' . (($page == $current_page) ? 'active' : '') . '"  id="coming-page" data-page="' . $page . '">' . $page . '</a>';

            }
        
            if ($endPage < $totalPages) {
                echo '<span class="pagination">...</span>';
                echo '<a class="pagination" id="coming-page" data-page="' . $page . '">' . $totalPages . '</a>';
            }
            ?>
        </div>

    </div>
    <div class="col-sm-3 hidden-xs text-right">
        <a class="button size-1 style-5" id="coming-page" data-page="<?php echo min($current_page + 1, $totalPages); ?>">
            <span class="button-wrapper">
                <span class="icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                <span class="text">next page</span>
            </span>
        </a>
    </div>
</div>

<div class="empty-space col-xs-b35 col-md-b70"></div>
<div class="empty-space col-md-b70"></div>
<script>
$(document).ready(function () {

        // Use a more specific selector for the click event
        $('.AddToCartTiccatg').click(function () {
            // Get the form related to the clicked button
            let form = $(this).closest('form');
            let ProductID = form.find('.TicProductID').val();
            let ProductName = form.find('.TicProductName').val();
            let ProductPartNO = form.find('.TicProductPartNO').val();
            let CategoryName = form.find('.TicCategoryName').val();
            let ProductImg = form.find('.TicProductImg').val();
            let ProductPriceInc = form.find('.TicProductPriceInc').val();
            let ProductPriceExc = form.find('.TicProductPriceExc').val();
            let ProductBrand = form.find('.TicProductBrand').val();
            let ProductCondition = form.find('.TicProductCondition').val();
            let ProductQuantity = form.find('.TicProductQuantity').val();

            // Create an object with the extracted values
            let productDetails = {
                name: ProductName,
                priceIn: ProductPriceInc,
                priceEx: ProductPriceExc,
                imageUrl: ProductImg,
                quantity: ProductQuantity
            };

            // Send an AJAX request to add the product to the cart
            $.ajax({
                type: "POST",
                url: "src/cart_handler.php", // Replace with the actual path to your backend script
                data: {
                    action: "add_to_cart",
                    item: productDetails
                },
                dataType: "json",
                success: function (response) {
                    // Handle the success response
                    console.log(response.message);
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Product added to Cart!",
                        showConfirmButton: false,
                        timer: 1000
                    });
                    // Add a delay before reloading the page
                    setTimeout(function () {
                        // Reload the page after the delay
                        window.location.href = 'cart.php';
                    }, 1000); // 1000 milliseconds = 1 second
                },
                error: function (error) {
                    // Handle the error response
                    console.error("Error adding item to cart: " + error.responseText);
                }
            });
        });
    });
    
</script>