<?php
clearstatcache() ;
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
        if($item['priceIn'] > 0){ $producPrice = $item['priceIn']; } else{ $producPrice = $item['priceEx']; }
        
        $subtotal += calculateTotal($item['quantity'], $producPrice);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css" integrity="sha512-58P9Hy7II0YeXLv+iFiLCv1rtLW47xmiRpC1oFafeKNShp8V5bKV/ciVtYqbk2YfxXQMt58DjNfkXFOn62xE+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" integrity="sha512-v8QQ0YQ3H4K6Ic3PJkym91KoeNT5S3PnDKvqnwqFD1oiqIl653crGZplPdU5KKtHjO0QKcQ2aUlQZYjHczkmGw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<!-- SEO -->
  <?php
    if(isset($_GET['pslug'])){
        include('src/connection.php');
        
        $product_slug_meta = $conn->real_escape_string($_GET['pslug']); 
        
        if(!empty($product_slug_meta)){
            $get_product_meta = "SELECT meta_titles, meta_keywords, meta_description, schema_markup, schema_markup2, schema_markup3, canonical_tag FROM `products` WHERE slug = '$product_slug_meta' ";
            $product_meta_results = $conn->query($get_product_meta);
            
            while($product_meta = mysqli_fetch_assoc($product_meta_results)){
                $metaTitle = $product_meta['meta_titles'];
                $metaKeywords = $product_meta['meta_keywords'];
                $metaDesc = $product_meta['meta_description'];
                $shemaMarkup = $product_meta['schema_markup'];
                $shemaMarkup2 = $product_meta['schema_markup2'];
                $shemaMarkup3 = $product_meta['schema_markup3'];
                $canonicalTags = $product_meta['canonical_tag'];
            }
        }
    }
    
  ?>
  
  <?php if(!empty($metaTitle)){ ?>
  <title><?php echo $metaTitle; ?></title>  <?php } ?>
  
 <?php if(!empty($metaDesc)){ ?> 
 <meta name="description" content="<?php echo $metaDesc; ?>" >  <?php } ?>
 
  <?php if(!empty($metaKeywords)){ ?>
  <meta name="keywords" content="<?php echo $metaKeywords; ?>" >  <?php } ?>
  
  <?php if(!empty($canonicalTags)){ ?>
  <link rel="canonical" href="<?php echo $canonicalTags; ?>" /> <?php } ?>

  <!-- fonts -->
  <!--<link href="https://fonts.googleapis.com/css?family=Questrial|Raleway:700,900" rel="stylesheet">-->
  <link defer href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link defer href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/bootstrap.extension.css" rel="stylesheet" type="text/css" />
  <link href="http://localhost/subserve/assets/css/style.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

  <link href="assets/css/swiper.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/sumoselect.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Slick slider -->
  <!--<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />-->

  <link rel="shortcut icon" href="assets/img/extra-img/favicon.png" />
  <title>SubServe</title>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/65f831f6cc1376635adbccf4/1hp8o6av9';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<?php if(!empty($shemaMarkup)){ ?>
    <script type="application/ld+json">
        <?php echo $shemaMarkup; ?>
    </script>

<?php }

if(!empty($shemaMarkup2)){ ?>
    <script type="application/ld+json">
        <?php echo $shemaMarkup2; ?>
    </script>

<?php } 

if(!empty($shemaMarkup3)){ ?>
    <script type="application/ld+json">
        <?php echo $shemaMarkup3; ?>
    </script>

<?php } ?>

</head>

