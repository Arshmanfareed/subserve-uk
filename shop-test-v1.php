<?php
include('layouts/header.php');
include('src/connection.php');


$cat_slug = $_GET['cslug'];

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
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $productsPerPage;
// SQL query to fetch products for the current page
// $get_product_list_query = "SELECT * FROM products WHERE category_id = $Category_ID
//         LIMIT $offset, $productsPerPage";
// SQL query to fetch products for the current page
$get_product_list_query = "SELECT * FROM products 
WHERE category_id = $Category_ID OR subcategory_id = $Category_ID
LIMIT $offset, $productsPerPage";

$get_product_result = $conn->query($get_product_list_query);


// Getting Brands List
// SQL query to fetch distinct brand_ids for the selected category
$get_brands_sql = "SELECT DISTINCT brand_id
        FROM products
        WHERE category_id = $Category_ID";

$get_brands_result = $conn->query($get_brands_sql);


$product_sqlCount = "SELECT COUNT(*) as total FROM products WHERE category_id = $Category_ID";
$product_countResult = $conn->query($product_sqlCount);
$totalProducts_count = $product_countResult->fetch_assoc()['total'];
?>


<div class="container">
    <div class="empty-space col-xs-b15 col-sm-b30"></div>
    <div class="breadcrumbs">
        <a href="#">home</a>
        <a href="#">Shop</a>
    </div>
    <div class="empty-space col-xs-b15 col-sm-b50 col-md-b100"></div>
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <!-- <div class="empty-space col-xs-b35 col-md-b70"></div> -->
            <div class="align-inline spacing-1">
                <div class="h4">
                    <?php echo $Category_Name ?>
                </div>
            </div>
            <div class="align-inline spacing-1">
                <div class="simple-article size-1">SHOWING <b class="grey">15</b> OF <b class="grey">
                        <?php echo $totalProducts_count ?>
                    </b> RESULTS
                </div>
            </div>
            <div class="align-inline spacing-1 hidden-xs">
                <a class="pagination toggle-products-view active"><img src="assets/img/extra-img/icon-14.png"
                        alt="" /><img src="assets/img/extra-img/icon-15.png" alt="" /></a>
                <a class="pagination toggle-products-view"><img src="assets/img/extra-img/icon-16.png" alt="" /><img
                        src="assets/img/extra-img/icon-17.png" alt="" /></a>
            </div>

            <div class="empty-space col-xs-b25 col-sm-b60"></div>

            <div class="products-content">
                <div class="products-wrapper">
                    <div class="row nopadding">
                        <?php
                        // Check if there are any rows
                        if ($get_product_result->num_rows > 0) {
                            // Output HTML structure for each product
                            while ($product = $get_product_result->fetch_assoc()) {
                                $Product_ID = $product['id'];
                                $getProductPicture = "SELECT * FROM product_images WHERE product_id = $Product_ID";
                                $product_ImgResult = $conn->query($getProductPicture);
                                $totalProducts_Img = $product_ImgResult->fetch_assoc();
                                $UrlImage = $totalProducts_Img['image'];

                                echo '<div class="col-sm-4">';
                                echo '<div class="product-shortcode text-center style-1">';
                                echo '<div class="preview">';
                                echo '<img src="assets/images/' . $UrlImage . '" alt="">'; // Static image
                                echo '<div class="preview-buttons valign-middle">';
                                echo '<div class="valign-middle-content">';
                                echo '<a class="button size-2 style-2" href="#">';
                                echo '<span class="button-wrapper">';
                                echo '<span class="icon"><img src="assets/img/extra-img/icon-1.png" alt=""></span>';
                                echo '<span class="text">Learn More</span>';
                                echo '</span>';
                                echo '</a>';
                                echo '<a class="button size-2 style-3" href="#">';
                                echo '<span class="button-wrapper">';
                                echo '<span class="icon"><img src="assets/img/extra-img/icon-3.png" alt=""></span>';
                                echo '<span class="text">Add To Cart</span>';
                                echo '</span>';
                                echo '</a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="product-item-content">';
                                echo '<div class="h6 product-item-name animate-to-green"><a href="#">' . $product['product_name'] . '</a></div>';
                                echo '<div class="simple-article product-item-price size-4">';
                                echo '<span class="price-1 color">$' . $product['sale_price'] . ' (Exc. Vat) </span>';
                                echo '<span class="price-2 color">$' . $product['current_price'] . ' (Inc. Vat) </span>';
                                echo '</div>';
                                echo '<div class="icons">';
                                echo '<a class="entry"><i class="fa fa-check" aria-hidden="true"></i></a>';
                                echo '<a class="entry open-popup" data-rel="3"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                                echo '<a class="entry"><i class="fa fa-heart-o" aria-hidden="true"></i></a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "<h5 style='text-align:center'>No products found</h5>";
                        }
                        // Calculate the total number of pages
                        $sqlCount = "SELECT COUNT(*) as total FROM products";
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
                    <a class="button size-1 style-5"
                        href="category/<?php echo $cat_slug ?>?page=<?php echo max($current_page - 1, 1); ?>">
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

                        $startPage = max(1, $current_page - $halfPagesToShow);
                        $endPage = min($totalPages, $startPage + $pagesToShow - 1);

                        if ($startPage > 1) {
                            
                            echo '<a class="pagination" href="category/' . $cat_slug . '?page=1">1</a>';
                            echo '<span class="pagination">...</span>';
                        }

                        for ($page = $startPage; $page <= $endPage; $page++) {
                            // echo '<a class="pagination ' . (($page == $current_page) ? 'active' : '') . '" href="category/' . $cat_slug . '?page=' . $page . '">' . $page . '</a>';
                            echo '<a class="pagination ' . (($page == $current_page) ? 'active' : '') . '" href="category/' . $cat_slug . '?page=' . $page . '">' . $page . '</a>';

                        }

                        if ($endPage < $totalPages) {
                            echo '<span class="pagination">...</span>';
                            echo '<a class="pagination" href="category/' . $cat_slug . '?page=' . $totalPages . '">' . $totalPages . '</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-3 hidden-xs text-right">
                    <a class="button size-1 style-5"
                        href="category/<?php echo $cat_slug ?>?page=<?php echo min($current_page + 1, $totalPages); ?>">
                        <span class="button-wrapper">
                            <span class="icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <span class="text">next page</span>
                        </span>
                    </a>
                </div>
            </div>

            <div class="empty-space col-xs-b35 col-md-b70"></div>
            <div class="empty-space col-md-b70"></div>
        </div>
        <div class="col-md-3 col-md-pull-9">
            <div class="h4 col-xs-b10">popular categories</div>
            <?php
            // Check if there are any rows
            if ($get_categories_result->num_rows > 0) {
                // Fetch data and convert to associative array
                $categories = array();
                while ($get_categories_row = $get_categories_result->fetch_assoc()) {
                    $categories[] = $get_categories_row;
                }

                // Output HTML structure
                echo '<ul class="categories-menu transparent">';
                foreach ($categories as $category) {
                    if ($category['parent_id'] == null) {
                        echo '<li class="category">';
                        echo '<a href="category/' . $category['category_slug'] . '" >' . $category['name'] . '</a>';
                        echo '<div class="toggle"></div>';
                        echo '<ul class="subcategories">';
                        // Output subcategories
                        foreach ($categories as $subcategory) {
                            if ($subcategory['parent_id'] == $category['id']) {
                                echo '<li><a href="category/' . $subcategory['category_slug'] . '">' . $subcategory['name'] . '</a></li>';
                            }
                        }
                        echo '</ul>';
                        echo '</li>';
                    }
                }
                echo '</ul>';
            } else {
                echo "No categories found";
            }
            ?>



            <div class="empty-space col-xs-b25 col-sm-b50"></div>

            <?php
            // Check if there are any brand_ids
            if ($get_brands_result->num_rows > 0) {
                echo '<div class="h4 col-xs-b25">Manufacturer</div>';

                // Output checkboxes for each brand_id
                while ($brand_row = $get_brands_result->fetch_assoc()) {
                    $brand_id = $brand_row['brand_id'];

                    // Fetch corresponding brand_name from the brands table
                    $brandQuery = "SELECT name FROM brands WHERE id = $brand_id";
                    $brandResult = $conn->query($brandQuery);

                    if ($brandResult->num_rows > 0) {
                        $brandRow = $brandResult->fetch_assoc();
                        $brand_name = $brandRow['name'];

                        echo '<label class="checkbox-entry">';
                        echo '<input type="checkbox" class="brand-checkbox" name="brands[]" value="' . $brand_id . '"><span>' . $brand_name . '</span>';
                        echo '</label>';
                        echo '<div class="empty-space col-xs-b10"></div>';
                    }
                }
            } else {
                echo 'No brands available for the selected category.';
            }
            ?>
            <div class="empty-space col-xs-b25 col-sm-b50"></div>

            <!-- <div class="h4 col-xs-b25">Price</div>
            <div id="prices-range"></div> -->
            <!-- <div class="simple-article size-1">PRICE: <b class="grey">$<span class="min-price">40</span> - $<span
                        class="max-price">300</span></b>
            </div> -->
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-sm-6 col-md-3 col-xs-b25">
            <div class="h4 col-xs-b25">Hot Sale</div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
            <div class="col-xs-b10"></div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
            <div class="col-xs-b10"></div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xs-b25">
            <div class="h4 col-xs-b25">Top Rated</div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
            <div class="col-xs-b10"></div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
            <div class="col-xs-b10"></div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xs-b25">
            <div class="h4 col-xs-b25">Popular</div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
            <div class="col-xs-b10"></div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
            <div class="col-xs-b10"></div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xs-b25">
            <div class="h4 col-xs-b25">Best Choice</div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
            <div class="col-xs-b10"></div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
            <div class="col-xs-b10"></div>
            <div class="product-shortcode style-4 rounded clearfix">
                <a class="preview" href="#"><img src="assets/img/products-img/H106060SDSUN600G.webp" alt="" /></a>
                <div class="description">
                    <div class="simple-article color size-1 col-xs-b5"><a href="#">HARD DRIVES</a></div>
                    <h6 class="h6 col-xs-b10"><a href="#">X5240A-.-SUN-36.4GB-10000R</a></h6>
                    <div class="simple-article dark">$98.00</div>
                </div>
            </div>
        </div>
    </div> -->
</div>

<div class="empty-space col-xs-b15 col-sm-b45"></div>
<div class="empty-space col-md-b70"></div>

<div class="popup-wrapper">
    <div class="bg-layer"></div>

    <div class="popup-content" data-rel="1">
        <div class="layer-close"></div>
        <div class="popup-container size-1">
            <div class="popup-align">
                <h3 class="h3 text-center">Log in</h3>
                <div class="empty-space col-xs-b30"></div>
                <input class="simple-input" type="text" value="" placeholder="Your email" />
                <div class="empty-space col-xs-b10 col-sm-b20"></div>
                <input class="simple-input" type="password" value="" placeholder="Enter password" />
                <div class="empty-space col-xs-b10 col-sm-b20"></div>
                <div class="row">
                    <div class="col-sm-6 col-xs-b10 col-sm-b0">
                        <div class="empty-space col-sm-b5"></div>
                        <a class="simple-link">Forgot password?</a>
                        <div class="empty-space col-xs-b5"></div>
                        <a class="simple-link">register now</a>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a class="button size-2 style-3" href="#">
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                <span class="text">submit</span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="popup-or">
                    <span>or</span>
                </div>
                <div class="row m5">
                    <div class="col-sm-4 col-xs-b10 col-sm-b0">
                        <a class="button facebook-button size-2 style-4 block" href="#">
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                <span class="text">facebook</span>
                            </span>
                        </a>
                    </div>
                    <div class="col-sm-4 col-xs-b10 col-sm-b0">
                        <a class="button twitter-button size-2 style-4 block" href="#">
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                <span class="text">twitter</span>
                            </span>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a class="button google-button size-2 style-4 block" href="#">
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                <span class="text">google+</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="button-close"></div>
        </div>
    </div>

    <div class="popup-content" data-rel="2">
        <div class="layer-close"></div>
        <div class="popup-container size-1">
            <div class="popup-align">
                <h3 class="h3 text-center">register</h3>
                <div class="empty-space col-xs-b30"></div>
                <input class="simple-input" type="text" value="" placeholder="Your name" />
                <div class="empty-space col-xs-b10 col-sm-b20"></div>
                <input class="simple-input" type="text" value="" placeholder="Your email" />
                <div class="empty-space col-xs-b10 col-sm-b20"></div>
                <input class="simple-input" type="password" value="" placeholder="Enter password" />
                <div class="empty-space col-xs-b10 col-sm-b20"></div>
                <input class="simple-input" type="password" value="" placeholder="Repeat password" />
                <div class="empty-space col-xs-b10 col-sm-b20"></div>
                <div class="row">
                    <div class="col-sm-7 col-xs-b10 col-sm-b0">
                        <div class="empty-space col-sm-b15"></div>
                        <label class="checkbox-entry">
                            <input type="checkbox" /><span><a href="#">Privacy policy agreement</a></span>
                        </label>
                    </div>
                    <div class="col-sm-5 text-right">
                        <a class="button size-2 style-3" href="#">
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                <span class="text">submit</span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="popup-or">
                    <span>or</span>
                </div>
                <div class="row m5">
                    <div class="col-sm-4 col-xs-b10 col-sm-b0">
                        <a class="button facebook-button size-2 style-4 block" href="#">
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                <span class="text">facebook</span>
                            </span>
                        </a>
                    </div>
                    <div class="col-sm-4 col-xs-b10 col-sm-b0">
                        <a class="button twitter-button size-2 style-4 block" href="#">
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                <span class="text">twitter</span>
                            </span>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a class="button google-button size-2 style-4 block" href="#">
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                <span class="text">google+</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="button-close"></div>
        </div>
    </div>

    <div class="popup-content" data-rel="3">
        <div class="layer-close"></div>
        <div class="popup-container size-2">
            <div class="popup-align">
                <div class="row">
                    <div class="col-sm-6 col-xs-b30 col-sm-b0">

                        <div class="main-product-slider-wrapper swipers-couple-wrapper">
                            <div class="swiper-container swiper-control-top">
                                <div class="swiper-button-prev hidden"></div>
                                <div class="swiper-button-next hidden"></div>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="swiper-lazy-preloader"></div>
                                        <div class="product-big-preview-entry swiper-lazy"
                                            data-background="assets/img/products-img/H106060SDSUN600G.webp"></div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-lazy-preloader"></div>
                                        <div class="product-big-preview-entry swiper-lazy"
                                            data-background="assets/img/products-img/H106060SDSUN600G.webp"></div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-lazy-preloader"></div>
                                        <div class="product-big-preview-entry swiper-lazy"
                                            data-background="assets/img/products-img/H106060SDSUN600G.webp"></div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-lazy-preloader"></div>
                                        <div class="product-big-preview-entry swiper-lazy"
                                            data-background="assets/img/products-img/H106060SDSUN600G.webp"></div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-lazy-preloader"></div>
                                        <div class="product-big-preview-entry swiper-lazy"
                                            data-background="assets/img/products-img/H106060SDSUN600G.webp"></div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-lazy-preloader"></div>
                                        <div class="product-big-preview-entry swiper-lazy"
                                            data-background="assets/img/products-img/H106060SDSUN600G.webp"></div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-lazy-preloader"></div>
                                        <div class="product-big-preview-entry swiper-lazy"
                                            data-background="assets/img/products-img/H106060SDSUN600G.webp"></div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="simple-article size-3 grey col-xs-b5">HARD DRIVES</div>
                        <div class="h3 col-xs-b25">X5240A-.-SUN-36.4GB-10000R</div>
                        <div class="row col-xs-b25">
                            <div class="col-sm-2">
                                <div class="simple-article size-5 grey">PRICE: </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="simple-article size-5 grey"><span class="color">$105.91 (Exc. Vat)
                                        $120.91 (Inc. Vat)</span></div>
                            </div>
                            <div class="col-sm-5 col-sm-text-right">
                                <div class="rate-wrapper align-inline">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </div>
                                <div class="simple-article size-2 align-inline">128 Reviews</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="simple-article size-3 col-xs-b5">Brand: <span class="grey">Sun</span>
                                </div>
                                <div class="simple-article size-3 col-xs-b5">Part No: <span class="grey">X5240A</span>
                                </div>

                            </div>
                            <div class="col-sm-6 col-sm-text-right">
                                <div class="simple-article size-3 col-xs-b5">AVAILABLE: <span class="grey"> IN
                                        STOCK</span>
                                </div>
                                <div class="simple-article size-3 col-xs-b5">Condition: <span
                                        class="grey">Refurbished</span>
                                </div>
                            </div>
                        </div>
                        <div class="simple-article  size-3 col-xs-b30">
                            <span class="popup-decription h6 detail-data-title size-1">Description:</span>
                            X5240A - Sun 36.4GB 10000RPM Ultra-160 SCSI LVD
                            Hot-Pluggable 80-Pin 3.5-inch Hard Drive for Sun Fire and Blade Server.
                        </div>

                        <div class="row col-xs-b40">
                            <div class="col-sm-3">
                                <div class="h6 detail-data-title size-1">quantity:</div>
                            </div>
                            <div class="col-sm-9">
                                <div class="quantity-select">
                                    <span class="minus"></span>
                                    <span class="number">1</span>
                                    <span class="plus"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row m5 col-xs-b40">
                            <div class="col-sm-6 col-xs-b10 col-sm-b0">
                                <a class="button size-2 style-2 block" href="#">
                                    <span class="button-wrapper">
                                        <span class="icon"><img src="assets/img/extra-img/icon-2.png" alt=""></span>
                                        <span class="text">add to cart</span>
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a class="button size-2 style-1 block noshadow" href="#">
                                    <span class="button-wrapper">
                                        <span class="icon"><i class="fa fa-heart-o" aria-hidden="true"></i></span>
                                        <span class="text">add to favourites</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="row">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-close"></div>
        </div>
    </div>

</div>

<?php
include('layouts/footer-scripts.php');
?>

<?php
include('layouts/footer-end.php');
?>