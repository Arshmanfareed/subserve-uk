<?php
include('layouts/header.php');
include('src/connection.php');


// SQL query to fetch categories and subcategories
$get_categories_query = "SELECT * FROM categories";
$get_categories_result = $conn->query($get_categories_query);
$searchTerm = strval($_GET['search']);


// SQL query to fetch product list for category ID 
// Number of products to display per page
$productsPerPage = 15;
// Determine the current page
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $productsPerPage;
// SQL query to fetch products for the current page
$get_product_list_query = "SELECT * FROM products  WHERE 
        product_name LIKE '%$searchTerm%' 
        OR part_no LIKE '%$searchTerm%'  LIMIT $offset, $productsPerPage";
$get_product_result = $conn->query($get_product_list_query);

$product_sqlCount = "SELECT COUNT(*) as total FROM products";
$product_countResult = $conn->query($product_sqlCount);
$totalProducts_count = $product_countResult->fetch_assoc()['total'];
?>

<div class="page-shop">
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
                        Shop
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
                                    echo '<a class="entry AddToCartTic" ><i class="fa fa-check" aria-hidden="true"></i></a>';
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
                            href="shop-main.php?page=<?php echo max($current_page - 1, 1); ?>">
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
                                echo '<a class="pagination" href="shop-main.php?page=1">1</a>';
                                echo '<span class="pagination">...</span>';
                            }

                            for ($page = $startPage; $page <= $endPage; $page++) {
                                echo '<a class="pagination ' . (($page == $current_page) ? 'active' : '') . '" href="shop-main.php?page=' . $page . '">' . $page . '</a>';
                            }

                            if ($endPage < $totalPages) {
                                echo '<span class="pagination">...</span>';
                                echo '<a class="pagination" href="shop-main.php?page=' . $totalPages . '">' . $totalPages . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-3 hidden-xs text-right">
                        <a class="button size-1 style-5"
                            href="shop-main.php?page=<?php echo min($current_page + 1, $totalPages); ?>">
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
                <!-- <div class="h4 col-xs-b25">Price</div>
            <div id="prices-range"></div> -->
                <!-- <div class="simple-article size-1">PRICE: <b class="grey">$<span class="min-price">40</span> - $<span
                        class="max-price">300</span></b>
            </div> -->
            </div>
        </div>
    </div>
</div>
<?php
include('layouts/footer-scripts2.php');
?>

<?php
include('layouts/footer-end.php');
?>