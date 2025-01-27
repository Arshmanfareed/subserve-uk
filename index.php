<?php
include('layouts/header.php');
include('src/connection.php');

?>
<div class="page-home">
    <div class="content-margins">

    
        <div class="row main-baneers">
            <div class="col-md-9 baneers" style="background-image: url('http://localhost/subserve/assets/ELEVATE.jpg');"></div>
            <div class="col-md-3">
            <form class="flex-component__mobileUp-3 login-form login-form-standard login-form--home login-form--carousel form" action="/login.php?action=check_login" method="post">
        
        
                <h3>Sign in</h3>
                <div class="form-field">
                    <label class="form-label" for="login_email">Email Address:</label>
                    <input class="form-input" name="login_email" id="login_email" type="email" fdprocessedid="g0wc0c">
                </div>
                <div class="form-field">
                    <label class="form-label" for="login_pass">Password:</label>
                    <input class="form-input" id="login_pass" type="password" name="login_pass" fdprocessedid="xqkf2">
                </div>
                <div class="form-actions">
                        <button class="button--primary login-form__button">Sign in</button>
                        <div class="login-form__links">
                            <a class="forgot-password" href="/login.php?action=reset_password">Forgot your password?</a>
                                <a class="login-form__create-account" href="/login.php?action=create_account">Create Account</a>
                        </div>

                </div>
            </form>
            </div>
        </div>

        <div class="row popular-pro">
            <h2>Most Popular Products</h2>
            <?php
                // SQL query to join products with brands and fetch the required data
                $get_product_list_query = "
                    SELECT 
                        p.*, 
                        b.name 
                    FROM 
                        products AS p
                    JOIN 
                        brands AS b 
                    ON 
                        p.brand_id = b.id
                    ORDER BY 
                        p.id ASC 
                    LIMIT 4
                ";

                // Execute the query
                $get_product_result = $conn->query($get_product_list_query);

                // Check if any products are returned
                if ($get_product_result && $get_product_result->num_rows > 0) {
                    while ($product = $get_product_result->fetch_assoc()) {
                        // echo "<pre>";
                        // print_r($product);
                        ?>
                        <div class="col-md-3">
                            <div class="pro-box">
                                <div class="pro-img">
                                    <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['product_name']); ?>">
                                </div>
                                <div class="pro-content">
                                    <div class="card-brandwrap">
                                        <p class="card-text card-text--brand"><?= htmlspecialchars($product['name']); ?></p>
                                        <p class="card-text card-text--sku">PART NO: <?php echo $product['part_no']; ?></p>
                                    </div>
                                    <h4 class="card-title">
                                        <a href="<?= htmlspecialchars($product['product_url']); ?>" tabindex="0"><?= htmlspecialchars(mb_strimwidth($product['product_name'], 0, 50, '...')); ?></a>
                                    </h4>
                                    <span class="pro-price">£<?= number_format($product['current_price'], 2); ?> <abbr title="Excluding Tax">ex. VAT / TAX</abbr></span>
                                    <span class="pro-in-stock">In Stock</span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>

            
        </div>

        <div class="row popular-pro Featured-pro">
            <h2>Featured Products</h2>
            <?php
                // SQL query to join products with brands and fetch the required data
                $get_product_list_query1 = "
                    SELECT 
                        p.*, 
                        b.name AS brand_name 
                    FROM 
                        products AS p
                    JOIN 
                        brands AS b 
                    ON 
                        p.brand_id = b.id
                    WHERE 
                        p.category_id = 11
                    ORDER BY 
                        p.id ASC 
                    LIMIT 4
                ";

                // Execute the query
                $get_product_result1 = $conn->query($get_product_list_query1);

                // Check if any products are returned
                if ($get_product_result1 && $get_product_result1->num_rows > 0) {
                    while ($product = $get_product_result1->fetch_assoc()) {
                        // echo "<pre>";
                        // print_r($product);
                        ?>
                        <div class="col-md-3">
                            <div class="pro-box">
                                <div class="pro-img">
                                    <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['product_name']); ?>">
                                </div>
                                <div class="pro-content">
                                    <div class="card-brandwrap">
                                        <p class="card-text card-text--brand"><?= htmlspecialchars($product['brand_name']); ?></p>
                                        <p class="card-text card-text--sku">PART NO: <?php echo $product['part_no']; ?></p>
                                    </div>
                                    <h4 class="card-title">
                                        <a href="<?= htmlspecialchars($product['product_url']); ?>" tabindex="0"><?= htmlspecialchars(mb_strimwidth($product['product_name'], 0, 50, '...')); ?></a>
                                    </h4>
                                    <span class="pro-price">£<?= number_format($product['current_price'], 2); ?> <abbr title="Excluding Tax">ex. VAT / TAX</abbr></span>
                                    <span class="pro-in-stock">In Stock</span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>
            
        </div>

        <div class="row popular-pro New-pro">
            <h2>New Products</h2>
            <?php
                // SQL query to join products with brands and fetch the required data
                $get_product_list_query2 = "
                    SELECT 
                        p.*, 
                        b.name AS brand_name 
                    FROM 
                        products AS p
                    JOIN 
                        brands AS b 
                    ON 
                        p.brand_id = b.id
                    WHERE 
                        p.category_id = 11
                    ORDER BY 
                        p.id ASC 
                    LIMIT 4
                ";

                // Execute the query
                $get_product_result2 = $conn->query($get_product_list_query2);

                // Check if any products are returned
                if ($get_product_result2 && $get_product_result2->num_rows > 0) {
                    while ($product = $get_product_result2->fetch_assoc()) {
                        // echo "<pre>";
                        // print_r($product);
                        ?>
                        <div class="col-md-3">
                            <div class="pro-box">
                                <div class="pro-img">
                                    <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['product_name']); ?>">
                                </div>
                                <div class="pro-content">
                                    <div class="card-brandwrap">
                                        <p class="card-text card-text--brand"><?= htmlspecialchars($product['brand_name']); ?></p>
                                        <p class="card-text card-text--sku">PART NO: <?php echo $product['part_no']; ?></p>
                                    </div>
                                    <h4 class="card-title">
                                        <a href="<?= htmlspecialchars($product['product_url']); ?>" tabindex="0"><?= htmlspecialchars(mb_strimwidth($product['product_name'], 0, 50, '...')); ?></a>
                                    </h4>
                                    <span class="pro-price">£<?= number_format($product['current_price'], 2); ?> <abbr title="Excluding Tax">ex. VAT / TAX</abbr></span>
                                    <span class="pro-in-stock">In Stock</span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>
            
        </div>
    </div>


    <!-- <div class="banner-wrapper">
            <div>
            <iframe id="vimeoPlayer" class="" src="https://player.vimeo.com/video/915950094?autoplay=1&muted=1&loop=1&badge=0&autopause=0&player_id=0&app_id=58479" frameborder="0" allow="autoplay; fullscreen" allowfullscreen title="4681689 Ram Sticks Memory Computer 1280X720 resizeed"></iframe>
            
            </div>
            <div class="content-bg text-center">
                <div class="row text-center">
                    <div class="col-sm-12 col-md-11 col-lg-8  mx-auto">
                        <h1>Elevating businesses worldwide with latest tech solutions - Subserve! </h1>
                    </div>
               </div>
            </div>
    </div> -->
    <!-- <div class="products-cat-slider-wrapper slider-wrapper">
        <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <div class="content-header">
                    <h2>Categories</h2>
                    <p>One-stop shop for everyone building a PC!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <div class="product-categories-slide slider-wrap">
                    <div class="product-categories-slider ">
                        <a href="category/hard-drives">
                            <img class="img-fluid" data-lazy="/assets/img/categories/harddrive.webp">
                            <div class="product-card-content">
                                <h3>Hard Drives</h3>
                            <p>Hard drives are an important storage component for computers, allowing vast amounts of data to be stored including documents and multimedia.</p>
                            </div>
                        </a>

                    </div>
                    <div class="product-categories-slider">
                        <a href="category/ssds">
                            <img class="img-fluid" data-lazy="/assets/img/categories/ssd.webp">
                            <div class="product-card-content">
                                <h3>SSDs</h3>
                            <p>Solid State Drives (SSDs) have brought advancements in storage and data access and have enhanced the overall performance. </p>
                            </div>
                         </a>
                    </div>
                    <div class="product-categories-slider">
                       <a href="category/network">
                            <img class="img-fluid" data-lazy="/assets/img/categories/networking.webp">
                            <div class="product-card-content">
                                <h3>Network</h3>
                            <p>Get a chance to experience high-end networking capability with Subserve-USA. We provide users with top-tier network solutions to enhance the overall connectivity</p>
                            </div>
                         </a>
                    </div>
                    <div class="product-categories-slider">
                        <a href="category/motherboards">
                            <img class="img-fluid" data-lazy="/assets/img/categories/motherboard.jpg">
                            <div class="product-card-content">
                                <h3>Motherboards</h3>
                            <p>Motherboards act as the backbone of any computer system, providing communication between different components.</p>
                            </div>
                         </a>
                    </div>
                    <div class="product-categories-slider">
                        <a href="category/power-supply">
                            <img class="img-fluid" data-lazy="/assets/img/categories/powersupply.jpg">
                            <div class="product-card-content">
                                <h3>Power Supplies</h3>
                            <p>Power supplies are essential components for any computer system that ensures stable power to all components attached to a system. </p>
                            </div>
                         </a>
                    </div>
                    <div class="product-categories-slider">
                        <a href="category/memory-modules">
                            <img class="img-fluid" data-lazy="/assets/img/categories/memory-module.jpg">
                            <div class="product-card-content">
                                <h3>Memory Modules</h3>
                            <p>Memory is a significant element for any computer system that allows multitasking and easy data access. Subserve-USA gives you a chance to get your desired memory module.</p>
                            </div>
                         </a>
                    </div>
                    <div class="product-categories-slider">
                       <a href="category/server">
                            <img class="img-fluid" data-lazy="/assets/img/categories/server.jpg">
                            <div class="product-card-content">
                                <h3>Servers</h3>
                            <p>Whether your need is to host a website or to manage data, servers play a crucial role in any of those activities. </p>
                            </div>
                         </a>
                    </div>
                </div>
                <div class="slider-btn-wrap">
                	<button class="prev-btn-slider"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                	<button class="next-btn-slider"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
    </div> -->
    <!--<div class="cta-section">-->
    <!--    <div class="container">-->
    <!--        <div class="row align-items-center">-->
    <!--            <div class="col-md-6">-->
    <!--                <div class="cta-content-left">-->
    <!--                    <h5>Reliable hardware at your doorstep</h5>-->
    <!--                    <p>Building your PC? Get dependable and advanced hardware at Subserve. Shop durable products all in one place, available 24/7. Quick Delivery. Easy Return Policy. </p>-->
    <!--                    <a href="/shop-main.php">Shop Now <i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col-md-6">-->
    <!--                <div class="cta-img-right">-->
    <!--                    <div class="cta-img-bg"></div>-->
    <!--                    <img src="/assets/img/extra-img/cta-01-img.webp" class="img-fluid">-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!-- <div class="features-slider-wrapper slider-wrapper">
        <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <div class="content-header">
                    <h2>Features Brands</h2>
                    <p>Upgrade your IT projects with the best brands</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <div class="features-slide slider-wrap">
                    <a href="/category/hard-drives" class="feature-link" data-category="82" data-slug="hard-drives">
                        <div class="product-categories-slider">
                        <img class="img-fluid" src="/assets/img/brands/sun-hd.png">
                        <div class="product-card-content">
                            <h3>Sun Hard Drives</h3>
                        <p>Build or repair your computer with our extensive range of dependable and optimal sun hard drives. </p>
                        </div>
                    </div>    
                    </a>
                    <a href="/category/memory-modules" class="feature-link" data-category="40" data-slug="memory-modules">
                        <div class="product-categories-slider">
                        <img class="img-fluid" src="/assets/img/brands/samsung-memory.png">
                        <div class="product-card-content">
                            <h3>Samsung Memory Modules</h3>
                        <p>Find the most reliable Samsung memory modules from our diverse selection to supercharge your gear.</p>
                        </div>
                    </div>
                    </a>
                    <a href="/category/server" class="feature-link" data-category="24" data-slug="server">
                        <div class="product-categories-slider">
                        <img class="img-fluid" src="/assets/img/brands/hp-server.png">
                        <div class="product-card-content">
                            <h3>HP Servers</h3>
                        <p>Explore unparalleled and reliable HP servers from our wide collection to boost your hardware performance. </p>
                        </div>
                    </div>
                    </a>
                    <a href="/category/power-supply" class="feature-link" data-category="74" data-slug="power-supply">
                        <div class="product-categories-slider">
                        <img class="img-fluid" src="/assets/img/brands/barcode-power-supply.png">
                        <div class="product-card-content">
                            <h3>Brocade Power Supply</h3>
                        <p>Unleash the power of your system with reliable and efficient brocade power supply collection. </p>
                        </div>
                    </div>
                    </a>
                    <a href="/category/video-cards" class="feature-link" data-category="46" data-slug="video-cards">
                        <div class="product-categories-slider">
                        <img class="img-fluid" src="/assets/img/brands/asus-video.png">
                        <div class="product-card-content">
                            <h3>ASUS Video Cards</h3>
                        <p>Customize your tech arsenal with the latest and robust Asus video cards from our broad selection.</p>
                        </div>
                    </div>
                    </a>
                    <a href="/category/ssds" class="feature-link" data-category="96" data-slug="ssds">
                        <div class="product-categories-slider">
                        <img class="img-fluid" src="/assets/img/brands/sony-ssd.png">
                        <div class="product-card-content">
                            <h3>Sony SSDs</h3>
                        <p>Power up your game station with this extensive collection of fast and tough Sony SSDs.</p>
                        </div>
                    </div>
                    </a>
                    
                </div>
                <div class="slider-btn-wrap">
                	<button class="feature-prev-btn-slider"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                	<button class="feature-next-btn-slider"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="featured-categories-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="big-cat-left down-content featured-cat-thumbs">
                        <img class="right-0 left-none w-100 h-100" src="assets/img/extra-img/motherboard-cat.webp">
                        <div class="thumb-content">
                            <h5>Mother Board</h5>
                            <p>Choose the right<br> motherboard for your PC</p>
                            <a href="/category/motherboards">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="big-cat-right down-content featured-cat-thumbs">
                                <img src="assets/img/extra-img/memory-thumb.png">
                                <div class="thumb-content">
                                    <h5>Memory Modules</h5>
                                    <p>Memory modules for swift and efficent PCs</p>
                                    <a href="/category/memory-modules">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 col-lg-6">
                            <div class="small-cat-left up-content featured-cat-thumbs">
                                <img src="assets/img/extra-img/hard-cat.png">
                                <div class="thumb-content">
                                    <h5>Hard Drives</h5>
                                    <p>Hold more data with the best hard drives</p>
                                    <a href="/category/hard-drives">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="small-cat-right down-content featured-cat-thumbs">
                                <img src="assets/img/extra-img/ssd-cat.png">
                                <div class="thumb-content">
                                    <h5>SSD’s</h5>
                                    <p>Add more power to your PC.</p>
                                    <a href="/category/ssds">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="services-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="/about-us.php">
                        <div class="service-box-blue service-box">
                            <h5>Our Goal</h5>
                            <p>Discover high-performance computer components at Subserve-USA, your ultimate tech destination with all the solutions.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a class="open-popup" data-rel="4">
                        <div class="service-box-yellow service-box">
                            <h5>Quotation</h5>
                            <p>Unleash the power of tech. Discover top-tier components to enhance the reliability and performance of your systems. Upgrade now!</p>
                        </div>
                    </a>
                </div>
                <!-- <div class="col-md-4">
                    <div class="service-box-blue service-box">
                        <h5>Blogs</h5>
                        <p>Stay updated with the latest tech trends, product guides, and expert insights. Upgrade your tech know-how now with our blogs!</p>
                    </div>
                </div> -->
            </div>
        </div>
    </div>


    <div class="collaborator-slider-wrapper slider-wrapper">
        <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <div class="content-header">
                    <h2>Brands We Deal In</h2>
                </div>
            </div>
        </div>
        </div>
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <div class="partners-slide slider-wrap">
                        <!-- <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (10).png"></div> -->
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (11).png"></div>
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (12).png"></div>
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (13).png"></div>
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (14).png"></div>
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (15).png"></div>
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (16).png"></div>
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (17).png"></div>
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (6) (1).png"></div>
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (7) (1).png"></div>
                        <!-- <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (8) (1).png"></div> -->
                        <div class="slider-image-wrapper"><img class="img-fluid" src="/assets/img/partners/pngegg (9).png"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include('layouts/footer-scripts2.php');
?>
<!-- Fetch Mix Categories Product -->


<?php
include('layouts/footer-end.php');
?>