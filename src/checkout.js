// Get API Key
let STRIPE_PUBLISHABLE_KEY = document.currentScript.getAttribute('pk_live_ngSwLWTMbGsuGVqtyKV9ZoF8');

// Create an instance of the Stripe object and set your publishable API key
const stripe = Stripe('pk_live_ngSwLWTMbGsuGVqtyKV9ZoF8');

const paymentMethodDomain = await stripe.paymentMethodDomains.update(
    '{{PAYMENT_METHOD_DOMAIN_ID}}',
    {
      enabled: false,
    }
  );
  
// Define card elements
let elements;

// Select payment form element
const paymentFrm = document.querySelector("#paymentFrm");
console.log(paymentFrm); 
// Get payment_intent_client_secret param from URL
const clientSecretParam = new URLSearchParams(window.location.search).get(
    "payment_intent_client_secret"
);

// Check whether the payment_intent_client_secret is already exist in the URL
setProcessing(true);
if(!clientSecretParam){
    setProcessing(false);
    
    // Create an instance of the Elements UI library and attach the client secret
    initialize();
}

// Check the PaymentIntent creation status
checkStatus();

// Attach an event handler to payment form
paymentFrm.addEventListener("submit", handleSubmit);

const form = document.getElementById("checkout-form");
form.addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent page reload
    save_order(); // Call your custom save_order() function
});

// Fetch a payment intent and capture the client secret
let payment_intent_id;
async function initialize() {
    const { id, clientSecret } = await fetch("src/payment_init.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ request_type:'create_payment_intent' }),
    }).then((r) => r.json());
    
    const appearance = {
        theme: 'stripe',
        rules: {
            '.Label': {
                fontWeight: 'bold',
                textTransform: 'uppercase',
            }
        }
    };
    
    elements = stripe.elements({ clientSecret, appearance });
    
    const paymentElement = elements.create("payment");
    paymentElement.mount("#paymentElement");
    
    payment_intent_id = id;
}

// Card form submit handler
async function handleSubmit(e) {
    e.preventDefault();
    setLoading(true);
    
    let customer_name = document.getElementById("name").value;
    let customer_email = document.getElementById("email").value;

     // Collect shipping details from the form
     let shipping = {
        name: document.getElementById("firstNameCustomer").value + " " + document.getElementById("lastNameCustomer").value,
        address: {
            line1: document.querySelector("input[name='street_addr']").value,
            city: document.querySelector("input[name='city']").value,
            state: document.querySelector("input[name='state']").value,
            postal_code: document.querySelector("input[name='zipcode']").value,
            country: "US", // Set the country code, e.g., "US" for the United States
        },
        phone: document.querySelector("input[name='phone']").value,
    };
    
    const { id, customer_id } = await fetch("src/payment_init.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ request_type:'create_customer', payment_intent_id: payment_intent_id, name: customer_name, email: customer_email }),
    }).then((r) => r.json());
    
    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            // Make sure to change this to your payment completion page
            return_url: window.location.href+'?customer_id='+customer_id,
            shipping: shipping,
        },
    });
    
    // This point will only be reached if there is an immediate error when
    // confirming the payment. Otherwise, your customer will be redirected to
    // your `return_url`. For some payment methods like iDEAL, your customer will
    // be redirected to an intermediate site first to authorize the payment, then
    // redirected to the `return_url`.
    if (error.type === "card_error" || error.type === "validation_error") {
        showMessage(error.message);
    } else {
        showMessage("An unexpected error occured.");
    }
    
    setLoading(false);
}

// Fetch the PaymentIntent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );
    
    const customerID = new URLSearchParams(window.location.search).get(
        "customer_id"
    );
    
    if (!clientSecret) {
        return;
    }
    
    const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);
    
    if (paymentIntent) {
        switch (paymentIntent.status) { 
            case "succeeded":
                save_order();
                // Post the transaction info to the server-side script and redirect to the payment status page
                fetch("src/payment_init.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ request_type:'payment_insert', payment_intent: paymentIntent, customer_id: customerID }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.payment_txn_id) {
                        
                        // window.location.href = 'payment-status.php?pid='+data.payment_txn_id;
                    } else {
                        showMessage(data.error);
                        setReinit();
                    }
                })
                .catch(console.error);
                
                break;
            case "processing":
                showMessage("Your payment is processing.");
                setReinit();
                break;
            case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                setReinit();
                break;
            default:
                showMessage("Something went wrong.");
                setReinit();
                break;
        }
    } else {
        showMessage("Something went wrong.");
        setReinit();
    }
}


// Display message
function showMessage(messageText) {
    const messageContainer = document.querySelector("#paymentResponse");
    
    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;
    
    setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageText.textContent = "";
    }, 5000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submitBtn").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#buttonText").classList.add("hidden");
    } else {
        // Enable the button and hide spinner
        document.querySelector("#submitBtn").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#buttonText").classList.remove("hidden");
    }
}

// Show a spinner on payment form processing
function setProcessing(isProcessing) {
    if (isProcessing) {
        $("#paymentFrm").addClass("hidden");
         $("#frmProcess").removeClass("hidden");
       
    } else {
        $("#paymentFrm").removeClass("hidden");
         $("#frmProcess").addClass("hidden");
       
    }
}

// Show payment re-initiate button
function setReinit() {
    document.querySelector("#frmProcess").classList.add("hidden");
    document.querySelector("#payReinit").classList.remove("hidden");
}
function save_order() {
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
    
}