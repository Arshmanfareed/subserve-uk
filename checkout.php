<?php
session_start();
if (!isset($_SESSION['user']) || (isset($_SESSION['cart']) && empty($_SESSION['cart']))) {
    header("Location: /");
    exit();
}
include('layouts/header.php');
require_once 'src/config.php'; 
include 'src/connection.php';


$currentUserId = $_SESSION['user']['user_id'];

// GET CURRENT USERS DATA
$user_data_query = "SELECT * FROM users WHERE user_id = '$currentUserId' ";
$get_user_data_results = $conn->query($user_data_query);

while($user = mysqli_fetch_assoc($get_user_data_results)){
    $user_name = $user['user_fname'];
    $user_email = $user['user_email'];
    $user_street = $user['user_street'];
    $user_apartment = $user['user_apartment'];
    $user_city = $user['user_city'];
    $user_state = $user['user_state'];
    $user_zip = $user['user_zip'];
    $user_phone = $user['user_phone'];
}

?>
<?php 
  
?>
<div class="page-checkout">
    <div class="container col-sm-mt70 col-md-mt100">
        <div class="empty-space col-xs-b15 col-sm-b30"></div>
        <div class="breadcrumbs">
            <a href="">home</a>
            <a href="">checkout</a>
        </div>
        <div class="empty-space col-xs-b15 col-sm-b30 col-md-b50"></div>
        <div class="text-center">
            <div class="simple-article size-3 grey uppercase col-xs-b5">checkout</div>
            <div class="h2">check your info</div>
            <div class="title-underline center"><span></span></div>
        </div>
    </div>

    <div class="empty-space col-xs-b35 col-md-b70"></div>

    <div class="container ">
        <form id="checkout-form">
            <div class="row">
                <div class="col-md-6 col-xs-b50 col-md-b0">
                    <h4 class="h4 col-xs-b25">billing details</h4>
                    <!-- <select class="SlectBox">
                        <option disabled="disabled" selected="selected">Choose country</option>
                        <option value="volvo">Volvo</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                        <option value="audi">Audi</option>
                    </select> -->
                    <div class="empty-space col-xs-b20"></div>
                    <div class="row m10">
                        <div class="col-sm-6">
                            <input class="simple-input" id="firstNameCustomer" name="first_name" type="text" value="<?php echo $user_name; ?>" placeholder="First name*" required />
                            <div class="empty-space col-xs-b20"></div>
                        </div>
                        <div class="col-sm-6">
                            <input class="simple-input" id="lastNameCustomer" name="last_name" type="text" placeholder="Last name"  />
                            <div class="empty-space col-xs-b20"></div>
                        </div>
                    </div>
                    <input class="simple-input" name="company_name" type="text" value="" placeholder="Company name"  />
                    <div class="empty-space col-xs-b20"></div>
                    <input class="simple-input" name="street_addr" type="text" value="<?php echo $user_name; ?>" placeholder="Street address*"  />
                    <div class="empty-space col-xs-b20"></div>
                    <div class="row m10">
                        <div class="col-sm-6">
                            <input class="simple-input" name="apartment" type="text" value="<?php echo $user_apartment ; ?>" placeholder="Appartment*" required />
                            <div class="empty-space col-xs-b20"></div>
                        </div>
                        <div class="col-sm-6">
                            <input class="simple-input" name="city" type="text" value="<?php echo $user_city ; ?>" placeholder="Town/City*" required />
                            <div class="empty-space col-xs-b20"></div>
                        </div>
                    </div>
                    <div class="row m10">
                        <div class="col-sm-6">
                            <input class="simple-input" name="state" type="text" value="<?php echo $user_state ; ?>" placeholder="State/County*" required />
                            <div class="empty-space col-xs-b20"></div>
                        </div>
                        <div class="col-sm-6">
                            <input class="simple-input" name="zipcode" type="text" value="<?php echo $user_zip ; ?>" placeholder="Postcode/ZIP*" required />
                            <div class="empty-space col-xs-b20"></div>
                        </div>
                    </div>
                    <div class="row m10">
                        <div class="col-sm-6">
                            <input class="simple-input" id="emailCustomer" name="email" type="text" value="<?php echo $user_email ; ?>" placeholder="Email*" required />
                            <div class="empty-space col-xs-b20"></div>
                        </div>
                        <div class="col-sm-6">
                            <input class="simple-input" name="phone" type="text" value="<?php echo $user_phone ; ?>" placeholder="Phone*" required />
                            <div class="empty-space col-xs-b20"></div>
                        </div>
                    </div>
                    <!-- <label class="checkbox-entry">
                        <input type="checkbox" checked><span>Privacy policy agreement</span>
                    </label> -->
                    <div class="empty-space col-xs-b50"></div>
                    <label class="checkbox-entry checkbox-toggle-title">
                        <input type="checkbox" name="different_addr"><span>ship to different address?</span>
                    </label>
                    <div class="checkbox-toggle-wrapper">
                        <div class="empty-space col-xs-b25"></div>
                        <!-- <select class="SlectBox">
                            <option disabled="disabled" selected="selected">Choose country</option>
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                        </select> -->
                        <div class="empty-space col-xs-b20"></div>
                        <div class="row m10">
                            <div class="col-sm-6">
                                <input class="simple-input" name="first_name2" type="text" value="" placeholder="First name" />
                                <div class="empty-space col-xs-b20"></div>
                            </div>
                            <div class="col-sm-6">
                                <input class="simple-input" name="last_name2" type="text" value="" placeholder="Last name" />
                                <div class="empty-space col-xs-b20"></div>
                            </div>
                        </div>
                        <input class="simple-input" type="text"  name="company_name2" value="" placeholder="Company name" />
                        <div class="empty-space col-xs-b20"></div>
                        <input class="simple-input" type="text" name="street_addr2" value="" placeholder="Street address" />
                        <div class="empty-space col-xs-b20"></div>
                        <div class="row m10">
                            <div class="col-sm-6">
                                <input class="simple-input" name="appr2" type="text" value="" placeholder="Appartment" />
                                <div class="empty-space col-xs-b20"></div>
                            </div>
                            <div class="col-sm-6">
                                <input class="simple-input" type="text" name="city2" value="" placeholder="Town/City" />
                                <div class="empty-space col-xs-b20"></div>
                            </div>
                        </div>
                        <div class="row m10">
                            <div class="col-sm-6">
                                <input class="simple-input" type="text" name="state2" value="" placeholder="State/Country" />
                                <div class="empty-space col-xs-b20"></div>
                            </div>
                            <div class="col-sm-6">
                                <input class="simple-input" type="text" value="" name="zipcode2" placeholder="Postcode/ZIP" />
                                <!-- <div class="empty-space col-xs-b20"></div> -->
                            </div>
                        </div>
                    </div>
                    <div class="empty-space col-xs-b30 col-sm-b60"></div>
                    <textarea class="simple-input" name="order_notes" placeholder="Note about your order"></textarea>
                    <input type="hidden" name="paypalPaymentId" id="paypalPaymentId" >
                </div>
                <div class="col-md-6">
                    <h4 class="h4 col-xs-b25">your order</h4>
                    <?php 
                    if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                        foreach ($_SESSION["cart"] as $key => $item) {
                            $productName = $item['name'];
                            if($item['priceIn'] > 0){ $productPrice = number_format($item['priceIn'], 2); } else{ $productPrice = number_format($item['priceEx'], 2); }
                            
                            $quantity = $item['quantity'];
                            $total = calculateTotal($quantity, $productPrice);
                            ?>
                            <div class="cart-entry clearfix">
                                <span class="cart-entry-thumbnail" ><img class="img-fluid"
                                        src="<?php echo $item['imageUrl'] ?>" alt=""></span>
                                <div class="cart-entry-description">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="h6"><?php echo $productName ?></div>
                                                    <div class="simple-article size-1">QUANTITY: <?php echo $quantity ?></div>
                                                </td>
                                                <td>
                                                    <div class="simple-article size-3 grey"><?php echo '£'.trim($productPrice) ?></div>
                                                    <div class="simple-article size-1">TOTAL: £<?php echo number_format($total,2) ?></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php 
                        }
                    }
                    ?>
                    <div class="order-details-entry simple-article size-3 grey uppercase">
                        <div class="row">
                            <div class="col-xs-6">
                                cart subtotal
                            </div>
                            <div class="col-xs-6 col-xs-text-right">
                                <div class="color">£<?php  if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) { echo number_format(calculateOrderTotal($_SESSION["cart"]), 2); }?></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="order-details-entry simple-article size-3 grey uppercase">
                        <div class="row">
                            <div class="col-xs-6">
                                shipping and handling
                            </div>
                            <div class="col-xs-6 col-xs-text-right">
                                <div class="color">free shipping</div>
                            </div>
                        </div>
                    </div> -->
                    <div class="order-details-entry simple-article size-3 grey uppercase">
                        <div class="row">
                            <div class="col-xs-6">
                                order total
                            </div>
                            <div class="col-xs-6 col-xs-text-right">
                                <div class="color">£<?php  if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) { echo number_format(calculateOrderTotal($_SESSION["cart"]), 2); }?></div>
                            </div>
                        </div>
                    </div>
                    <div class="empty-space col-xs-b50"></div>
                    <h4 class="h4 col-xs-b25">payment method</h4>
                    <select id="paymtype" class="SlectBox" name="payment_method">
                        <option value="PayPal">PayPal</option>
                        <option value="stripe">Stripe</option>
                    </select>
                    
                    <div id="paypalContainerBox">
                        <div id="paypal-button-container"></div>
                        <div id="paypal-button"></div>
                    </div>
                   
                    <div class="empty-space col-xs-b10"></div>
                    <!--<div class="simple-article size-2">* Etiam mollis tristique mi ac ultrices. Morbi vel neque eget lacus-->
                    <!--    sollicitudin facilisis. Lorem ipsum dolor sit amet semper ante vehicula ociis natoq.</div>-->
                    <div class="empty-space col-xs-b30"></div>
                    <div class="button block size-2 style-3 place_order">
                        <span class="button-wrapper">
                            <span class="icon"><img src="assets/img/extra-img/icon-4.png" alt=""></span>
                            <input type="button" id="place_order"><span id="placeOrderBtn" class="place-order-btn text">place order</span><div class="loader" style="display:none;"></div></input>
                        </span>
                    </div>
                    </form>
                    <div style="display:none;"  id="panel" class="panel">
    
                        <div class="panel-body">
                            
        <!-- Display status message -->
        <div id="paymentResponse" class="hidden"></div>
        
        <!-- Display a payment form -->
        <form id="paymentFrm" class="hidden">
            <div class="form-group">
                <label>NAME</label>
                <input type="text" id="name" class="field" placeholder="Enter name" required="" autofocus="">
            </div>
            <div class="form-group">
                <label>EMAIL</label>
                <input type="email" id="email" class="field" placeholder="Enter email" required="">
            </div>
            
            <div id="paymentElement">
                <!--Stripe.js injects the Payment Element-->
            </div>
            
            <!-- Form submit button -->
            <button id="submitBtn" class="btn btn-success">
                <div class="spinner hidden" id="spinner"></div>
                <span id="buttonText">Pay Now</span>
            </button>
        </form>
        
        <!-- Display processing notification -->
        <div id="frmProcess" class="hidden">
            <span class="ring"></span> Processing...
        </div>
        
        <!-- Display re-initiate button -->
        <div id="payReinit" class="hidden">
            <button class="btn btn-primary" onClick="window.location.href=window.location.href.split('?')[0]"><i class="rload"></i>Re-initiate Payment</button>
        </div>
    </div>

                    </div>
                </div>
            </div>
        
         
                    
    </div>

    <div class="empty-space col-xs-b35 col-md-b70"></div>
