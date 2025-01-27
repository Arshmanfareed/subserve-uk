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
        $Category_Description = $category_id_result['description']; // Fetch description
        $Category_image = $category_id_result['image']; // Fetch description
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
$productsPerPage = 15;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $productsPerPage;
$get_product_list_query = "SELECT * FROM products WHERE category_id = $Category_ID OR subcategory_id = $Category_ID
        LIMIT $offset, $productsPerPage";
$get_product_result = $conn->query($get_product_list_query);

// Getting Brands List
$get_brands_sql = "SELECT DISTINCT brand_id FROM products WHERE category_id = $Category_ID  OR subcategory_id = $Category_ID";
$get_brands_result = $conn->query($get_brands_sql);

// Count total products
$product_sqlCount = "SELECT COUNT(*) as total FROM products WHERE category_id = $Category_ID  OR subcategory_id = $Category_ID";
$product_countResult = $conn->query($product_sqlCount);
$totalProducts_count = $product_countResult->fetch_assoc()['total'];


$Category_image = $Category_image; // Example: Leave empty to test fallback
$fallbackImage = "http://localhost/subserve/assets/images/cat-banner.png"; // Fallback image
?>

<div class="page-shop">
<section class="cat-banners" style="background-image: url('<?php echo !empty($Category_image) ? "http://localhost/subserve/wr-admin/pages/categories/$Category_image" : $fallbackImage; ?>'); 
                background-position: center;background-repeat: no-repeat;
    background-size: cover;">
    <h2><?php echo $Category_Name; ?></h2>
