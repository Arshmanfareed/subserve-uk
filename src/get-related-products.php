<?php
include 'connection.php';
// Get the category and subcategory IDs
// $category_id = $product_details['category_id'];
// $subcategory_id = $product_details['subcategory_id'];

// $category_id = 81;
// $subcategory_id = 18;
// $product_id = 46374;

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$subcategory_id = isset($_GET['subcategory_id']) ? (int)$_GET['subcategory_id'] : 0;
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

// Query related products based on category or subcategory excluding the current product
$conn->query("SET SQL_BIG_SELECTS=1");
$related_products_query = "SELECT p.*, i.image
                                FROM products p
                                LEFT JOIN product_images i ON p.id = i.product_id
                                WHERE (p.category_id = '$category_id' OR p.subcategory_id = '$subcategory_id')
                                AND p.id != '$product_id' LIMIT 4";

$related_products_result = $conn->query($related_products_query);

// Check for errors in the query execution
if ($related_products_result) {
    ?>
    <div class="swiper-container arrows-align-top related-products slider-style-420" data-breakpoints="1" data-xs-slides="1"
        data-sm-slides="3" data-md-slides="4" data-lt-slides="4" data-slides-per-view="5">
        <div class="h4 swiper-title">RELATED PRODUCTS</div>
        <div class="empty-space col-xs-b20"></div>
        <!-- <div class="swiper-button-prev style-1"></div>
        <div class="swiper-button-next style-1"></div> -->
        <div class="swiper-wrapper h-600px">
            <?php


            // Fetch related products into an array
            $related_products = array();
            while ($row = $related_products_result->fetch_assoc()) {
                $Product_ID = $row['id'];
                $product_BrandID = $row['brand_id'];

                $getting_brand = "SELECT * FROM brands WHERE id = $product_BrandID";
                $product_BrandResult = $conn->query($getting_brand);
                $row_BrandResult = $product_BrandResult->fetch_assoc();
                $ProductBrand_name = $row_BrandResult['name'];

                echo '<div class="">';
                echo '<form class="AddToCartForm">';
                echo '  <input type="hidden" name="TicProductID" class="TicProductID" value="' . $row['id'] . '">
                <input type="hidden" name="TicProductName" class="TicProductName" value="' . $row['product_name'] . '">
                <input type="hidden" name="TicProductPartNO" class="TicProductPartNO" value="' . $row['part_no'] . '">
                <input type="hidden" name="TicCategoryName" class="TicCategoryName" value="' . $row['category_id'] . '">
                <input type="hidden" name="TicProductImg" class="TicProductImg" value="' . $row['image_url'] . '">
                <input type="hidden" name="TicProductPriceInc" class="TicProductPriceInc" value="' . $row['purchase_price'] . '"> 
                <input type="hidden" name="TicProductPriceExc" class="TicProductPriceExc" value="' . $row['sale_price'] . '">
                <input type="hidden" name="TicProductBrand" class="TicProductBrand" value="' . $row['brand_id'] . '">
                <input type="hidden" name="TicProductCondition" class="TicProductCondition" value="' . $row['condition'] . '">
                <input type="hidden" name="TicProductQuantity" class="TicProductQuantity" value="1">
                <input type="hidden" name="TicProductSlug" class="TicProductSlug" value="' . $row['slug'] . '">';
                echo '<div class="product-shortcode text-center style-1">';
                echo '<div class="preview">';
                echo '<a href="product/' . $row['slug'] . '">';
                echo '<img id="pro-img" src="'.  $row['image_url'] . '" alt="">'; // Static image
                echo '</a>';
                echo '</div>';
                echo '<div class="product-item-content">';
                echo '<div class="h6 product-item-name animate-to-green"><a href="product/' . $row['slug'] . '">' . $row['product_name'] . '</a></div>';
                echo '<div class="simple-article product-item-price size-4">';
                //echo '<span class="price-1 color">$' . $row['purchase_price'] . ' (Exc. Vat) </span>';
                echo '<span class="price-2 color">$' . number_format($row['current_price'], 2) . ' </span>';
                echo '</div>';
                echo '<div class="icons">';
                echo '<a class="entry AddToCartTic" ><i class="fa fa-check" aria-hidden="true"></i></a>';
                // Add the "View Details" link with data-product attribute
                echo '<a class="entry open-popup" data-rel="3" data-product=\'' . json_encode($row) . '\' data-brand="' . $ProductBrand_name . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                //echo '<a class="entry"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
            }

            ?>
        </div>
        <div class="swiper-pagination relative-pagination visible-xs"></div>
    </div>
    <?php
}
?>

<!-- Tic Add To Cart -->

<script>
    $(document).ready(function () {

        // Use a more specific selector for the click event
        $('.AddToCartTic').click(function () {
            
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
                        window.location.href = '../cart.php';
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