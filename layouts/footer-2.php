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