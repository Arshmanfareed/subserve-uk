<?php
// session_start();
include('layouts/header.php');
?>
<div class="page-cart">

    <div class="container col-sm-mt70 col-md-mt100 ">
        <div class="empty-space col-xs-b15 col-sm-b30"></div>
        <div class="breadcrumbs">
            <a href="/">home</a>
            <a href="">shopping cart</a>
        </div>
        <div class="empty-space col-xs-b15 col-sm-b30 col-md-b50"></div>
        <div class="text-center">
            <div class="simple-article size-3 grey uppercase col-xs-b5">shopping cart</div>
            <div class="h2">check your products</div>
            <?php  
            ?>
            <div class="title-underline center"><span></span></div>
        </div>
    </div>

    <div class="empty-space col-xs-b25 col-md-b40"></div>

    <div class="container">
        <table class="cart-table">
            <thead>
                <tr>
                    <th style="width: 95px;"></th>
                    <th>product name</th>
                    <th style="width: 150px;">price</th>
                    <th style="width: 260px;">quantity</th>
                    <th style="width: 150px;">total</th>
                    <th style="width: 70px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if the cart session variable is set
                if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                    foreach ($_SESSION["cart"] as $key => $item) {
                        $productName = $item['name'];
                        if($item['priceIn'] > 0){ $productPrice = $item['priceIn']; } else{ $productPrice = $item['priceEx']; }
                        $quantity = $item['quantity'];
                        $total = calculateTotal($quantity, $productPrice);

                        echo '<tr>';
                        echo '<td data-title=" "><a class="cart-entry-thumbnail" href="#"><img src="' . $item['imageUrl'] . '" alt=""></a></td>';
                        echo '<td data-title=" "><h6 class="h6"><a href="#">' . $productName . '</a></h6></td>';
                        echo '<td data-title="Price: ">£' . number_format($productPrice, 2) . '</td>';
                        echo '<td data-title="Quantity: ">';
                        echo '<div class="quantity-select">';
                        echo '<span class="minus" data-product-id="' . $key . '">-</span>';
                        echo '<span class="number">' . $quantity . '</span>';
                        echo '<span class="plus" data-product-id="' . $key . '">+</span>';
                        echo '</div>';
                        echo '</td>';                        
                        echo '<td data-title="Total:">£' . number_format($total, 2) . '</td>';
                        echo '<td data-title=""><div class="button-close remove-from-cart" data-product-id="' . $key . '"></div></td>';
                        echo '</tr>';
                    }
                } else {
                    displayEmptyCartMessage();
                }
                ?>
            </tbody>
        </table>
        <div class="empty-space col-xs-b35"></div>
        <div class="row">
            <div class="col-sm-6 col-md-5 col-xs-b10 col-sm-b0">
                <!-- <div class="single-line-form">
                    <input class="simple-input" type="text" value="" placeholder="Enter your coupon code" />
                    <div class="button size-2 style-3">
                        <span class="button-wrapper">
                            <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                            <span class="text">submit</span>
                        </span>
                        <input type="submit" value="">
                    </div>
                </div> -->
            </div>
            <!-- <div class="col-sm-6 col-md-7 col-sm-text-right">
                <div class="buttons-wrapper">
                    <a class="button size-2 style-2" href="#">
                        <span class="button-wrapper">
                            <span class="icon"><img src="assets/img/extra-img/icon-2.png" alt=""></span>
                            <span class="text">update cart</span>
                        </span>
                    </a>

                </div>
            </div> -->
        </div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>
        <div class="row d-flex justify-content-end">
            <div class="col-md-6 col-xs-b50 col-md-b0 d-none">
                <h4 class="h4 col-xs-b25">calculate shipping</h4>
                <select class="SlectBox">
                    <option disabled="disabled" selected="selected">Choose country for shipping</option>
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>
                <div class="empty-space col-xs-b20"></div>
                <div class="row m10">
                    <div class="col-sm-6">
                        <input class="simple-input" type="text" value="" placeholder="State / Country" />
                        <div class="empty-space col-xs-b20"></div>
                    </div>
                    <div class="col-sm-6">
                        <input class="simple-input" type="text" value="" placeholder="Postcode / Zip" />
                        <div class="empty-space col-xs-b20"></div>
                    </div>
                </div>
                <div class="button size-2 style-2">
                    <span class="button-wrapper">
                        <span class="icon"><img src="assets/img/extra-img/icon-1.png" alt=""></span>
                        <span class="text">update totals</span>
                    </span>
                    <input type="submit" />
                </div>
            </div>
            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])){ ?>
                <div class="col-sm-12 col-xs-12 col-md-6">
                    <h4 class="h4">cart totals</h4>
    
                    <div class="order-details-entry simple-article size-3 grey uppercase">
                        <div class="row">
                            <div class="col-xs-6">
                                cart subtotal
                            </div>
                            <div class="col-xs-6 col-xs-text-right">
                                <div class="color">£<?php  if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) { echo number_format(calculateSubtotal($_SESSION["cart"]), 2); } ?>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- <div class="order-details-entry simple-article size-3 grey uppercase">
                        <div class="row">
                            <div class="col-xs-6">
                                shipping and handling
                            </div>
                            <div class="col-xs-6 col-xs-text-right">
                                <div class="color">FOB</div>
                            </div>
                        </div>
                    </div> -->
    
                    <div class="order-details-entry simple-article size-3 grey uppercase">
                        <div class="row">
                            <div class="col-xs-6">
                                order total
                            </div>
                            <div class="col-xs-6 col-xs-text-right">
                                <div class="color">£<?php  if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) { echo  number_format(calculateOrderTotal($_SESSION["cart"]), 2); } ?>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <?php 
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart']))
                    {
                        ?>
                                        <div class="buttons-wrapper col-sm-text-right mt-2">
                                        <a class="button size-2 style-3 <?php if(!isset($_SESSION['user'])){ echo 'open-popup';} ?>" <?php if (!isset($_SESSION['user']) ) {
                        echo 'data-rel="1"';
                    } else {
                        echo 'href="checkout.php"';
                    } ?> >
                            <span class="button-wrapper">
                                <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                                <span class="text">proceed to checkout</span>
                            </span>
                        </a>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>
        <div class="empty-space col-xs-b35 col-md-b70"></div>
    </div>

</div>
<?php
include('layouts/footer-scripts2.php');
?>

<?php
include('layouts/footer-end.php');
?>