<body>

  <!-- LOADER -->
  <div id="loader-wrapper"></div>

  <div id="content-block">
    <!-- HEADER -->
    <header>

    <div class="another-top-header">
      <div class="content-margins">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="logo">
              <a id="logo" href="" class="d-flex align-items-center"><img src="assets/img/extra-img/logo.png"
              alt="" /></a>
            </div>
          </div>
          <div class="col-md-6">
              <div class="search-header">
                <form class="search-form">
                  <div class="search-submit">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input type="button" id="searching" style="width: 0">
                  </div>
                  <input class="simple-input style-1 search-input" id="command" type="text" value="" placeholder="Enter keyword">
                  <div class="search-dropdown-menu" style="display: none;">
                    <ul class="search-results" aria-label="search" role="listbox"></ul>
                  </div>
                </form>
                  <input type="button" id="">
              </div>
          </div>
          <div class="col-md-3 account-div">
              <div class="myaccount">
                <?php
                if (isset($_SESSION['user'])) {
                                    ?>

                <ul class="nav hidden-xs">

                  <li class="main-li-nav">
                    <div class="dropdown hover">
                      <a><span>My Account</span><i class="fa fa-angle-down" aria-hidden="true"></i></a>
                      <ul class="inner-contact">
                        <li><a href="/my-account/dashboard.php"><i class="fa fa-user" aria-hidden="true"> </i><span>
                              <?php echo $_SESSION['user']['fname'] ?>
                            </span></a></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</span></a>
                        </li>
                      </ul>

                    </div>
                  </li>

                </ul>

                <?php
                  } else {

                ?>
                <div class="entry"><a class="open-popup" data-rel="1">
                <i class="fa-solid fa-user"></i>  
                <b>Account</b></a>
                <!-- &nbsp; or &nbsp;<a
                    class="open-popup" data-rel="2"><b>register</b></a> -->
                  </div>
                <?php
                  }
                ?>

              </div>
            <a class="cart-div" href="cart.php">
              <!-- <b class="hidden-xs">Your bag</b> -->
              <span class="cart-icon">
              <i class="fa-solid fa-cart-shopping"></i>
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

            
          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="another-bottom-header">
    <div class="content-margins">
          <div class="row">            
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 d-flex align-items-center  hidden-xs hidden-md hidden-sm justify-content-start">
              <ul class="nav hidden-xs">
                <li class="big-nav main-li-nav"><a href="#"><span>Categories</span><i class="fa fa-angle-down"
                      aria-hidden="true"></i></a>
                  <ul class="dropdown-box-mega">
                    <li class="show"><a href="/category/hard-drives"><span>Hard Drives</span><i
                          class="fa fa-angle-right" aria-hidden="true"></i></a>
                      <ul>
                        <li>
                          <ul class="sub-list-nav">
                            <li><a href="/category/server-and-workstation-hard-drives"><span>Server and Workstation Hard
                                  Drives</span></a></li>
                            <li><a href="/category/desktop-hard-drives"><span>Desktop Hard Drives</span></a></li>
                            <li><a href="/category/laptop-and-mobile-hard-drives"><span>Laptop and Mobile Hard
                                  Drives</span></a></li>
                            <li><a href="/category/printer-hard-drive"><span>Printer Hard Drive</span></a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li class=""><a href="/category/ssds"><span>SSDs</span><i class="fa fa-angle-right"
                          aria-hidden="true"></i></a>
                      <ul>
                        <li>
                          <ul class="sub-list-nav">
                            <li><a href="/category/enterprise-ssd">Enterprise SSD</a></li>
                            <li><a href="/category/desktop-ssd">Desktop SSD</a></li>
                            <li><a href="/category/laptop-ssd">Laptop SSD</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li><a href="/category/memory-modules"><span>Memory Modules</span><i class="fa fa-angle-right"
                          aria-hidden="true"></i></a>
                      <ul>
                        <li>
                          <ul class="sub-list-nav">
                            <li><a href="/category/desktop-memory">Desktop Memory</a></li>
                            <li><a href="/category/laptop-memory">Laptop Memory</a></li>
                            <li><a href="/category/server-memory">Server Memory</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li><a href="/category/network"><span>Networking</span><i class="fa fa-angle-right"
                          aria-hidden="true"></i></a>
                      <ul>
                        <li>
                          <ul class="sub-list-nav">
                            <li><a href="/category/network-adapters">Network Adapters</a></li>
                            <li><a href="/category/transceiver">Transceiver</a></li>
                            <li><a href="/category/routers">Routers</a></li>
                            <li><a href="/category/switches">Switches</a></li>
                            <li><a href="/category/wireless-networking">Wireless Networking</a></li>
                            <li><a href="/category/controllers">Controllers</a></li>
                            <li><a href="/category/cards">Cards</a></li>
                            <li><a href="/category/firewall">Firewall</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li><a href="/category/server"><span>Servers</span><i class="fa fa-angle-right"
                          aria-hidden="true"></i></a>
                      <ul>
                        <li>
                          <ul class="sub-list-nav custom-scrollbar">
                            <li><a href="/category/cisco-server">Cisco Server</a></li>
                            <li><a href="/category/dell-server">Dell Server</a></li>
                            <li><a href="/category/emc-server">EMC Server</a></li>
                            <li><a href="/category/hp-server">HP Server</a></li>
                            <li><a href="/category/ibm-server">IBM Server</a></li>
                            <li><a href="/category/lenovo-server">Lenovo Server</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li><a href="/category/power-supply"><span>Power Supplies</span><i class="fa fa-angle-right"
                          aria-hidden="true"></i></a>
                      <ul>
                        <li>
                          <ul class="sub-list-nav">
                            <li><a href="/category/cooler-master-power-supply">Cooler Master Power Supply</a></li>
                            <li><a href="/category/dell-power-supply">Dell Power Supply</a></li>
                            <li><a href="/category/hp-power-supply">HP Power Supply</a></li>
                            <li><a href="/category/sparkle-power-supply">Sparkle Power Supply</a></li>
                            <li><a href="/category/cisco-power-supply">Cisco Master Power Supply</a></li>
                            <li><a href="/category/brocade-power-supply">Brocade Power Supply</a></li>
                            <li><a href="/category/violin-power-supply">Violin Power Supply</a></li>
                            <li><a href="/category/netapp-power-supply">Netapp Power Supply</a></li>
                            <li><a href="/category/hitachi-master-power-supply">Hitachi Master Power Supply</a></li>
                            <li><a href="/category/fujitsu-power-supply">Fujitsu Power Supply</a></li>
                            <li><a href="/category/emc-power-supply">EMC Power Supply</a></li>
                            <li><a href="/category/ibm-power-supply">IBM Power Supply</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li class="custom-line-mega-menu"><span>Subserve Deals in Over 15+ Categories of IT Equipments, <a
                          href="/shop-main.php"> Explore All Categories</a></span>
                    </li>
                  </ul>
                </li>
                <li class="main-li-nav">
                  <a href="/about-us.php"><span>About Us</span></a>
                </li>
                <li class="main-li-nav">
                  <a href="/contact.php"><span>Contact Us</span></a>
                </li>
                <li class="main-li-nav">
                  <a href="/subserve/blogs.php"><span>Blog</span></a>
                </li>
                                            
              </ul>
            </div>
            <div class="col-md-3">
              <div class="number-div">
                <a href="tel:+1 (0)888 382 1386"><i class="fa-solid fa-headphones"></i><span>+1 (0)888 382 1386</span></a>
              </div>
            </div>
            <div class="col-xs-7 col-sm-7 col-md-6 col-lg-9 d-flex align-items-center justify-content-end hidden-lg">
              <div class="menu-toggle2" id="mobile-menu2">
                <span class="bar2"></span>
                <span class="bar2 barcross"></span>
                <span class="bar2"></span>
                <span class="cross2"></span>
              </div>

              <div class="mobile-nav" style="">
                <ul>
                  <li class="has-submenu">
                    <div class="submenu-list"><span>Categories</span><i class="fa fa-angle-down" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu">
                      <li class="has-submenu">
                        <div class="submenu-list"><span>HARD DRIVES</span><i class="fa fa-angle-down"
                            aria-hidden="true"></i></div>
                        <ul class="submenu">
                          <li><a href="">Server and Workstation Hard Drives</a></li>
                          <li><a href="">Desktop Hard Drives</a></li>
                          <li><a href="">Laptop and Mobile Hard Drives</a></li>
                          <li><a href="">Printer Hard Drive</a></li>
                        </ul>
                      </li>
                      <li class="has-submenu">
                        <div class="submenu-list"><span>SSDS</span><i class="fa fa-angle-down" aria-hidden="true"></i>
                        </div>
                        <ul class="submenu">
                          <li><a href="">Server and Workstation Hard Drives</a></li>
                          <li><a href="">Desktop Hard Drives</a></li>
                          <li><a href="">Laptop and Mobile Hard Drives</a></li>
                          <li><a href="">Printer Hard Drive</a></li>
                        </ul>
                      </li>

                      <li class="category">
                        <a href="category/cpu">CPU</a>
                      </li>
                      <li class="category">
                        <a href="category/network">NETWORK</a>
                      </li>
                      <li class="category">
                        <a href="category/motherboards">MOTHERBOARDS</a>
                      </li>
                      <li class="category">
                        <a href="category/video-cards">VIDEO CARDS</a>
                      </li>
                      <li class="category">
                        <a href="category/power-supply">POWER SUPPLY</a>
                      </li>
                      <li class="category">
                        <a href="category/memory-modules">Memory Modules</a>
                      </li>
                      <li class="category">
                        <a href="category/accessories">ACCESSORIES</a>
                      </li>
                      <li class="category">
                        <a href="category/server">SERVER</a>
                      </li>
                      <li class="category">
                        <a href="category/crypto-miner">Crypto Miner</a>

                      </li>
                      <li class="category">
                        <a href="category/storage">Storage</a>
                      </li>
                    </ul>
                  </li>
                  <li>Resources</li>
                  <li class="has-submenu">
                    <div class="submenu-list"><span>Contact</span><i class="fa fa-angle-down" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu">
                      <li><a href="contact-us.php">Form</a></li>
                      <li><a href="tel:+1 (0)888 382 1386">Call</a></li>
                      <li><a href="mailto:sales@subserve-usa.com">Email</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   

    </header>
    