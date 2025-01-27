<?php
    // Session has not started
    session_start();
// Function to calculate the total price for an item
function calculateTotal($quantity, $price)
{
    return $quantity * str_replace("$", "", $price);
}
// Function to calculate the total quantity of items in the cart
function calculateTotalQuantity($cart)
{
    $totalQuantity = 0;
    foreach ($cart as $item) {
        $totalQuantity += $item['quantity'];
    }
    return $totalQuantity;
}

// Function to calculate the cart subtotal
function calculateSubtotal($cart)
{
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += calculateTotal($item['quantity'], $item['priceIn']);
    }
    return $subtotal;
}

// Function to calculate shipping and handling (assumed free in this example)
function calculateShipping()
{
    return 0; // Assuming free shipping
}

// Function to calculate the order total
function calculateOrderTotal($cart)
{
    $subtotal = calculateSubtotal($cart);
    $shipping = calculateShipping();
    return $subtotal + $shipping;
}
function displayEmptyCartMessage()
{
    echo '<tr><td colspan="6">Your cart is empty</td></tr>';
}
?>
<base href="https://subserve.co.uk/">


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, minimal-ui" />

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Questrial|Raleway:700,900" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/bootstrap.extension.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

    <link href="assets/css/swiper.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/sumoselect.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Slick slider -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <link rel="shortcut icon" href="assets/img/extra-img/favicon.png" />
    <title>SubServe</title>

</head>

<body>

    <!-- LOADER -->
    <div id="loader-wrapper"></div>

    <div id="content-block">
        <!-- HEADER -->
        <header>
            <!--<div class="header-topper hidden-xs hidden-sm">-->
            <!--    <div class="content-margins">-->
            <!--        <div class="row">-->
            <!--            <div class="col-md-4">-->
            <!--                <div class="contact-info-top">-->
            <!--                    <span>Contact: <a href="tel:+1 (0)888 382 1386">+1 (0)888 382 1386</a></span>-->
            <!--                     <span>Email: <a href="mailto:sales@subserve-usa.com">sales@subserve-usa.com</a></span>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="col-md-8">-->
            <!--                <div class="topper-login-register">-->
            <!--                     <div class="entry"><a class="open-popup" data-rel="1"><b>login</b></a>&nbsp; or &nbsp;<a class="open-popup" data-rel="2"><b>register</b></a></div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>    -->
            <!--    </div>-->
            <!--</div>-->
             <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
