<?php
include('layouts/header.php');
include('src/connection.php');

?>

        <div class="slider-wrapper hero-section col-sm-mt70 col-md-mt100">
            <div class="swiper-button-prev visible-lg"></div>
            <div class="swiper-button-next visible-lg"></div>
            <div class="swiper-container" data-parallax="1" data-auto-height="1">
               <div class="swiper-wrapper">
                   <div class="swiper-slide bg-primary">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="cell-view page-height">
                                        <div class="col-xs-b40 col-sm-b80"></div>
                                        <div data-swiper-parallax-x="-600">
                                            <div class="simple-article light transparent size-3">PROFESSIONAL EDITION</div>
                                            <div class="col-xs-b5"></div>
                                        </div>
                                        <div data-swiper-parallax-x="-500">
                                            <h1 class="h1 light">choice of the professionals</h1>
                                            <div class="title-underline light left"><span></span></div>
                                        </div>
                                        <div data-swiper-parallax-x="-400">
                                            <div class="simple-article size-4 light transparent">
                                                <p>In feugiat molestie tortor a malesuada. Etiam a venenatis ipsum. Proin pharetra elit at feugiat commodo vel placerat tincidunt sapien nec</p>
                                            </div>
                                            <div class="col-xs-b30"></div>
                                        </div>
                                        <div data-swiper-parallax-x="-300">
                                            <div class="buttons-wrapper">
                                                <a class="button size-2 style-1" href="#">
                                                    <span class="button-wrapper">
                                                        <span class="icon"><img src="assets/img/extra-img/icon-1.png" alt=""></span>
                                                        <span class="text">Learn More</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-b40 col-sm-b80"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-background right hidden-xs" data-swiper-parallax-x="-600">
                                <img src="assets/img/banner/banner-middle.png" alt="" />
                            </div>
                            <div class="empty-space col-xs-b80 col-sm-b0"></div>
                        </div>
                   </div>
                   <!-- <div class="swiper-slide" style="background-image: url(assets/img/extra-img/background-2.jpg);">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-6 col-sm-text-right">
                                    <div class="cell-view page-height">
                                        <div class="col-xs-b40 col-sm-b80"></div>
                                        <div data-swiper-parallax-x="-600">
                                            <div class="simple-article light transparent size-3">PROFESSIONAL EDITION</div>
                                            <div class="col-xs-b5"></div>
                                        </div>
                                        <div data-swiper-parallax-x="-500">
                                            <h1 class="h1 light">choice of the professionals</h1>
                                            <div class="title-underline light left"><span></span></div>
                                        </div>
                                        <div data-swiper-parallax-x="-400">
                                            <div class="simple-article size-4 light transparent">
                                                <p>In feugiat molestie tortor a malesuada. Etiam a venenatis ipsum. Proin pharetra elit at feugiat commodo vel placerat tincidunt sapien nec</p>
                                            </div>
                                            <div class="col-xs-b30"></div>
                                        </div>
                                        <div data-swiper-parallax-x="-300">
                                            <div class="buttons-wrapper">
                                                <a class="button size-2 style-1" href="#">
                                                    <span class="button-wrapper">
                                                        <span class="icon"><img src="assets/img/extra-img/icon-1.png" alt=""></span>
                                                        <span class="text">Learn More</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-b40 col-sm-b80"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-background left hidden-xs" data-swiper-parallax-x="-600">
                                <img src="assets/img/extra-img/background-12.png" alt=""  />
                            </div>
                            <div class="empty-space col-xs-b80 col-sm-b0"></div>
                        </div>
                   </div>
                   <div class="swiper-slide" style="background-image: url(assets/img/extra-img/background-3.jpg);">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2 col-sm-text-center">
                                    <div class="cell-view page-height">
                                        <div class="col-xs-b40 col-sm-b80"></div>
                                        <div data-swiper-parallax-x="-600">
                                            <div class="simple-article light transparent size-3">PROFESSIONAL EDITION</div>
                                            <div class="col-xs-b5"></div>
                                        </div>
                                        <div data-swiper-parallax-x="-500">
                                            <h1 class="h1 light">choice of the professionals</h1>
                                            <div class="title-underline light left"><span></span></div>
                                        </div>
                                        <div data-swiper-parallax-x="-400">
                                            <div class="simple-article size-4 light transparent">
                                                <p>In feugiat molestie tortor a malesuada. Etiam a venenatis ipsum. Proin pharetra elit at feugiat commodo vel placerat tincidunt sapien nec</p>
                                            </div>
                                            <div class="col-xs-b30"></div>
                                        </div>
                                        <div data-swiper-parallax-x="-300">
                                            <div class="buttons-wrapper">
                                                <a class="button size-2 style-1" href="#">
                                                    <span class="button-wrapper">
                                                        <span class="icon"><img src="assets/img/extra-img/icon-1.png" alt=""></span>
                                                        <span class="text">Learn More</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-b40 col-sm-b80"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="empty-space col-xs-b80 col-sm-b0"></div>
                        </div>
                   </div> -->
               </div>
               <div class="swiper-pagination swiper-pagination-white"></div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-md-3 align-self-center  col-lg-2 col-xl-2  col-xs-b30 col-sm-b0">
                    <div class="categories-wrapper float-end">
                        <h4 class="h4 col-xs-b20">popular categories</h4>
                        <a class="category-link active"> modern edition</a>
                        <a class="category-link">professional edition</a>
                        <a class="category-link"> collorexedition</a>
                        <a class="category-link"> sport edition</a>
                        <a class="category-link"> classic edition</a>
                        <a class="category-link">progresive edition</a>
                        <a class="category-link"> underground edition</a>
                        <a class="category-link">accessories</a>
                        <div class="empty-space col-xs-b20"></div>
                        <a class="button size-2 style-3" href="#">
                            <span class="button-wrapper">
                                <span class="icon"><img src="img/icon-4.png" alt=""></span>
                                <span class="text">view all categories</span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-9 col-lg-10 col-xl-10">
                    <div class="slider-wrapper">
                        <div class="swiper-button-prev hidden"></div>
                        <div class="swiper-button-next hidden"></div>
                        <div class="swiper-container" data-breakpoints="1" data-xs-slides="1" data-sm-slides="2" data-md-slides="2" data-lt-slides="3"  data-slides-per-view="4">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="product-shortcode style-6">
                                        <div class="content">
                                            
                                            <div class="title">
                                                <div class="simple-article size-3 color col-xs-b5"><a href="category/hard-drives">Modern edition</a></div>
                                                <div class="h5 animate-to-green"><a href="category/hard-drives">Hard Drives</a></div>
                                            </div>
                                            <div class="description">
                                                <div class="simple-article text size-2 animate-to-fulltransparent">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </div>
                                            </div>
                                            <div class="preview">
                                                <img src="assets/img/products-img/hard-drives.png" alt="" />
                                            </div>
                                            <div class="price">
                                                <div class="simple-article size-4 grey animate-to-fulltransparent">From <span class="color">$155.00</span></div>
                                            </div>
                                            <div class="preview-button">
                                                <a class="button size-2 style-3" href="category/hard-drives">
                                                    <span class="button-wrapper">
                                                        <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                                                        <span class="text">View More</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product-shortcode style-6">
                                        <div class="content">
                                            <div class="title">
                                                <div class="simple-article size-3 color col-xs-b5"><a href="category/video-cards">Modern edition</a></div>
                                                <div class="h5 animate-to-green"><a href="category/video-cards">Video Cards</a></div>
                                            </div>
                                            <div class="description">
                                                <div class="simple-article text size-2 animate-to-fulltransparent">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
                                            </div>
                                            <div class="preview">
                                                <img src="assets/img/products-img/video-cards.png" alt="" />
                                            </div>
                                            <div class="price">
                                                <div class="simple-article size-4 grey animate-to-fulltransparent">From <span class="color">$155.00</span></div>
                                            </div>
                                            <div class="preview-button">
                                                <a class="button size-2 style-3" href="category/video-cards">
                                                    <span class="button-wrapper">
                                                        <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                                                        <span class="text">View More</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product-shortcode style-6">
                                        <div class="content">
                                            <div class="title">
                                                <div class="simple-article size-3 color col-xs-b5"><a href="category/memory-modules">Modern edition</a></div>
                                                <div class="h5 animate-to-green"><a href="category/memory-modules">Memory Module</a></div>
                                            </div>
                                            <div class="description">
                                                <div class="simple-article text size-2 animate-to-fulltransparent">Mollis nec consequat at In feugiat molestie tortor a malesuada etiam a venenatis </div>
                                            </div>
                                            <div class="preview">
                                                <img src="assets/img/products-img/memory-module.png" alt="" />
                                            </div>
                                            <div class="price">
                                                <div class="simple-article size-4 grey animate-to-fulltransparent">From <span class="color">$155.00</span></div>
                                            </div>
                                            <div class="preview-button">
                                                <a class="button size-2 style-3" href="category/memory-modules">
                                                    <span class="button-wrapper">
                                                        <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                                                        <span class="text">View More</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="product-shortcode style-6">
                                        <div class="content">
                                            <div class="title">
                                                <div class="simple-article size-3 color col-xs-b5"><a href="category/ssds">Modern edition</a></div>
                                                <div class="h5 animate-to-green"><a href="category/ssds">SSD'S</a></div>
                                            </div>
                                            <div class="description">
                                                <div class="simple-article text size-2 animate-to-fulltransparent">Mollis nec consequat at In feugiat molestie tortor a malesuada etiam a venenatis </div>
                                            </div>
                                            <div class="preview">
                                                <img src="assets/img/products-img/ssds.png" alt="" />
                                            </div>
                                            <div class="price">
                                                <div class="simple-article size-4 grey animate-to-fulltransparent">From <span class="color">$155.00</span></div>
                                            </div>
                                            <div class="preview-button">
                                                <a class="button size-2 style-3" href="category/ssds">
                                                    <span class="button-wrapper">
                                                        <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                                                        <span class="text">View More</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination relative-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>

        <div class="container">
            <div class="text-center">
                <div class="simple-article size-3 grey uppercase col-xs-b5">accessories</div>
                <div class="h2">choosing in one style</div>
                <div class="title-underline center"><span></span></div>
            </div>
        </div>
   
        <div class="container">
            <div class="small-items-line slider-wrapper hidden-pixel-y">
                <div class="row nopadding mix-categories-product">
                      <!-- fetching data  -->
                </div>
            </div>
            <div class="empty-space col-xs-b30"></div>
            <div class="text-center">
                <a class="button size-2 style-3" href="#">
                    <span class="button-wrapper">
                        <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                        <span class="text">view all accessories</span>
                    </span>
                </a>
            </div>
        </div>



        <div class="container">
            <div class="text-center">
                <div class="simple-article size-3 grey uppercase col-xs-b5">recommended products</div>
                <div class="h2">choose the best</div>
                <div class="title-underline center"><span></span></div>
            </div>
        </div>

        <div class="empty-space col-xs-b35 col-md-b70"></div>

        <?php
            // Assume you have a database connection named $conn

            // Specify the category IDs
            // $categoryIds = [11, 12, 32, 44, 38];
            $categoryIds = [11, 12, 32, 44, 38, 80, 51, 58];

            // Fetch categories based on specified IDs
            $query = "SELECT id, name FROM categories WHERE id IN (" . implode(",", $categoryIds) . ")";
            $result = mysqli_query($conn, $query);

            // Check if there are categories
            if (mysqli_num_rows($result) > 0) {
                ?>
                    <div class="container w-80 section-categories-product-filter">
                        <div class="tabs-block">
                            <div class="container">
                                <div class="tabulation-menu-wrapper text-center">                       
                                    <ul class="tabulation-toggle">
                                        <li>
                                            <a class="tab-menu active" data-category-id="all">
                                            All
                                            </a>
                                        </li>
                                        <?php
                                        $category_num = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $categoryId = $row['id'];
                                            $categoryName = $row['name'];
                                            ?>
                                            <li><a class="tab-menu" data-category-id="<?php echo $categoryId; ?>">
                                                    <?php echo $categoryName; ?>
                                                </a></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="empty-space col-xs-b30 col-sm-b60"></div>

                            <?php
                                // Fetch products for all categories (2 products each)
                                $allProductsQuery = "SELECT p.*, b.name AS brand_name
                                    FROM products p
                                    JOIN product_images pi ON p.id = pi.product_id
                                    JOIN brands b ON p.brand_id = b.id
                                    WHERE p.category_id IN (" . implode(",", $categoryIds) . ") AND pi.status = 1
                                    LIMIT 5";

                                $allProductsResult = mysqli_query($conn, $allProductsQuery);

                                ?>
                                    <div class="tab-entry active" data-category-id="all">
                                        <div class="slider-wrapper side-borders slider-style-180">
                                            <div class="swiper-button-prev hidden-xs hidden-sm"></div>
                                            <div class="swiper-button-next hidden-xs hidden-sm"></div>
                                            <div class="swiper-container" data-breakpoints="1" data-xs-slides="1" data-sm-slides="2" data-md-slides="3" data-lt-slides="4"  data-slides-per-view="4">
                                                <div class="swiper-wrapper">

                                                    <?php
                                                    // Fetch products for all categories (1 product each)
                                                    $products = array();

                                                    foreach ($categoryIds as $categoryId) {
                                                        $categoryProductsQuery = "SELECT p.* , pi.image, b.name AS brand_name
                                                            FROM products p
                                                            JOIN product_images pi ON p.id = pi.product_id
                                                            JOIN brands b ON p.brand_id = b.id
                                                            WHERE p.category_id = $categoryId AND pi.status = 1
                                                            LIMIT 2";

                                                        $categoryProductsResult = mysqli_query($conn, $categoryProductsQuery);

                                                        if ($product = mysqli_fetch_assoc($categoryProductsResult)) {
                                                            $products[] = $product;
                                                        }

                                                        mysqli_free_result($categoryProductsResult);
                                                    }

                                                    // Display products in a loop
                                                    foreach ($products as $product) {
                                                        ?>
                                                        <div class="swiper-slide">
                                                            <div class="product-shortcode style-5 small">
                                                                <div class="product-label green">best price</div>
                                                                <div class="icons">
                                                                    <a class="entry"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                                    <a class="entry open-popup" data-rel="3" data-product="<?php echo htmlentities(json_encode($product), ENT_QUOTES, 'UTF-8'); ?>" data-brand="<?php echo $product['brand_name']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                    
                                                                    <a class="entry"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                                                </div>
                                                                <div class="preview">
                                                                    <img id="pro-img" src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" />
                                                                </div>
                                                                <div class="title">
                                                                    <div class="h6 animate-to-green"><a href="#"><?php echo $product['product_name']; ?></a></div>
                                                                </div>                                                         
                                                                <div class="price">
                                                                    <div class="simple-article size-4 dark">
                                                                        <span class="price-1 color"><del><?php echo $product['purchase_price']; ?> (Exc. Vat)</del></span>
                                                                        <span class="price-2 color"><?php echo $product['sale_price']; ?> (Inc. Vat)</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="swiper-pagination relative-pagination visible-xs visible-sm"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php

                            // Reset the result pointer
                            mysqli_data_seek($result, 0);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $categoryId = $row['id'];
                                ?>
                                    <div class="tab-entry " data-category-id="<?php echo $categoryId; ?>">
                                        <div class="slider-wrapper side-borders slider-style-180">
                                            <div class="swiper-button-prev hidden-xs hidden-sm"></div>
                                            <div class="swiper-button-next hidden-xs hidden-sm"></div>
                                            <div class="swiper-container" data-breakpoints="1" data-xs-slides="1" data-sm-slides="2" data-md-slides="3" data-lt-slides="5"  data-slides-per-view="5">
                                                <div class="swiper-wrapper">
                                                    <?php
                                                    // Fetch products for the current category (8 products each)
                                                    $categoryProductsQuery = "SELECT p.* , pi.image, b.name AS brand_name
                                                        FROM products p
                                                        JOIN product_images pi ON p.id = pi.product_id
                                                        JOIN brands b ON p.brand_id = b.id
                                                        WHERE p.category_id = $categoryId AND pi.status = 1
                                                        LIMIT 5";

                                                    $categoryProductsResult = mysqli_query($conn, $categoryProductsQuery);

                                                    while ($product = mysqli_fetch_assoc($categoryProductsResult)) {
                                                        ?>
                                                            <div class="swiper-slide">
                                                                <div class="product-shortcode style-5 small">
                                                                    <div class="product-label green">best price</div>
                                                                    <div class="icons">
                                                                        <a class="entry"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                                        <a class="entry open-popup" data-rel="3" data-product="<?php echo htmlentities(json_encode($product), ENT_QUOTES, 'UTF-8'); ?>"data-brand="<?php echo $product['brand_name']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                        <a class="entry"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                                                    </div>
                                                                    <div class="preview">
                                                                        <img id="pro-img" src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" />
                                                                    </div>
                                                                    <div class="title">
                                                                        <div class="h6 animate-to-green"><a href="#"><?php echo $product['product_name']; ?></a></div>
                                                                    </div>                                                         
                                                                    <div class="price">
                                                                        <div class="simple-article size-4 dark">
                                                                            <span class="price-1 color"><del><?php echo $product['purchase_price']; ?> (Exc. Vat)</del></span>
                                                                            <span class="price-2 color"><?php echo $product['sale_price']; ?> (Inc. Vat)</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                    }

                                                    mysqli_free_result($categoryProductsResult);
                                                    ?>
                                                </div>
                                                <div class="swiper-pagination relative-pagination visible-xs visible-sm"></div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                            }

                            mysqli_free_result($result);
                            ?>
                        </div>
                    </div>
                <?php
            }
        ?>


        <div class="empty-space col-xs-b35 col-md-b70"></div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>

        <div class="block-entry section-special-offer" >
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 d-sm-none special-product-img ">
                        <div class="empty-space col-xs-b35"></div>
                        <img src="assets/img/products-img/special-offer-product.png" alt="" />
                        <div class="empty-space col-xs-b35"></div>
                    </div>
                    <div class="col-sm-12 col-md-6 ">
                        <div class="cell-view simple-banner-height">
                            <div class="empty-space col-xs-b35"></div>
                            <div class="simple-article light transparent size-3 uppercase col-xs-b5">special offer</div>
                            <h2 class="h2 light">get -30% off on all headphones</h2>
                            <div class="title-underline left light"><span></span></div>
                            <div class="simple-article light size-4 col-xs-b20">Praesent nec finibus massa. Phasellus id auctor lacus, at iaculis lorem. Donec quis arcu elit. In vehicula purus sem, eu mattis est lacinia.</div>
                            <div class="countdown light max-width col-xs-b30" data-end="Feb,2   ,2024"></div>
                            <div class="single-line-form">
                                <input class="simple-input" type="text" value="" placeholder="Your email">
                                <div class="button size-2 style-2">
                                    <span class="button-wrapper">
                                        <span class="icon"><img src="assets/img/extra-img/icon-1.png" alt=""></span>
                                        <span class="text">submit</span>
                                    </span>
                                    <input type="submit" value="" />
                                </div>
                            </div>
                            <div class="empty-space col-xs-b35"></div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>

        <div class="empty-space col-xs-b35 col-md-b70"></div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>       
        

 
        <div class="empty-space col-xs-b35 col-md-b70"></div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>

        <div class="row nopadding">
            <div class="col-md-6">
                <div class="banner-shortcode style-3 wide bg-primary">
                    <div class="valign-middle-cell">
                        <div class="slider-product-preview hidden-xs">
                            <img src="assets/img/banner/left-banner.png" alt="">
                        </div>
                        <div class="valign-middle-content">
                            <div class="simple-article size-3 light transparent uppercase col-xs-b5">relax collection</div>
                            <h3 class="h3 light">your perfect sound</h3>
                            <div class="title-underline light left"><span></span></div>
                            <div class="simple-article size-4 light transparent col-xs-b30">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesentir pulvinar ante et nisl scelerisque.</div>
                            <a class="button size-2 style-1" href="category/video-cards">
                                <span class="button-wrapper">
                                    <span class="icon"><img src="assets/img/extra-img/icon-1.png" alt=""></span>
                                    <span class="text">View More</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="banner-shortcode style-3 wide bg-primary">
                    <div class="valign-middle-cell">
                        <div class="slider-product-preview hidden-xs">
                            <img src="assets/img/banner/right-banner.png" alt="">
                        </div>
                        <div class="valign-middle-content">
                            <div class="simple-article size-3 light transparent uppercase col-xs-b5">street collection</div>
                            <h3 class="h3 light">noise is not a problem</h3>
                            <div class="title-underline light left"><span></span></div>
                            <div class="simple-article size-4 light transparent col-xs-b30">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesentir pulvinar ante et nisl scelerisque.</div>
                            <a class="button size-2 style-1" href="category/motherboards">
                                <span class="button-wrapper">
                                    <span class="icon"><img src="assets/img/extra-img/icon-1.png" alt=""></span>
                                    <span class="text">learn more</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="empty-space col-xs-b35 col-md-b70"></div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>

     

        <div class="empty-space col-xs-b35 col-md-b70"></div>

        
        <div class="container">
            <div class="small-items-line slider-wrapper hidden-pixel-y">
                <div class="row nopadding mix-categories-product">
                      <!-- fetching data  -->
                </div>
            </div>
            <div class="empty-space col-xs-b30"></div>
            <div class="text-center">
                <a class="button size-2 style-3" href="#">
                    <span class="button-wrapper">
                        <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                        <span class="text">view all accessories</span>
                    </span>
                </a>
            </div>
        </div>

        <div class="empty-space col-xs-b35 col-md-b70"></div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>
               
        <?php
include('layouts/footer-scripts.php');
?>

<?php
include('layouts/footer-end.php');
?>