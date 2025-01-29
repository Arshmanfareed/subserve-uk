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
    <!-- CART VIEW  -->
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
                                    <div class="simple-article size-5 grey">
                                            <span class="PriceIn" id="priceInVal">£120.91</span></div>
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
                                <span class="productDescription">X5240A - Sun 36.4GB 10000RPM Ultra-160 SCSI LVD
                                Hot-Pluggable 80-Pin 3.5-inch Hard Drive for Sun Fire and Blade Server.</span>
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
    <!-- FORM VIEW  -->
    <div class="popup-content popup-contact-form" data-rel="4">
        <div class="layer-close"></div>
        <div class="popup-container size-2">
            <div class="popup-align">
                <h3 class="h3 text-center col-xs-b25">have a questions?</h3>
                <div class="empty-space col-xs-b30"></div>
                <div class="row">
                    <div class="col-md-12 ">
                         <form class="contact-form">
                            <div class="row contact__form pt-30">
                                <div class="col-xxl-12">
                                    <div class="section__head mb-30">
                                        <div class="section__title">
                                            <h4 class="h4">WE JUST NEED A FEW DETAILS</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6 col-sm-12">
                                    <div class="contact__input">
                                        <span class="">Full Name *</span>
                                        <input type="text" class="simple-input col-xs-b20" id="fullName" name="fullName"
                                            placeholder="e.g. John Doe" required="">
                                        <p class="error-contact-form" id="fullNameError"></p>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6 col-sm-12">
                                    <div class="contact__input">
                                        <span class="">Email *</span>
                                        <input type="email" class="simple-input col-xs-b20" id="email" placeholder="e.g. john.Doe@company.com"
                                            name="email" required="">
                                        <p class="error-contact-form" id="emailError"></p>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6 col-sm-12">
                                    <div class="contact__input">
                                        <span class="">Organisation</span>
                                        <input type="text" class="simple-input col-xs-b20" id="companyName" placeholder="Your company/organisation"
                                            name="companyName" required="">
                                        <p class="error-contact-form" id="companyNameError"></p>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6 col-sm-12">
                                    <div class="contact__input">
                                        <span class="">Phone Number</span>
                                        <input type="tel" class="simple-input col-xs-b20" id="phone-quote" placeholder="e.g. 07800112233" name="phone"
                                            required="">
                                        <p class="error-contact-form" id="phoneError"></p>
                                    </div>
                                </div>
                           
                                <div class="col-xxl-12">
                                    <div class="section__head mt-20 mb-30">
                                        <div class="section__title">
                                            <h4 class="h4">TELL US WHICH DEVICES YOU HAVE</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 ">
                                    <div class="bulk-upload-file-wrap">
                                        <div class="bulk-upload-content-wrapper">
                                            <p class="bulk-upload-para-1">Preferred method - upload a list of
                                                devices.
                                                <a rel="noreferrer nofollow" target="_blank"
                                                    href="/downloads/compare-and-recycle-bulk-order-template-v3.xlsx">Download
                                                    template</a> (Excel format)
                                            </p>
                                            <p class="bulk-upload-para-2">Accepted files types are .txt, .csv, .xls,
                                                .xlsx,
                                                .xml, .doc and .docx. Maximum file size 10MB.</p>
                                        </div>
                                        <div class="bulk-upload-button-wrapper">
                                            <input class="bulk-file-box-wrap" type="file" id="fileUpload"
                                                name="fileUpload" accept=".xls,.xlsx,.csv,.doc,.docx,.ods,.odt"
                                                max-size="3145728">
                                            <label class="bulk-upload-file" for="fileUpload"><i class="fal fa-upload"
                                                    style="margin-right:8px"></i>Upload
                                                File</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-12 col-sm-12 mt-20">
                                    <div class="contact__input">
                                        <span class="">Please include the manufacturer, model, quantity, storage capacity,
                                            network lock and condition of your devices.</span>
                                        <textarea class="simple-input col-xs-b20" id="moreInfo" name="moreInfo"
                                            placeholder="You can type your list of devices here or add any additional notes."
                                            rows="8" cols="50"></textarea>
                                    </div>
                                </div>
                              
                                <div class="col-xxl-12 col-md-12 col-sm-12 bulk_contact_button">
                                    <div class="button size-2 style-3">
                                        <span class="button-wrapper">
                                            <span class="icon"><img src="img/icon-4.png" alt=""></span>
                                            <span class="text">send message</span>
                                        </span>
                                        <input type="submit">
                                    </div>
                                    <!-- <div class="contact__btn">
                                        <button class="g-recaptcha t-y-btn"
                                            data-sitekey="6LdWTyApAAAAAHdtov8Kil2fw8fx5h-syRgS2RBO"
                                            data-callback="onBulkBuyingSubmit" data-action="submit">Submit
                                            Details</button>
                                    </div> -->
                                </div>

                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <div class="footer-wrapper">
        <div class="content-margins">
            <div class="row">
                <div class="col-md-2">
                    <div class="other-footer-list">
                        <div class="lable-header">
                        <h4>Top Picks</h4>
                    </div>
                    <div class="footer-nav-list-wrapper">
                        <div class="footer-nav-list">
                        <ul>
                            <li><a href='/category/network-adapters'>Network Adapters</a></li>
                            <li><a href='/category/transceiver'>Transceiver</a></li>
                            <li><a href='/category/routers'>Routers</a></li>
                            <li><a href='/category/switches'>Switches</a></li>
                            <li><a href='/category/wireless-networking'>Wireless Networking</a></li>
                            <li><a href='/category/controllers'>Controllers</a></li>
                            <li><a href='/category/cards'>Cards</a></li>
                        </ul>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="other-footer-list">
                        <div class="lable-header">
                        <h4>Hot Selling</h4>
                    </div>
                    <div class="footer-nav-list">
                        <ul>
                            <li><a href='/category/motherboards'>Motherboards</a></li>
                            <li><a href='/category/server-motherboards'>Server Motherboards</a></li>
                            <li><a href='/category/gaming-motherboards'>Gaming Motherboards</a></li>
                            <li><a href='/category/desktop-motherboards'>Desktop Motherboards</a></li>
                            <li><a href='/category/laptop-motherboards'>Laptop Motherboards</a></li>
                            <li><a href='/category/server-and-workstation-hard-drives'>Workstation Motherboards</a></li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="other-footer-list">
                        <div class="lable-header">
                        <h4>New To List</h4>
                    </div>
                    <div class="footer-nav-list">
                        <ul>
                            <li><a href='/category/cisco-server'>Cisco Server</a></li>
                            <li><a href='/category/dell-server'>Dell Server</a></li>
                            <li><a href='/category/hp-server'>HP Server</a></li>
                            <li><a href='/category/emc-server'>EMC Server</a></li>
                            <li><a href='/category/ibm-server'>IBM Server</a></li>
                            <li><a href='/category/lenovo-server'>Lenovo Server</a></li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="other-footer-list">
                        <div class="lable-header">
                            <h4>Info</h4>
                        </div>
                    </div>
                    <div class="footer-main-col">
                        <!-- <img src="/assets/img/f-logo.png"> -->
                        <p>Subserve - Your Trusted Source for Cutting-Edge Data Storage Solutions. Empower your digital journey with reliable and innovative storage solutions from Subserve .</p>
                        <span>PHONE: <a href="tel: +44 121 630 3773"> +44 121 630 3773</a></span>
                        <span>EMAIL: <a href="mailto:sales@subserve.co.uk">sales@subserve.co.uk</a></span>
                    </div>
                </div>                
                <div class="col-md-3">
                    <div class="other-footer-list">
                        <div class="lable-header">
                        <h4>Subscribe to our Newsletter</h4>
                    </div>
                    <div class="newsletter-wrapper">
                        <p>Get the latest updates on new products and upcoming sales</p>
                        <div class="newsletter-form">
                            <input type="text" placeholder="Enter Your Email..."/>
                            <button>Sign Up</button>
                        </div>
                        <div class="folow">
                            <span>Follow Us</span>
                            <ul>
                                <li><i class="fa-brands fa-facebook"></i></li>
                                <li><i class="fa-brands fa-pinterest-p"></i></li>
                                <li><i class="fa-brands fa-linkedin"></i></li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="footer-nav-list resources-footer">
                        <ul>
                            <li><a href='/about-us.php'>About Subserve</a></li>
                            <li><a href='/contact.php'>Contact Us</a></li>
                            <br>
                            <li><a ><h6>Follow Us :</h6></a></li>
                            <li>
                                <ul class="footer-logos">
                                    <li><a href="https://m.facebook.com/p/Subserve-LTD-100072540512700/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="https://uk.linkedin.com/company/subserve-ltd"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                   
                                </ul>
                            </li>
                            <li><img src="/assets/img/extra-img/trustpilot-logo.png" class="img-fluid"></li>
                        </ul>
                    </div> -->
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="newsletter-wrapper">
                        <div class="newsletter-content">
                            <h5>Let’s stay in touch</h5>
                            <span>We value your privacy and promise to deliver content matters to you.</span>    
                        </div>
                        <div class="newsletter-form">
                            <input type="text" placeholder="Enter Your Email..."/>
                            <button>Sign Up</button>
                        </div>
                    </div>
                    
                </div>
            </div> -->
        </div>
    </div>
    <!-- <div class="footer-middler">
        <div class="row">
            <div class="col-md-12">
                <div class="mid-nav">
                    <ul>
                        <li><a href="/privacy-policy.php">Privacy Policy</a></li>
                        <li><a href="/return-policy.php">Return Policy</a></li>
                        <li><a href="/shipment-policy.php">Shipment Policy</a></li>
                        <li><a href="/warranty.php">Warranty</a></li>
                        <li><a href="/discount.php">Discounts</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->
    <div class="footer-bottom">
        <span>© 2024 All rights reserved. Development by <a href="/">Subserve</a></span>
    </div>
