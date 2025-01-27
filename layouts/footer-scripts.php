<div class="popup-wrapper">
    <div class="bg-layer"></div>
    <!-- Login Form -->
    <div class="popup-content" data-rel="1">
        <div class="layer-close"></div>
        <div class="popup-container size-1">
            <div class="popup-align">
                <h3 class="h3 text-center">Log in</h3>
                <div class="empty-space col-xs-b30"></div>
                <input class="simple-input" type="text" id="email" placeholder="Your email" />
                <div class="empty-space col-xs-b10 col-sm-b20"></div>
                <input class="simple-input" type="password" id="password" placeholder="Enter password" />
                <div id="login-response" class="simple-link"></div>
                <div class="empty-space col-xs-b10 col-sm-b20"></div>
                <div class="row">
                    <div class="col-sm-6 col-xs-b10 col-sm-b0">
                        <div class="empty-space col-sm-b5"></div>
                        <a href="/forget-password.php" class="simple-link">Forgot password?</a>
                        <div class="empty-space col-xs-b5"></div>
                        <a href="#" class="simple-link open-popup " data-rel="2">Register now</a>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button id="loginBtn" class="button size-2 style-3">
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                <span class="text">Submit</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="popup-content registration-popup" data-rel="2">
        <div class="layer-close"></div>
        <div class="popup-container size-1">
            <div class="popup-align">
                <h3 class="h3 text-center">Register</h3>
                <div class="empty-space col-xs-b30"></div>
                <form id="registrationForm" class="registration-form">
                    <!-- Existing fields -->

                    <div class="row">
                        <div class="col-xm-12 col-sm-12 col-md-6 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-name" type="text" name="name" placeholder="Your name" />
                            <div class="empty-space col-xs-b10 col-sm-b20"></div>
                        </div>
                        <div class="col-xm-12 col-sm-12 col-md-6 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-email" type="text" name="email"
                                placeholder="Your email" />
                            <div class="empty-space col-xs-b10 col-sm-b20"></div>
                        </div>
                        <div class="col-xm-12 col-sm-12 col-md-6 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-password" type="password" name="password"
                                placeholder="Enter password" />
                            <div class="empty-space col-xs-b10 col-sm-b20"></div>
                        </div>
                        <div class="col-xm-12 col-sm-12 col-md-6 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-confirm-password" type="password" name="confirmPassword"
                                placeholder="Repeat password" />
                            <div class="empty-space col-xs-b10 col-sm-b20"></div>


                        </div>
                        <!-- New optional fields -->
                        <div class="col-xm-12 col-sm-12 col-md-12 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-street" type="text" name="street"
                                placeholder="Street" />
                            <div class="empty-space col-xs-b10 col-sm-b20"></div>
                        </div>
                        <div class="col-xm-12 col-sm-12 col-md-12 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-apartment" type="text" name="apartment"
                                placeholder="Apartment" />
                            <div class="empty-space col-xs-b10 col-sm-b20"></div>
                        </div>
                        <div class="col-xm-12 col-sm-12 col-md-6 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-city" type="text" name="city" placeholder="City" />
                            <div class="empty-space col-xs-b10 col-sm-b20"></div>
                        </div>
                        <div class="col-xm-12 col-sm-12 col-md-6 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-state" type="text" name="state" placeholder="State" />
                            <div class="empty-space col-xs-b10 col-sm-b20"></div>
                        </div>
                        <div class="col-xm-12 col-sm-12 col-md-6 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-zip" type="text" name="zip" placeholder="ZIP Code" />
                            <div class="empty-space col-xs-b10 col-sm-b20"></div>
                        </div>
                        <div class="col-xm-12 col-sm-12 col-md-6 col-xs-b10 col-sm-b0">
                            <input class="simple-input register-phone" type="text" name="phone" placeholder="Phone" />
                            <div class="empty-space col-sm-b15"></div>
                        </div>
                        <div class="col-12 mx-auto text-center">
                            <div id="register-response" class="simple-link"></div>
                        </div>

                        <div class="col-xm-10 col-sm-6  mx-auto text-center">
                            <button id="registerBtn" class="button w-100 size-2 style-3">
                                <span class="button-wrapper">
                                    <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt="" /></span>
                                    <span class="text">Submit</span>
                                </span>
                            </button>
                            <div class="empty-space col-sm-b15"></div>
                            <p class="simple-link col-xs-t10 col-sm-t0">Already have an account?<a class="open-popup"
                                    data-rel="1"> Login Here</a></p>
                        </div>
                    </div>

                </form>
            </div>

        </div>
        <div class="button-close"></div>
    </div>

    <div class="popup-content popup-view-cart" data-rel="3">
        <div class="layer-close"></div>
        <div class="popup-container size-2">
            <div class="popup-align">
                <form action="" class="addToCart">
                    <input type="hidden" name="ViewProductID" class="ViewProductID">
                    <input type="hidden" name="ViewProductName" class="ViewProductName">
                    <input type="hidden" name="ViewCategoryName" class="ViewCategoryName">
                    <input type="hidden" name="ViewProductImg" class="ViewProductImg">
                    <input type="hidden" name="ViewProductPriceInc" class="ViewProductPriceInc">
                    <input type="hidden" name="ViewProductPriceExc" class="ViewProductPriceExc">
                    <input type="hidden" name="ViewProductBrand" class="ViewProductBrand">
                    <input type="hidden" name="ViewProductCondition" class="ViewProductCondition">
                    <input type="hidden" name="ViewProductQuantity" class="ViewProductQuantity">
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
                                                data-background="assets/img/products-img/H106060SDSUN600G.webp"
                                                id="productMainImg"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="simple-article size-3 grey col-xs-b5" id="cartCategoryName">HARD DRIVES</div>
                            <div class="h3 col-xs-b25" id="cartProductName">X5240A-.-SUN-36.4GB-10000R</div>
                            <div class="row col-xs-b25">
                                <div class="col-sm-2">
                                    <div class="simple-article size-5 grey">PRICE: </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="simple-article size-5 grey"><span class="color PriceInc">$105.91 (Exc.
                                            Vat)
                                            <span class="PriceExc">$120.91 (Inc. Vat)</span></span></div>
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
                                    <div class="simple-article size-3 col-xs-b5">Brand: <span
                                            class="grey productBrand">Sun</span>
                                    </div>
                                    <div class="simple-article size-3 col-xs-b5">Part No: <span
                                            class="grey partNo">X5240A</span>
                                    </div>

                                </div>
                                <div class="col-sm-6 col-sm-text-right">
                                    <div class="simple-article size-3 col-xs-b5">AVAILABLE: <span class="grey"> IN
                                            STOCK</span>
                                    </div>
                                    <div class="simple-article size-3 col-xs-b5">Condition: <span
                                            class="grey Productcondition">Refurbished</span>
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
                                    <div class="h6 detail-data-title size-1">Quantity:</div>
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
                                    <a class="button size-2 style-2 block product-cart">
                                        <span class="button-wrapper">
                                            <span class="icon"><img src="assets/img/extra-img/icon-2.png" alt=""></span>
                                            <span class="text">add to cart</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="button-close"></div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<div class="footer-form-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-xs-b10 col-lg-b0">
                <div class="cell-view empty-space col-lg-b50">
                    <h3 class="h3 light">dont miss your chance</h3>
                </div>
            </div>
            <div class="col-lg-3 col-xs-b10 col-lg-b0">
                <!-- <div class="cell-view empty-space col-lg-b50">
                    <div class="simple-article size-3 light transparent">ONLY 200 PROMO CODES ON DISCOUNT!</div>
                </div> -->
            </div>
            <div class="col-lg-4">
                <div class="single-line-form">
                    <input class="simple-input light" type="text" value="" placeholder="Your email">
                    <div class="button size-2 style-1">
                        <span class="button-wrapper">
                            <span class="icon"><img src="assets/img/extra-img/icon-1.png" alt=""></span>
                            <span class="text">submit</span>
                        </span>
                        <input type="submit" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-sm-6 col-md-3 col-xs-b30 col-md-b0">
                    <img src="assets/img/extra-img/footer-logo.png" alt="" />
                    <div class="empty-space col-xs-b20"></div>
                    <div class="simple-article size-2 light fulltransparent">Subserve - Your Trusted Source for Cutting-Edge Data Storage Solutions. Empower your digital journey with reliable and innovative storage solutions from Subserve .</div>
                    <div class="empty-space col-xs-b20"></div>
                    <div class="follow">
                        <a class="entry" href="#"><i class="fa fa-facebook"></i></a>
                        <a class="entry" href="#"><i class="fa fa-twitter"></i></a>
                        <a class="entry" href="#"><i class="fa fa-linkedin"></i></a>
                        <a class="entry" href="#"><i class="fa fa-instagram"></i></a>
                        <a class="entry" href="#"><i class="fa fa-pinterest-p"></i></a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-xs-b30 col-md-b0">
                    <h6 class="h6 light">Quick links</h6>
                    <div class="empty-space col-xs-b20"></div>
                    <div class="footer-column-links">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="/">home</a>
                                <a href="about-us.php">about us</a>
                                <a href="#">our stores</a>
                                <a href="warranty.php">warranty</a>
                                <a href="#">delivery</a>
                                <a href="#">privacy policy</a>
                                <a href="/contact.php">contact</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="category/hard-drives">HARD DRIVES</a>
                                <a href="category/ssds">SSD</a>
                                <a href="category/memory-modules">Memory Modules</a>
                                <a href="category/motherboards">mOTHERBOARDS</a>
                                <a href="category/cpu">CPU</a>
                                <a href="category/server">server</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear visible-sm"></div>
                <div class="col-sm-6 col-md-3">
                    <h6 class="h6 light">Popular Categories</h6>
                    <div class="empty-space col-xs-b20"></div>
                    <div class="tags clearfix">

                        <a class="tag" href="category/hard-drives">HARD DRIVES</a>
                        <a class="tag" href="category/ssds">SSD</a>
                        <a class="tag" href="category/memory-modules">Memory Modules</a>
                        <a class="tag" href="category/motherboards">mOTHERBOARDS</a>
                        <a class="tag" href="category/cpu">CPU</a>
                        <a class="tag" href="category/server">server</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-xs-b30 col-sm-b0">
                    <h6 class="h6 light">some posts</h6>
                    <div class="empty-space col-xs-b20"></div>
                    <!--<div class="footer-contact"><i class="fa fa-map-marker" aria-hidden="true"></i> Address:-->
                    <!--    <a class="">Subserve-->
                    <!--        , 30 N Gould St Ste R Sheridan, WY 82801 USA</a></div>-->
                    <div class="footer-contact"><i class="fa fa-mobile" aria-hidden="true"></i> Phone: <a class="text-2"
                            href="tel:+44 121 630 3773">+44 121 630 3773</a></div>
                    <div class="footer-contact"><i class="fa f fa-envelope-o" aria-hidden="true"></i> Email:  <a class="text-lowercase text-2"
                            href="mailto:sales@subserve.co.uk" class="text-lowercase">sales@subserve.co.uk</a></div>
                    <div class="footer-contact"><i class="fa fa-clock-o" aria-hidden="true"></i> Time: <a>Open: Mon
                            - Sat / 9:00AM - 6:00PM</a></div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row">
                <div class="col-lg-8 col-xs-text-center col-lg-text-left col-xs-b20 col-lg-b0">
                    <div class="copyright">&copy; 2024 All rights reserved. Development by <a href=""
                            target="_blank">Subserve</a></div>

                </div>
                <div class="col-lg-4 col-xs-text-center col-lg-text-right">
                    <div class="footer-payment-icons">
                        <a class="entry"><img src="assets/img/extra-img/thumbnail-4.jpg" alt="" /></a>
                        <a class="entry"><img src="assets/img/extra-img/thumbnail-5.jpg" alt="" /></a>
                        <a class="entry"><img src="assets/img/extra-img/thumbnail-6.jpg" alt="" /></a>
                        <a class="entry"><img src="assets/img/extra-img/thumbnail-7.jpg" alt="" /></a>
                        <a class="entry"><img src="assets/img/extra-img/thumbnail-8.jpg" alt="" /></a>
                        <a class="entry"><img src="assets/img/extra-img/thumbnail-9.jpg" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>