</section>
    <div class="content-margins">
    <div class="container-fluid">
        <div class="breadcrumbs">
            <!-- <a href="#">home</a>
            <a href="#">Shop</a> -->
            <!-- <a href="#"><?php //echo $Category_Name ?></a> -->
            <input type="hidden" id="Input_Category_ID" value="<?php echo $Category_ID ?>">
            <input type="hidden" id="Input_Category_Name" value="<?php echo $Category_Name ?>">
            <input type="hidden" id="Input_Category_Slug" value="<?php echo $escaped_cat_slug ?>">
            <input type="hidden" id="Input_Category_cpage" value="<?php echo $current_page ?>">
            <input type="hidden" id="cat_slug" value="<?php echo $cat_slug ?>">
        </div>
        <div class="empty-space col-xs-b15 col-sm-b50 col-md-b100"></div>             

        <div class="container-fluid">
            <div class="row cat-row">
                <div class="productselect">
                    <select id="product_per_page" onchange="productperPagez()">
                        <option value="36">36 Products</option>
                        <option value="72" selected>72 Products</option>
                        <option value="144">144 Products</option>
                    </select>
                </div>
                
                <div class="col-md-10 col-md-push-2" id="update_products">
                    <div class="loader"></div>
                </div>
                <div class="col-md-2 col-md-pull-10">
                
                    <div class="h4 col-xs-b10">Popular Categories</div>
                    <?php
                    if ($get_categories_result->num_rows > 0) {
                        $categories = array();
                        while ($get_categories_row = $get_categories_result->fetch_assoc()) {
                            $categories[] = $get_categories_row;
                        }

                        echo '<ul class="categories-menu transparent">';
                        foreach ($categories as $category) {
                            if ($category['parent_id'] == null) {
                                echo '<li class="category">';
                                echo '<a href="category/' . $category['category_slug'] . '">' . $category['name'] . '</a>';
                                echo '<div class="toggle"></div>';
                                echo '<ul class="subcategories">';
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
                    <style>
                        .manifacturing {
                            height: 290px;
                            overflow-y: scroll;
                            overflow-x: hidden;
                        }
                        /* Custom Scrollbar Styles */
                        .manifacturing::-webkit-scrollbar {
                            width: 8px; /* Width of the vertical scrollbar */
                        }

                        .manifacturing::-webkit-scrollbar-track {
                            background: #f1f1f1; /* Light background for the scrollbar track */
                        }

                        .manifacturing::-webkit-scrollbar-thumb {
                            background: #000; /* Black scrollbar thumb */
                            border-radius: 10px; /* Rounded corners for the thumb */
                        }

                        .manifacturing::-webkit-scrollbar-thumb:hover {
                            background: #333; /* Slightly lighter black when hovered */
                        }
                    </style>
                    <div class="h4 col-xs-b25">Manufacturer</div>
                    <div class="manifacturing">
                        <?php
                        if ($get_brands_result->num_rows > 0) {
                            while ($brand_row = $get_brands_result->fetch_assoc()) {
                                $brand_id = $brand_row['brand_id'];
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
                    </div>
                    

                    <div class="empty-space col-xs-b25 col-sm-b50"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
    

    <div class="empty-space col-xs-b15 col-sm-b45"></div>
    <div class="empty-space col-md-b70"></div>
</div>

<?php
include('layouts/footer-scripts2.php');
?>

<script>
    $(document).ready(function () {
        initializePage();

        function initializePage() {
            var selectedBrand = localStorage.getItem('CatBrand');
            var selectedID = localStorage.getItem('CatID');

            if (selectedBrand !== null && selectedID !== null) {
                initializeBrandCheckboxes(selectedBrand);
                updateProducts(selectedBrand);
            } else {
                getNormalProducts();
            }

            localStorage.removeItem('CatID');
            localStorage.removeItem('CatBrand');
        }

        

        function initializeBrandCheckboxes(selectedBrand) {
            $('.brand-checkbox').each(function () {
                if ($(this).val() == selectedBrand) {
                    $(this).prop('checked', true);
                }
            });
        }

        function updateProducts(selectedBrand) {
            var catSlug = localStorage.getItem('CatSlug');
            var categoryID = localStorage.getItem('CatID');
            var catPage = localStorage.getItem('CatPage');
            var selectedBrands = localStorage.getItem('CatBrand');

            $.ajax({
                type: 'POST',
                url: 'http://localhost/subserve/src/featurebrands.php',
                data: {
                    cslug: catSlug,
                    page: catPage,
                    category_id: categoryID,
                    selected_brands: selectedBrands
                },
                success: function (response) {
                    $('#update_products').html(response);
                },
                error: function (xhr, status, error) {
                    console.log('Error loading products:', status, error);
                }
            });
        }

        function getNormalProducts() {
            var catSlug = $("#cat_slug").val();
            var categoryID = $("#Input_Category_ID").val();
            var catPage = $("#Input_Category_cpage").val();
            var selectedBrands = getSelectedBrandValues();

            $.ajax({
                type: 'POST',
                url: 'http://localhost/subserve/src/pagination.php',
                data: {
                    cslug: catSlug,
                    page: catPage,
                    category_id: categoryID,
                    selected_brands: selectedBrands
                },
                success: function (response) {
                    $('#update_products').html(response);
                    
                },
                error: function (xhr, status, error) {
                    console.log('Error loading products:', status, error);
                }
            });
        }


       

        function getSelectedBrandValues() {
            var selectedBrands = [];
            $(".brand-checkbox:checked").each(function () {
                selectedBrands.push($(this).val());
            });
            return selectedBrands;
        }
    });
</script>

<script>
     function productperPagez() {
            var catSlug = $("#cat_slug").val();
            var categoryID = $("#Input_Category_ID").val();
            var catPage = $("#Input_Category_cpage").val();
            // var selectedBrands = getSelectedBrandValues();
            var productsPerPage = $("#product_per_page").val(); // Get the selected value

            $.ajax({
                type: 'POST',
                url: 'http://localhost/subserve/src/pagination.php',
                data: {
                    cslug: catSlug,
                    page: catPage,
                    category_id: categoryID,
                    // selected_brands: selectedBrands,
                    products_per_page: productsPerPage // Send this value to the backend
                },
                success: function (response) {
                    $('#update_products').html(response);
                    
                },
                error: function (xhr, status, error) {
                    console.log('Error loading products:', status, error);
                }
            });
        }
</script>



<?php
session_write_close();
sleep(2);
include('layouts/footer-end.php');
?>