</footer>
</div>



<script src="assets/js/jquery-2.2.4.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<script src="assets/js/swiper.jquery.min.js"></script>
<script src="assets/js/global.js"></script>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- styled select -->
<script src="assets/js/jquery.sumoselect.min.js"></script>
<script async src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- counter -->
<script async src="assets/js/jquery.classycountdown.js"></script>
<script async src="assets/js/jquery.knob.js"></script>
<script async src="assets/js/jquery.throttle.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- slick carousel -->
<script  type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


<!-- range slider -->
<script async src="assets/js/jquery-ui.min.js"></script>
<script async src="assets/js/jquery.ui.touch-punch.min.js"></script>
<!-- masonry -->
<script async src="assets/js/isotope.pkgd.min.js"></script>


<script>
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    navText: [
                '<i class="fa-solid fa-chevron-left"></i>', // Left icon
                '<i class="fa-solid fa-chevron-right"></i>' // Right icon
            ],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
    $(document).ready(function () {
        $('.search-input').on('keyup keypress', function(event) {
  var key = event.keyCode || event.which;
  if (key === 13) { 
    event.preventDefault();
    return false;
  }
});
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
      lazyLoad: 'ondemand',
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
    $(".prev-btn-slider").click(function () {
		$(".product-categories-slide").slick("slickPrev");
	});
	$(".next-btn-slider").click(function () {
		$(".product-categories-slide").slick("slickNext");
	});
</script>
<script>
    $('.features-slide').slick({
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
    $(".feature-prev-btn-slider").click(function () {
		$(".features-slide").slick("slickPrev");
	});
	$(".feature-next-btn-slider").click(function () {
		$(".features-slide").slick("slickNext");
	});
</script>
<script>
    $('.partners-slide').slick({
      infinite: true,
      slidesToShow: 5,
      arrows: false,
      slidesToScroll: 3,
      autoplay: true,
      autoplaySpeed: 2000,
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
            slidesToShow: 3,  // Show only 1 slide
            slidesToScroll: 3
        }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
    $(".partner-prev-btn-slider").click(function () {
		$(".partners-slide").slick("slickPrev");
	});
	$(".partner-next-btn-slider").click(function () {
		$(".partners-slide").slick("slickNext");
	});
</script>
<!--  Single Add Add To Car   -->
<script>
    $(document).ready(function () {
    //$(window).load(function() {
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
            $(".ViewProductPriceExc").val(product.purchase_pric);
            $(".ViewProductBrand").val(productBrand);
            $(".ViewProductCondition").val(product.condition);
            $(".ViewProductQuantity").val(1);

            $('.popup-view-cart .product-big-preview-entry').css('background-image', 'url("' + product.image_url +
                '")');
            $('.popup-view-cart .simple-article.size-3.grey.col-xs-b5').text(product.category_name);
            $('.popup-view-cart .h3.col-xs-b25').text(product.product_name);
            //$('.popup-view-cart .simple-article.size-5.grey span.color').html('£' + '<span id="priceInVal">' + product.sale_price + '</span>');
            $("#priceInVal").html("£" + ((product.sale_price * 0.8)).toFixed(2));
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
           // quantityElement.text(newQuantity);
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
        $('.brand-checkbox').change(function () {
            $("#update_products").html('<div class="loader"></div>');
            updateProducts();
        });

        // Function to make AJAX request and update products
        // Function to make AJAX request and update products
        function updateProducts() {
            var cat_slug = $("#cat_slug").val();
            var Input_Category_ID = $("#Input_Category_ID").val();
            var Input_Category_cpage = $("#prev-page-value").val();
            var selectedBrands = [];
            $(".brand-checkbox:checked").each(function () {
                selectedBrands.push($(this).val());
            });
            // Make an AJAX request to fetch products and pagination links
            $.ajax({
                type: 'POST',
                url: 'http://localhost/subserve/src/brands-handler.php',
                data: {
                    cslug: cat_slug, // Assuming cat_slug is defined somewhere
                    page: Input_Category_cpage,
                    category_id: Input_Category_ID,
                    selected_brands: selectedBrands
                },
                success: function (response) {
                    // Replace the content of the product container with the fetched data
                    $('#update_products').html(response);
                },
                error: function (xhr, status, error) {
                    // Handle error if needed
                    console.log('Error loading products:', status, error);
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('.feature-link').on('click', function () {
            var Input_Category_ID = $("#Input_Category_ID").val();
            var Input_Category_cpage = $("#prev-page-value").val();
            var category = $(this).data('category');
            var cat_slug = $(this).data('slug');
            localStorage.setItem('CatBrand', category);
            localStorage.setItem('CatSlug', cat_slug);
            localStorage.setItem('CatID', Input_Category_ID);
            localStorage.setItem('CatPage', Input_Category_cpage);
        });
    });
</script>

<!-- Search Form -->
<script >
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
<script >
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
                        }, 1000);
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
<script >
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
                            // Redirect to another page after a short delay
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
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

<script >
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
        // Add and remove class on menu item hover for all li except the last one
        $('.big-nav > ul > li:not(:last-child)').mouseover(function(){
            $(this).addClass('show').siblings().removeClass('show');
        });

        // Get the minimum height for the big-nav element
        var min_height = 50;
        $('.big-nav > ul > li > ul').each(function(){
            var this_height = $(this).outerHeight();
            if (this_height > min_height) min_height = this_height;
        });
        $('.big-nav > ul, .nav .big-nav > ul > li > ul').css('min-height', min_height + 'px');
    });
</script>


<script >
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

<script >
        $(document).on('click', '.prev-page', function(e) {
            e.preventDefault();
            $("#update_products").html('<div class="loader"></div>');
            pagechange();
            // Additional code for handling the click event
        });
        function pagechange()
        {
        var cat_slug = $("#cat_slug").val();
        var Input_Category_ID = $("#Input_Category_ID").val();
        var Input_Category_cpage = $("#prev-page-value").val();

        // Get the selected brands
        var selectedBrands = [];
        $(".brand-checkbox:checked").each(function () {
            selectedBrands.push($(this).val());
        });
            // Make an AJAX request to fetch products and pagination links
        $.ajax({
            type: 'POST',
            url: 'src/pagination.php',
            data: {
                cslug: cat_slug,
                page: Input_Category_cpage,
                category_id: Input_Category_ID,
                selected_brands: selectedBrands
            },
            success: function (response) {
                // Replace the content of the product container with the fetched data
                $('#update_products').html(response);
            },
            error: function (xhr, status, error) {
                // Handle error if needed
                console.log('Error loading products:', status, error);
            }
        });
        }
</script>
<script >
$(document).on('click', '#coming-page', function(e) {
    e.preventDefault();
    $("#update_products").html('<div class="loader"></div>');
    var Input_Category_cpage = $(this).data('page'); // Move this line here
    pagechange(Input_Category_cpage); // Pass it as an argument to the function
});
$(document).ready(function() {
  $('#command').keydown(function(e) {
var value= $('#command').val();
    if (e.which === 13) {
     
        window.location = "https://subserve-usa.com/search-result.php?search="+value;
      
     
    }
  });
});
function pagechange(Input_Category_cpage) {
    var cat_slug = $("#cat_slug").val();
    var Input_Category_ID = $("#Input_Category_ID").val();

    // Get the selected brands
    var selectedBrands = [];
    $(".brand-checkbox:checked").each(function() {
        selectedBrands.push($(this).val());
    });

    // Make an AJAX request to fetch products and pagination links
    $.ajax({
        type: 'POST',
        url: 'src/pagination.php',
        data: {
            cslug: cat_slug,
            category_id: Input_Category_ID,
            page: Input_Category_cpage,
            selected_brands: selectedBrands
        },
        success: function(response) {
            // Replace the content of the product container with the fetched data
            $('#update_products').html(response);
        },
        error: function(xhr, status, error) {
            // Handle error if needed
            console.log('Error loading products:', status, error);
        }
    });
}

$(window).load(function(){
   // Close the popup when the close button is clicked
        $('#product-cart').click(function () {
            console.log("Added to cart");
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
                url: "http://localhost/subserve/src/cart_handler.php", // Replace with the actual path to your backend script
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
                        window.location.href = 'http://localhost/subserve/cart.php';
                    }, 1000); // 3000 milliseconds = 3 seconds
                },
                error: function (error) {
                    // Handle the error response
                    console.error("Error adding item to cart: " + error.responseText);
                }
            });
        }); 
});
    
      
</script>