<!--<script src="assets/js/jquery-2.2.4.min.js"></script>-->
<script src="assets/js/swiper.jquery.min.js"></script>
<script src="assets/js/global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- styled select -->
<script src="assets/js/jquery.sumoselect.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- counter -->
<script src="assets/js/jquery.classycountdown.js"></script>
<script src="assets/js/jquery.knob.js"></script>
<script src="assets/js/jquery.throttle.js"></script>
<!-- slick carousel -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


<!-- range slider -->
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
<!-- masonry -->
<script src="assets/js/isotope.pkgd.min.js"></script>


<!-- MAP -->
<!-- <script src="https://maps.googleapis.com/maps/api/js"></script>
<script src="assets/js/map.js"></script> -->

<!-- CONTACT -->
<script src="assets/js/contact.form.js"></script>

<script>
    $(document).ready(function () {
        var minVal = parseInt($('.min-price').text());
        var maxVal = parseInt($('.max-price').text());
        $("#prices-range").slider({
            range: true,
            min: minVal,
            max: maxVal,
            step: 5,
            values: [minVal, maxVal],
            slide: function (event, ui) {
                $('.min-price').text(ui.values[0]);
                $('.max-price').text(ui.values[1]);
            }
        });
    });
</script>

<script>
    $(window).load(function () {
        var $container = $('.grid').isotope({
            itemSelector: '.grid-item',
            masonry: {
                columnWidth: '.grid-sizer'
            }
        });
    });