</div>
<?php
include('layouts/footer-scripts2.php');

?>



<!-- STRIPE -->
<script src="https://js.stripe.com/v3/"></script>
<script src="src/checkout.js" STRIPE_PUBLISHABLE_KEY="<?php echo 'pk_test_51Ixa77FYZEyzDKdXs5zEKjt3AeNewrUTRWs3d7WIJABcn83u2btvkSrCvOTq4mTBGpUz73hoJPAmbeUcucI7nq1N00s97uu3yT'; ?>" defer="defer"></script>
<script>
    $("#place_order").click(function(){
        
        $('#checkout-form').find('input').each(function(){
            if($(this).prop('required')){
                if($(this).val() == ""){
                    $(this).addClass('required-field-error');
                }
                else{
                    $(this).removeClass('required-field-error');  
                }
            } 
        }); 
            
        if( $('#checkout-form').find('input').hasClass("required-field-error")){
            $(".requiredValidationError").remove();
            $("<div class='requiredValidationError'>Please fill all the required fields.</div>").insertBefore(".place_order");
        }
        else{
                $(".requiredValidationError").remove();
                if($('#paymtype').val() == 'PayPal') {
                    proceedPaypalPayment(<?php echo number_format(calculateOrderTotal($_SESSION["cart"]), 2);  ?>);
                    $("#placeOrderBtn").hide();
                    $("#paypalContainerBox").show();
                }
                else{
                    $("#checkout-form").submit();   
                }
        }
    })
    
    $('form').find('input').blur(function(){
        if($(this).val() != "" ){
            $(this).removeClass('required-field-error');   
        }
    })

    $("#checkout-form").submit(function (event) {
        event.preventDefault();
        var formData = new FormData($("#checkout-form")[0]);
        var loader = $('.loader');
        // Show loader
        loader.fadeIn();
        $('#placeOrderBtn').html('');
        
        // Iterate through the formData object and log key-value pairs
        // formData.forEach(function (value, key) {
        //     console.log(key + ": " + value);
        // });

        // Send the form data to the PHP script using AJAX
        
        
        $.ajax({
            url: "src/checkout_handler.php", // Replace with the actual path to your PHP script
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                loader.fadeOut();
                $('#placeOrderBtn').html('Place Order');
                Swal.fire({
                    icon: 'success',
                    title: 'Thankyou',
                    text: 'Your order has been placed successfully: '
                });
               // Add a delay before reloading the page
                setTimeout(function () {
                    window.location.href = '/';
                }, 2000); 
            },
            error: function (error) {
                loader.fadeOut();
                $('#placeOrderBtn').html('Place Order');
                // Display SweetAlert for error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error Placing Order: ' + error.responseText
                });
                console.error("Error sending form data:", error);
            }
        }); 
    });
    $(function() {
    
    $('#paymtype').change(function(){
        if($('#paymtype').val() == 'stripe') {
            $('#panel').show(); 
            $('.place_order').hide(); 
            $("#placeOrderBtn").show();
            $("#paypalContainerBox").hide();
        }
        else if($('#paymtype').val() == "PayPal"){
            proceedPaypalPayment(<?php echo number_format(calculateOrderTotal($_SESSION["cart"]), 2);  ?>);
            $("#paypalContainerBox").show();   
            $("#placeOrderBtn").hide();
            $('#panel').hide(); 
        }
        else {
            $('#panel').hide(); 
            $('.place_order').show(); 
            $("#placeOrderBtn").show();
            $("#paypalContainerBox").hide();
        } 
    });
});


function paypalDataInput(){
    $("#paypalFirstName").val($("#firstNameCustomer").val());
    $("#paypalLastName").val($("#lastNameCustomer").val());
    $("#paypalUserEmail").val($("#emailCustomer").val());
}

</script>

<!-- PAYPAL CHECKOUT -->
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    function proceedPaypalPayment(orderTotalAmount){
        
        $("#paypal-button").html("");
        
        paypal.Button.render({
          env: '<?php echo PayPalENV; ?>',
          client: {
        	production: '<?php echo PayPalClientId; ?>'
          },
          payment: function (data, actions) {
        	return actions.payment.create({
        	  transactions: [{
        		amount: {
        		  total: orderTotalAmount,
        		  currency: 'GBP'
        		}
        	  }]
        	});
          },
          onAuthorize: function (data, actions) {
        	return actions.payment.execute()
        	  .then(function () {
        	    $("#paypalPaymentId").val(data.paymentID);
        	    $("#checkout-form").submit();
        	  });
          }
        }, '#paypal-button');
    }
</script>


<?php
include('layouts/footer-end.php');
?>