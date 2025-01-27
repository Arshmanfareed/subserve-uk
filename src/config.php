<?php 
 
// Product Details 
// Minimum amount is $0.50 US 
$itemName = "Demo Product"; 
$itemPrice = 25;  
$currency = "USD";  
 
/* Stripe API configuration 
 * Remember to switch to your live publishable and secret key in production! 
 * See your keys here: https://dashboard.stripe.com/account/apikeys 
 */ 

  
// PAYPAL
	define("PayPalClientId", "ATiQVwARCvKZ6HHkARzuZsiN_9_dJSD-hXzVMkUJ3RAA3I05_iLRv8QUPBU4NXac3LKKiVvMQX8Rh088");
	define("PayPalSecret", "ELlGQqIC6XWOkb9YFkPMhlBcjjGkfBrA0kSed_8Jnt0765J98yCHOgEbz9fSyJdztfhihjbDfpS9KO0X");
	define("PayPalBaseUrl", "https://api-m.paypal.com");
	define("PayPalENV", "production");
 
?>