</script>
<script>
    $('.product-categories-slide').slick({
      infinite: true,
      slidesToShow: 3,
      arrows: false,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
        breakpoint: 1000, // Updated breakpoint
        settings: {
            slidesToShow: 2,  // Show only 1 slide
            slidesToScroll: 2
        }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
</script>
<script>
    $(".prev-btn-slider").click(function () {
		$(".product-categories-slide").slick("slickPrev");
	});
	$(".next-btn-slider").click(function () {
		$(".product-categories-slide").slick("slickNext");
	});
</script>
<!--  Single Add Add To Car   -->
<script>
    $(document).ready(function () {
        // Attach click event to the open-popup links
        $('.open-popup').click(function () {
            // Get the JSON-encoded product details from the data-product attribute
            var productData = $(this).data('product');
            var productBrand = $(this).data('brand');
            var category = $(this).data('category');
            // Update the popup content with the product details
            updatePopupContent(productData, productBrand, category);

            // Show the popup
            $('.popup-view-cart').addClass('active');
        });
        $(document).on('click', '.open-popup', function () {
            // Get the JSON-encoded product details from the data-product attribute
            var productData = $(this).data('product');
            var productBrand = $(this).data('brand');
            var category = $(this).data('category');
            var product_slug = $(this).data('slug');
            console.log(productData);
            $("#product_slug").val();
            // Update the popup content with the product details
            updatePopupContent(productData, productBrand, category);

            // Show the popup
            $('.popup-view-cart').addClass('active');
        });
        // Function to update the popup content with product details
        function updatePopupContent(product, productBrand, category) {
            // Update hidden field values
            $(".ViewProductID").val(product.id);
            $(".ViewProductName").val(product.product_name);
            $(".ViewProductImg").val(product.image_url);
            $(".ViewCategoryName").val(category);
            $(".ViewProductPriceInc").val(product.purchase_price);
            $(".ViewProductPriceExc").val(product.sale_price);
            $(".ViewProductBrand").val(productBrand);
            $(".ViewProductCondition").val(product.condition);
            $(".ViewProductQuantity").val(1);

            $('.popup-view-cart .product-big-preview-entry').css('background-image', 'url("' + product.image_url +
                '")');
            $('.popup-view-cart .simple-article.size-3.grey.col-xs-b5').text(product.category_name);
            $('.popup-view-cart .h3.col-xs-b25').text(product.product_name);
            $('.popup-view-cart .simple-article.size-5.grey span.color').html('$' + '<span id="price_ex">' + product
                .purchase_price + '</span>' + ' (Exc. Vat) <br> $' + '<span id="price_in">' + product
                    .sale_price + '</span>' + ' (Inc. Vat)');
            $('.Productcondition').html(product.condition);
            $('.productBrand').html(productBrand);
            $('.partNo').html(product.part_no);
            $('.productDescription').html(product.description);
            $('.CategoryProduct').html(category);
            $('#cartCategoryName').html(category)
            // Update other content as needed
        }

        // Close the popup when the close button is clicked
        $('.button-close, .layer-close').click(function () {
            $('.popup-view-cart').removeClass('active');
        });

        // Close the popup when the close button is clicked
        $('#product-cart').click(function () {
            var ProductName = $("#cartProductName").text();
            var ProductPricein = $("#price_in").text();
            var ProductPriceex = $("#price_ex").text();
            var ProductImg = $("#pro-img").attr("src");
            var productQTY = $("#qty-product").text();

            // Create an object with the extracted values
            var productDetails = {
                name: ProductName,
                priceIn: ProductPricein,
                priceEx: ProductPriceex,
                imageUrl: ProductImg,
                quantity: productQTY
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
                    }, 1000); // 3000 milliseconds = 3 seconds
                },
                error: function (error) {
                    // Handle the error response
                    console.error("Error adding item to cart: " + error.responseText);
                }
            });
        });
        // Event listener for the "Remove" button
        $('.remove-from-cart').click(function () {
            var productId = $(this).data('product-id');
            Swal.fire({
                title: "Are you sure?",
                text: "You want to remove product from Cart?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Remove"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send an AJAX request to remove the product from the cart
                    $.ajax({
                        type: "POST",
                        url: "src/cart_handler.php", // Replace with the actual path to your backend script
                        data: {
                            action: "remove_from_cart",
                            productId: productId
                        },
                        dataType: "json",
                        success: function (response) {
                            // Handle the success response
                            Swal.fire({
                                title: "Deleted!",
                                text: "Product Removed from Cart!",
                                timer: 1000, // 3000 milliseconds = 3 seconds
                                icon: "success",
                                showConfirmButton: false // Hide the "OK" button
                            });

                            // Add a delay before reloading the page
                            setTimeout(function () {
                                // Reload the page after the delay
                                location.reload();
                            }, 1000); // 3000 milliseconds = 3 seconds
                        },
                        error: function (error) {
                            // Handle the error response
                            console.error("Error removing item from cart: " + error
                                .responseText);
                        }
                    });
                }
            });
        });
        // Event listener for the "+" and "-" buttons
        $('.quantity-select .plus, .quantity-select .minus').click(function () {
            var productId = $(this).data('product-id');
            var quantityElement = $(this).siblings('.number');
            var currentQuantity = parseInt(quantityElement.text());

            // Increment or decrement the quantity based on the button clicked
            var newQuantity = ($(this).hasClass('plus')) ? currentQuantity + 1 : Math.max(1,
                currentQuantity - 1);

            // Update the displayed quantity
            quantityElement.text(newQuantity);
            $(".ViewProductQuantity").val(newQuantity);
            // Send an AJAX request to update the quantity in the cart
            $.ajax({
                type: "POST",
                url: "src/cart_handler.php", // Replace with the actual path to your backend script
                data: {
                    action: "update_quantity",
                    productId: productId,
                    quantity: newQuantity
                },
                dataType: "json",
                success: function (response) {
                    // Handle the success response
                    console.log(response.message);
                    location.reload();
                },
                error: function (error) {
                    // Handle the error response
                    console.error("Error updating quantity: " + error.responseText);
                }
            });
        });

    });