<div class="header-top">
                <div class="content-margins">
                    <div class="row">
                        <div class="col-sm-6 col-md-5  hidden-xs hidden-sm">
                            <div class="entry"><b>contact us:</b> <a class="text-2" href="tel:+44 121 630 3773" >+44 121 630 3773</a></div>
                            <div class="entry"><b>email:</b> <a class="text-lowercase text-2"
                                    href="mailto:sales@subserve.co.uk">sales@subserve.co.uk</a></div>
                        </div>
                        <div class="col-md-4  col-md-3  hidden-xs hidden-sm ">
                           
                            <div class="search-header">
                                <form class="search-form">
                                    <div class="search-submit">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <input type="submit">
                                    </div>
                                    <input class="simple-input style-1 search-input" type="text" value="" placeholder="Enter keyword">
                                    <div class="search-dropdown-menu" style="display: none;">
                                        <ul class="search-results" aria-label="search" role="listbox"></ul>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="col-sm-12 col-md-4 col-md-text-right">
                            
                            <?php
                            if (isset($_SESSION['user'])) {
                                ?>
                                 
                                <div class="entry language">
                                    <div class="title"><b>My Account</b></div>
                                    <div class="language-toggle header-toggle-animation">
                                         <a>Hello, <?php echo $_SESSION['user']['fname'] ?></a>
                                         <a href="logout.php">Logout</a>
                                    </div>
                                </div>
                       
                                <?php

                            } else {
                                ?>
                                <div class="entry"><a class="open-popup" data-rel="1"><b>login</b></a>&nbsp; or &nbsp;<a
                                        class="open-popup" data-rel="2"><b>register</b></a></div>
                                <?php
                            }


                            ?>


                            <div class="entry hidden-xs hidden-sm cart">
                                <a href="cart.php">
                                    <b class="hidden-xs">Your bag</b>
                                    <span class="cart-icon">
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        <span class="cart-label">
                                            <?php
                                            if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                                                echo calculateTotalQuantity($_SESSION["cart"]);
                                            } else {
                                                echo "0";
                                            }
                                            ?>
                                        </span>
                                    </span>
                                </a>
                                <div class="cart-toggle hidden-xs hidden-sm">
                                    <div class="cart-overflow">
                                        <?php
                                        // Check if the cart session variable is set
                                        if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                                            foreach ($_SESSION["cart"] as $key => $item) {
                                                // Replace these lines with actual data from your item
                                                $productName = $item['name'];
                                                $productPrice = $item['priceIn']; // Assuming 'priceIn' is the price key
                                                $quantity = $item['quantity'];
                                                $total = calculateTotal($quantity, $productPrice);
                                                echo '<div class="cart-entry clearfix">';
                                                echo '<a class="cart-entry-thumbnail" href="product/"><img height="78px" src="' . $item['imageUrl'] . '" alt="" /></a>';
                                                echo '<div class="cart-entry-description">';
                                                echo '<table>';
                                                echo '<tr>';
                                                echo '<td>';
                                                echo '<div class="h6"><a href="#">' . $productName . '</a></div>';
                                                echo '<div class="simple-article size-1">QUANTITY: ' . $quantity . '</div>';
                                                echo '</td>';
                                                echo '<td>';
                                                echo '<div class="simple-article size-3 grey">' . $productPrice . '</div>';
                                                echo '<div class="simple-article size-1">TOTAL: $' . number_format($total, 2) . '</div>';
                                                echo '</td>';
                                                echo '<td>';
                                                echo '<div class="button-close"></div>';
                                                echo '</td>';
                                                echo '</tr>';
                                                echo '</table>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        } else {
                                            echo '<p>Your cart is empty</p>';
                                        }
                                        ?>
                                    </div>
                                    <div class="empty-space col-xs-b40"></div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="cell-view empty-space col-xs-b50">
                                                <div class="simple-article size-5 grey">
                                                    <?php
                                                    if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                                                        echo "TOTAL $" . number_format(calculateSubtotal($_SESSION["cart"]), 2);
                                                    }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a class="button size-2 style-3" href="cart.php">
                                                <span class="button-wrapper">
                                                    <span class="icon"><img src="assets/img/extra-img/icon-4.png"
                                                            alt=""></span>
                                                    <span class="text">proceed to checkout</span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hamburger-icon" id="menu-closed">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--<div class="header-bottom hidden-lg">-->
            <!--    <div class="content-margins">-->
            <!--        <div class="row">-->
            <!--            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 text-right">-->
            <!--                <div class="search-header">-->
            <!--                    <form class="search-form">-->
            <!--                        <div class="search-submit">-->
            <!--                            <i class="fa fa-search" aria-hidden="true"></i>-->
            <!--                            <input type="submit">-->
            <!--                        </div>-->
            <!--                        <input class="simple-input style-1 search-input" type="text" value="" placeholder="Enter keyword">-->
            <!--                        <div class="search-dropdown-menu" style="display: none;">-->
            <!--                            <ul class="search-results" aria-label="search" role="listbox"></ul>-->
            <!--                        </div>-->
            <!--                    </form>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="header-bottom">
                <div class="content-margins">
                    <div class="row">
                        <div class="col-xs-5 col-sm-5 col-md-3 col-lg-2">
                            <a id="logo" href=""><img src="assets/img/extra-img/logo.png" alt="" /></a>
                        </div>
                        <div class="col-xs-7 col-sm-7 col-md-3 col-lg-10 text-right">
                            <div class="nav-wrapper">
                                <div class="nav-close-layer"></div>
                                <nav>
                                    <ul>
                                        <li class="active">
                                            <a href="">Home</a>
                                        </li>
                                        <!-- <li>
                                            <a href="">about us</a>
                                        </li>
                                        <li class="megamenu-wrapper">
                                            <a href="">products</a>
                                            <div class="menu-toggle"></div>
                                            <div class="megamenu">
                                                <div class="links">
                                                    <a class="active" href="">ALL cATEGORIES</a>
                                                    <a href=""> Hard Drives</a>
                                                    <a href=""> PROCESSORS</a>
                                                    <a href=""> ssd</a>
                                                    <a href=""> GRAPHIC CARD</a>
                                                    <a href="">MEMORY</a>
                                                    <a href=""> CPU</a>
                                                    <a href="">ROUTER</a>
                                                    <a href="">MOTHERBOARDS</a>
                                                </div>
                                                <div class="content">
                                                    <div class="row nopadding">
                                                        <div class="col-xs-6">
                                                            <div class="product-shortcode style-5">
                                                                <div class="product-label green">best price</div>
                                                                <div class="icons">
                                                                    <a class="entry"><i class="fa fa-check"
                                                                            aria-hidden="true"></i></a>
                                                                    <a class="entry open-popup" data-rel="3"><i
                                                                            class="fa fa-eye"
                                                                            aria-hidden="true"></i></a>
                                                                    <a class="entry"><i class="fa fa-heart-o"
                                                                            aria-hidden="true"></i></a>
                                                                </div>
                                                                <div class="preview">
                                                                    <div class="swiper-container" data-loop="1">
                                                                        <div class="swiper-button-prev style-1"></div>
                                                                        <div class="swiper-button-next style-1"></div>
                                                                        <div class="swiper-wrapper">
                                                                            <div class="swiper-slide">
                                                                                <img src="assets/img/products-img/seagate-hard-drives-2.webp"
                                                                                    alt="" />
                                                                            </div>
                                                                            <div class="swiper-slide">
                                                                                <img src="assets/img/products-img/seagate-hard-drives-2.webp"
                                                                                    alt="" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="content-animate">
                                                                    <div class="title">

                                                                        <div class="h6 animate-to-green"><a href="">SUN
                                                                                HARD DRIVES</a></div>
                                                                    </div>
                                                                    <div class="description">
                                                                        <div class="simple-article text size-2">Mollis
                                                                            nec consequat at In feugiat molestie tortor
                                                                            a malesuada</div>
                                                                    </div>
                                                                    <div class="price">
                                                                        <div class="simple-article size-4 dark">$630.00
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="preview-buttons">
                                                                    <div class="buttons-wrapper">
                                                                        <a class="button size-2 style-2" href="">
                                                                            <span class="button-wrapper">
                                                                                <span class="icon"><img
                                                                                        src="assets/img/extra-img/icon-1.png"
                                                                                        alt=""></span>
                                                                                <span class="text">Learn More</span>
                                                                            </span>
                                                                        </a>
                                                                        <a class="button size-2 style-3" href="#">
                                                                            <span class="button-wrapper">
                                                                                <span class="icon"><img
                                                                                        src="assets/img/extra-img/icon-3.png"
                                                                                        alt=""></span>
                                                                                <span class="text">Add To Cart</span>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <div class="product-shortcode style-5">
                                                                <div class="product-label green">best price</div>
                                                                <div class="icons">
                                                                    <a class="entry"><i class="fa fa-check"
                                                                            aria-hidden="true"></i></a>
                                                                    <a class="entry open-popup" data-rel="3"><i
                                                                            class="fa fa-eye"
                                                                            aria-hidden="true"></i></a>
                                                                    <a class="entry"><i class="fa fa-heart-o"
                                                                            aria-hidden="true"></i></a>
                                                                </div>
                                                                <div class="preview">
                                                                    <div class="swiper-container" data-loop="1">
                                                                        <div class="swiper-button-prev style-1"></div>
                                                                        <div class="swiper-button-next style-1"></div>
                                                                        <div class="swiper-wrapper">
                                                                            <div class="swiper-slide">
                                                                                <img src="assets/img/products-img/seagate-hard-drives.webp"
                                                                                    alt="" />
                                                                            </div>
                                                                            <div class="swiper-slide">
                                                                                <img src="assets/img/products-img/seagate-hard-drives.webp"
                                                                                    alt="" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="content-animate">
                                                                    <div class="title">

                                                                        <div class="h6 animate-to-green"><a
                                                                                href="">SEAGATE HARD DRIVES</a></div>
                                                                    </div>
                                                                    <div class="description">
                                                                        <div class="simple-article text size-2">Mollis
                                                                            nec consequat at In feugiat molestie tortor
                                                                            a malesuada</div>
                                                                    </div>
                                                                    <div class="price">
                                                                        <div class="simple-article size-4 dark">$630.00
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="preview-buttons">
                                                                    <div class="buttons-wrapper">
                                                                        <a class="button size-2 style-2" href="">
                                                                            <span class="button-wrapper">
                                                                                <span class="icon"><img
                                                                                        src="assets/img/extra-img/icon-1.png"
                                                                                        alt=""></span>
                                                                                <span class="text">Learn More</span>
                                                                            </span>
                                                                        </a>
                                                                        <a class="button size-2 style-3" href="#">
                                                                            <span class="button-wrapper">
                                                                                <span class="icon"><img
                                                                                        src="assets/img/extra-img/icon-3.png"
                                                                                        alt=""></span>
                                                                                <span class="text">Add To Cart</span>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li> -->
                                        <li>
                                            <a href="category/hard-drives">Hard DRIVES</a>
                                        </li>
                                        <li>
                                            <a href="category/ssds">ssd</a>
                                        </li>
                                        <li>
                                            <a href="category/video-cards">Video Cards</a>
                                        </li>
                                        <li class="megamenu-wrapper">
                                            <a href="category/motherboards">MOTHERBOARDS</a>

                                        </li>
                                        <li><a href="category/cpu">cPU</a></li>

                                    </ul>
                                    <div class="navigation-title">
                                        Navigation
                                        <div class="hamburger-icon active">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                            <!-- <div class="header-bottom-icon toggle-search"><i class="fa fa-search"
                                    aria-hidden="true"></i></div> -->
                            <div class="header-bottom-icon visible-rd"><i class="fa fa-heart-o" aria-hidden="true"></i>
                            </div>
                            <div class="header-bottom-icon visible-rd">
                                <a href="cart.php">
                                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                    <span class="cart-label">5</span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>