</script>

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

<!-- Popup Add To Cart -->
<script>
    $(document).ready(function () {
        $('.product-cart').click(function () {
            let ProductID = $(".ViewProductID").val();
            let ProductName = $(".ViewProductName").val();
            let ProductPricein = $(".ViewProductPriceInc").val();
            let ProductPriceex = $(".ViewProductPriceExc").val();
            let ProductImg = $(".ViewProductImg").val();
            let ProductCondition = $(".ViewProductCondition").val();
            let productQTY = $(".ViewProductQuantity").val();

            // Create an object with the extracted values
            let productDetails = {
                name: ProductName,
                priceIn: ProductPricein,
                priceEx: ProductPriceex,
                imageUrl: ProductImg,
                quantity: productQTY
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

<!-- Fetch  Product By Brand -->
<script>
    $(document).ready(function () {
        updateProducts();
        $('.brand-checkbox').change(function () {
            $("#update_products").html('<div class="loader"></div>');
            updateProducts();
        });

        // Function to make AJAX request and update products
        function updateProducts() {
            // Get selected brand IDs
            var selectedBrands = [];
            $('.brand-checkbox:checked').each(function () {
                selectedBrands.push($(this).val());
            });

            // Get the category ID directly from your logic
            var categoryId = $("#Input_Category_ID")
                .val(); // Replace this with your logic to obtain the category ID
            var categoryName = $("#Input_Category_Name").val();
            var categorySlug = $("#Input_Category_Slug").val();
            var cpage = $("#Input_Category_cpage").val();
            // Make AJAX request
            $.ajax({
                url: 'src/ajax_handler.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'get_products_by_brand',
                    category_id: categoryId,
                    category_name: categoryName,
                    categorySlug: categorySlug,
                    cpage: cpage,
                    selected_brands: selectedBrands
                },
                success: function (data) {
                    if (data.status === 'done') {
                        $("#update_products").html(data.message);
                        console.log("Products loaded successfully");
                        // Additional logic to update product cards if needed
                        // updateProductCards(data);
                    } else {
                        $("#update_products").html("Error: " + data.message);
                        console.error('Error:', data.message);
                    }
                },
                error: function (error) {
                    $("#update_products").html("Error: " + error.statusText);
                    console.error('AJAX Error:', error);
                }
            });
        }

        // Function to update product cards
        function updateProductCards(products) {
            var productsContainer = $('.products-wrapper');
            productsContainer.empty(); // Clear existing products

            // Loop through the products and append them to the container
            $.each(products, function (index, product) {
                // Convert the product_data object to a JSON string

                var productDataString = JSON.stringify(product.product_data);
                // Replace special characters with their HTML entity equivalents
                productDataString = productDataString.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(
                    />/g, '&gt;').replace(/"/g, '&quot;');
                var productCard = `
                    <div class="col-sm-4">
                        <form class="AddToCartForm">
                            <input type="hidden" name="TicProductID" class="TicProductID" value="${product.id}">
                            <input type="hidden" name="TicProductName" class="TicProductName" value="${product.product_name}">
                            <input type="hidden" name="TicCategoryName" class="TicCategoryName" value="${product, category_id}">
                            <input type="hidden" name="TicProductImg" class="TicProductImg" value="${product.image_url}">
                            <input type="hidden" name="TicProductPriceInc" class="TicProductPriceInc" value="${product.sale_price}"> 
                            <input type="hidden" name="TicProductPriceExc" class="TicProductPriceExc" value="${product.current_price}">
                            <input type="hidden" name="TicProductBrand" class="TicProductBrand" value="${product.brand_id}">
                            <input type="hidden" name="TicProductCondition" class="TicProductCondition" value="${product.condition}">
                            <input type="hidden" name="TicProductQuantity" class="TicProductQuantity" value="1">
                            <input type="hidden" name="TicProductSlug" class="TicProductSlug" value="${product.slug}">

                            <div class="product-shortcode text-center style-1">
                                <div class="preview">
                                    <img src="${product.image_url}" alt="Product Image">                                    
                                </div>
                                <div class="product-item-content">
                                    <div cl ass="h6 product-item-name animate-to-green">
                                        <a href="${product.product_url}">${product.product_name}</a>
                                    </div>
                                    <div class="simple-article product-item-price size-4">
                                        <span class="price-1 color">$${product.sale_price} (Exc. Vat) </span>
                                        <span class="price-2 color">$${product.current_price} (Inc. Vat) </span>
                                    </div>
                                    <div class="icons">
                                        <a class="entry"><i class="fa fa-check AddToCartTic" aria-hidden="true"></i></a>
                                        <a class="entry open-popup" data-rel="3" data-product='${productDataString.replace(/'/g, "&apos;")}' data-brand="${$ProductBrand_name}" . '>
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a class="entry"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                `;


                productsContainer.append(productCard);
            });
        }


        // Example usage for changing pages
        $(document).on('click', '.pagination', function () {
            var page = $(this).data('page');
            loadProductsByBrand(page);
        });
    });
</script>

<!-- Checkout Form 
<div class="loader" style="display:none;"></div>
 var loader = $('.loader');
 loader.fadeIn();
 loader.fadeOut();
-->

<!-- Tabs -->
<script>
    $(document).ready(function () {
        $('.tabulation-toggle a').on('click', function (e) {
            e.preventDefault();

            // Remove 'active' class from all tabs
            $('.tabulation-toggle a').removeClass('active');

            // Add 'active' class to the clicked tab
            $(this).addClass('active');

            // Hide all tab entries
            $('.tab-entry').removeClass('visible');

            // Show the corresponding tab entry
            var categoryId = $(this).data('category-id');
            $('.tab-entry[data-category-id="' + categoryId + '"]').addClass('visible');
        });

        // Show the default tab (you might customize this based on your requirements)
        $('.tabulation-toggle a:first').trigger('click');
    });
</script>
<!-- Search Form -->
<script>
    $(document).ready(function () {
        // Select search forms by class
        const searchForms = $(".search-form");

        searchForms.each(function () {
            const searchForm = $(this);
            const searchInput = searchForm.find(".search-input");
            const searchDropdown = searchForm.find(".search-dropdown-menu");
            const searchResultsList = searchForm.find(".search-results");

            searchInput.on("input", function () {
                const inputValue = searchInput.val().trim();

                if (inputValue !== "") {
                    $.ajax({
                        url: 'src/search_handler.php',
                        type: 'POST',
                        data: {
                            search: inputValue
                        },
                        success: function (results) {
                            updateSearchResults(results);
                        },
                        error: function () {
                            console.error("Error in AJAX request");
                        }
                    });
                } else {
                    searchDropdown.hide();
                }
            });

            $(document).on("click", function (event) {
                const isClickInside = searchInput.is(event.target) || searchDropdown.has(event
                    .target).length > 0;

                if (!isClickInside) {
                    searchDropdown.hide();
                }
            });

            function updateSearchResults(results) {
                searchResultsList.empty();

                if (Array.isArray(results) && results.length > 0) {
                    results.forEach((result) => {
                        let listItem = $("<li>").addClass("product");

                        if (result.type === "category") {
                            listItem.html(
                                `<a class="simple-link" href="category/${result.slug}">
                                    <img height="50px" width="50px" src="assets/images/${result.img}">
                                    <span>${result.name}</span>
                                </a>`
                            );
                        } else {
                            listItem.html(
                                `<a class="simple-link" href="product/${result.slug}">
                                    <img height="50px" width="50px" src="${result.img}">
                                    <span>${result.name}</span>
                                </a>`
                            );
                        }
                       
                        searchResultsList.append(listItem);
                    });

                    searchDropdown.show();
                } else {
                    searchDropdown.hide();
                }
            }
        });
    });
     
</script>
<!-- Login -->
<script>
    $(document).ready(function () {
        $("#loginBtn").click(function () {
            let email = $("#email").val();
            let password = $("#password").val();
            let responseContainer = $("#login-response");

            $.ajax({
                type: "POST",
                url: "src/login_handler.php",
                data: {
                    email: email,
                    password: password
                },
                success: function (response) {
                    if (response.status === "success") {
                        responseContainer.html(
                            `<div class="empty-space col-xs-b10 col-sm-b20"></div><span class='success-message'>${response.message}</span>`
                        );

                        // Redirect to another page after a short delay
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        responseContainer.html(
                            `<div class="empty-space col-xs-b10 col-sm-b20"></div><span class='error-message'>${response.message}</span>`
                        );
                    }
                },
                error: function () {
                    responseContainer.html(
                        "<span class='error-message'>An error occurred. Please try again later.</span>"
                    );
                }
            });
        });
    });
</script>
<!-- Register  -->
<script>
    $(document).ready(function () {
        // Event delegation for dynamically generated form
        $(document).on('click', '#registerBtn', function (event) {
            event.preventDefault();
            $(".error-message").remove()


            // Perform client-side validation (you may add more validation as needed)
            let emptyFields = [];
            $(".register-name, .register-email, .register-password").each(function () {
                let field = $(this);
                if (field.val() === "") {
                    emptyFields.push(field);
                }
            });

            emptyFields.forEach(function (field) {
                let fieldName = field.attr("name").replace(/_/g, ' ').replace(/\w\S*/g, function (txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); });
                // Append the error message after the field
                field.after("<span class='error-message simple-link'>" + fieldName + " is required</span>");
            });

            // Check if Password and Confirm Password match
            let passwordField = $(".register-password");
            let confirmPasswordField = $(".register-confirm-password");
            let passwordValue = passwordField.val();
            let confirmPasswordValue = confirmPasswordField.val();

            if (passwordValue != confirmPasswordValue) {
                // Remove the previous error message for confirmPasswordField
                confirmPasswordField.next(".error-message").remove();
                // Append the new error message after the confirmPasswordField
                confirmPasswordField.after("<span class='error-message simple-link'>Password and Confirm Password do not match</span>");
            }

            // Check if email format is valid only if the email is not empty
            let emailField = $("input[name='email']");
            let emailValue = emailField.val().trim();
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailValue != "" && !emailRegex.test(emailValue)) {
                // Append the error message after the emailField
                emailField.closest(".register-email").after("<span class='error-message simple-link'>Invalid email format</span>");
            }

            let errorMessages = $(".error-message");
            if (errorMessages.length > 0) {
                return;
            } else {
                let formData = $("#registrationForm").serialize();

                // Send the AJAX request
                $.ajax({
                    type: "POST",
                    url: "src/register_handler.php",
                    data: formData,
                    success: function (response) {
                        if (response.status === "success") {
                            Swal.fire({
                                title: 'Registration Successful!',
                                text: 'Thank You for registering with us.',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            })
                                // .then(() => {
                                //     // Redirect to the login page after the delay
                                //     window.location.reload();
                                // });
                        } else {
                            // Check if response.message is defined
                            var errorMessage = response.message ? response.message : "An error occurred. Please try again later.";
                            // Append the error message in the #register-response container
                            $("#register-response").html("<span class='error-message simple-link'>" + errorMessage + "</span>");
                        }
                    },
                    error: function () {
                        // Append a generic error message in the #register-response container
                        $("#register-response").html("<span class='error-message simple-link'>An error occurred. Please try again later.</span>");
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#requestPassword").on("click", function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Get the email entered by the user
            var userEmail = $("#emailUser").val();

            // Perform AJAX request
            $.ajax({
                type: "POST",
                url: "src/requestPassword.php", // Replace with the actual path to your PHP script
                data: {
                    accountEmail: userEmail
                },
                success: function(response) {
                    // Parse the JSON response
                    var jsonResponse = $.parseJSON(response);

                    // Display the response in the 'status' div
                    $("#status").html('<div class="' + jsonResponse.class + '">' + jsonResponse.message + '</div>');
                },
                error: function(error) {
                    console.error("Error: ", error);
                }
            });
        });
    });
</script>
<script>
    jQuery(function($) {
  // Add en remove class on menu item hover  
  $('.big-nav > ul > li').mouseover(function(){
    $(this).addClass('show').siblings().removeClass('show');
  });
  
  // Get the minimum height the big-nav elemtn
  var min_height = 50;
  $('.big-nav > ul > li > ul').each(function(){
    var this_height = $(this).outerHeight();
    if (this_height > min_height) min_height = this_height;
  });
  $('.big-nav > ul, .nav .big-nav > ul > li > ul').css('min-height', min_height + 'px');
  
});

</script>
<script>
    $(document).ready(function() {
       $('.menu-toggle2').click(function() {
        var mobileNav = $('.mobile-nav');
        var htmlElement = $('html');

        $(this).toggleClass('menu-open'); // Toggle the class for showing the cross icon
        mobileNav.toggleClass('canvas-opened');
        htmlElement.css('overflow', htmlElement.css('overflow') === 'hidden' ? '' : 'hidden');
        });
        $(".has-submenu").click(function() {
            $(this).find(".submenu").toggleClass("open");
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#reset_password_btn").on("click", function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Get the email entered by the user
            var userPass = $("#password_user").val();
            var userConfirmPass = $("#confirm_password_user").val();
            var userToken = $("#userToken").val();
            
            if(userPass === userConfirmPass){
                    // Perform AJAX request
                    $.ajax({
                        type: "POST",
                        url: "src/updatePassword.php", 
                        data: {
                            userPassword: userPass,
                            tokenUser: userToken
                        },
                        success: function(response) {
                            // Parse the JSON response
                            //var jsonResponse = $.parseJSON(response);
        
                            $("#status").html('<div class="alert alert-success" style="margin-top:10px;">' + response + '</div>');
                        },
                        error: function(error) {
                            console.error("Error: ", error);
                        }
                    });
            } else{
                $("#status").html('<div class="error-alert">Password and confirm password do not match.</div>');
            }
        });
    });
</script>