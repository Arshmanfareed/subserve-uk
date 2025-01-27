<?php
session_start();
include 'connection.php';
function calculateTotal($quantity, $price)
{
    return $quantity * str_replace("$", "", $price);
}
function calculateSubtotal($cart)
{
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += calculateTotal($item['quantity'], $item['priceIn']);
    }
    return $subtotal;
}
function calculateShipping()
{
    return 0; // Assuming free shipping
}
function calculateOrderTotal($cart)
{
    $subtotal = calculateSubtotal($cart);
    $shipping = calculateShipping();
    return $subtotal + $shipping;
}
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : null;
    $last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : null;
    $full_name = $first_name. " ".$last_name;
    $company_name = isset($_POST["company_name"]) ? $_POST["company_name"] : null;
    $street_addr = isset($_POST["street_addr"]) ? $_POST["street_addr"] : null;
    $apartment = isset($_POST["apartment"]) ? $_POST["apartment"] : null;
    $city = isset($_POST["city"]) ? $_POST["city"] : null;
    $state = isset($_POST["state"]) ? $_POST["state"] : null;
    $zipcode = isset($_POST["zipcode"]) ? $_POST["zipcode"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : null;
    $different_addr = isset($_POST["different_addr"]) && $_POST["different_addr"] == "on" ? true : false;
    $first_name2 = isset($_POST["first_name2"]) ? $_POST["first_name2"] : null;
    $last_name2 = isset($_POST["last_name2"]) ? $_POST["last_name2"] : null;
    $company_name2 = isset($_POST["company_name2"]) ? $_POST["company_name2"] : null;
    $street_addr2 = isset($_POST["street_addr2"]) ? $_POST["street_addr2"] : null;
    $appr2 = isset($_POST["appr2"]) ? $_POST["appr2"] : null;
    $city2 = isset($_POST["city2"]) ? $_POST["city2"] : null;
    $state2 = isset($_POST["state2"]) ? $_POST["state2"] : null;
    $zipcode2 = isset($_POST["zipcode2"]) ? $_POST["zipcode2"] : null;
    $order_notes = isset($_POST["order_notes"]) ? $_POST["order_notes"] : null;
    $payment_method = isset($_POST["payment_method"]) ? $_POST["payment_method"] : null;
    $paymentId = isset($_POST["paypalPaymentId"]) ? $_POST["paypalPaymentId"] : null;
    $user_id = $_SESSION["user"]['user_id'];

    //Adding Order to DB
    // Check if the cart session is set and not empty
    if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
        // Initialize an array to store order details
        $ordersData = array();
$total =0;
        // Iterate through each item in the cart
        foreach ($_SESSION["cart"] as $key => $item) {
            // Extract item details
            $productName = trim($item['name']);
            $productPrice = $item['priceIn'];
            $quantity = $item['quantity'];
            $totals = $quantity * str_replace("$", "", $productPrice);
            $total += $quantity * str_replace("$", "", $productPrice);

            // Store order details in the array
            $ordersData[] = array(
                'order_user' => $user_id, // Assuming order_user is always 1
                'order_amount' => $total,
                'order_date' => date("Y-m-d H:i:s"), // Current date and time
                'order_update' => date("Y-m-d H:i:s"), // Current date and time
                'item_name' => $productName,
                'item_qty' => $quantity,
                'item_price' => $productPrice,
                'item_total' => $totals
            );
        }
        $insertOrderQuery = "INSERT INTO orders (order_user, order_amount) VALUES ($user_id, '$total')";
        mysqli_query($conn, $insertOrderQuery);

        // Get the last inserted order ID
        $order_id = mysqli_insert_id($conn);
        // Insert data into the orders and order_item tables
        foreach ($ordersData as $order) {
            // Insert data into the order_item table
            $item_name = mysqli_real_escape_string($conn, $order['item_name']);
            $insertItemQuery = "INSERT INTO order_item (item_order_id, item_name, item_qty, item_price, item_total) VALUES ('$order_id', '$item_name', '$order[item_qty]', '$order[item_price]', '$order[item_total]')";
            mysqli_query($conn, $insertItemQuery);
        }
        
        $insertDetailsQuery = "INSERT INTO order_details (order_id, customer_fname, customer_lname, company_name, street_address, appartment, town, state, postal_code, customer_email, customer_phone, order_notes, payment_method, paymentId, different_address, customer_fname2, customer_lname2, companny_name2, street_address2, appartment2, city2, state2, post_code2) VALUES ('$order_id', '$first_name', '$last_name', '$company_name', '$street_addr', '$apartment', '$city', '$state', '$zipcode', '$email', '$phone', '$order_notes', '$payment_method', '$paymentId', '$different_addr', '$first_name2', '$last_name2', '$company_name2', '$street_addr2', '$appr2', '$city2', '$state2', '$zipcode2')";
        mysqli_query($conn, $insertDetailsQuery);
        
        echo $insertDetailsQuery;
       
        
    }



    //SENDING MAIL TO ADMIN
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'send.one.com';                         //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'sales@subserve-usa.com';                //SMTP username
        $mail->Password   = 'm5-Cv&xP`W$JwD:H';                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('sales@subserve-usa.com', 'Subserve USA');
        $mail->addAddress('sales@subserve-usa.com', $full_name); 

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "You've Got a Order : ";
        $msg_email = '<!DOCTYPE html>
        <html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
        
        <head>
            <title></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
            <!--[if !mso]><!-->
            <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
            <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet" type="text/css">
            <!--<![endif]-->
            <style>
            * {
                box-sizing: border-box;
            }
        
            body {
                margin: 0;
                padding: 0;
            }
        
            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: inherit !important;
            }
        
            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
            }
        
            p {
                line-height: inherit
            }
        
            .desktop_hide,
            .desktop_hide table {
                mso-hide: all;
                display: none;
                max-height: 0px;
                overflow: hidden;
            }
        
            .image_block img+div {
                display: none;
            }
        
            @media (max-width:700px) {
        
                .desktop_hide table.icons-inner,
                .social_block.desktop_hide .social-table {
                    display: inline-block !important;
                }
        
                .icons-inner {
                    text-align: center;
                }
        
                .icons-inner td {
                    margin: 0 auto;
                }
        
                .mobile_hide {
                    display: none;
                }
        
                .row-content {
                    width: 100% !important;
                }
        
                .stack .column {
                    width: 100%;
                    display: block;
                }
        
                .mobile_hide {
                    min-height: 0;
                    max-height: 0;
                    max-width: 0;
                    overflow: hidden;
                    font-size: 0px;
                }
        
                .desktop_hide,
                .desktop_hide table {
                    display: table !important;
                    max-height: none !important;
                }
            }
            </style>
        </head>
        
        <body style="background-color: #f2fafc; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
            <table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f2fafc;">
                <tbody>
                    <tr>
                        <td>
                            <table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #787771;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <div class="spacer_block block-1"
                                                                style="height:1px;line-height:1px;font-size:1px;">&#8202;</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <div class="spacer_block block-1"
                                                                style="height:5px;line-height:5px;font-size:1px;">&#8202;</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-3" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0"
                                                role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="75%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="empty_block block-1" width="100%" border="0"
                                                                cellpadding="0" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="25%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="0" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad"
                                                                        style="padding-bottom:20px;padding-right:5px;padding-top:22px;">
                                                                        <div
                                                                            style="color:#787771;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                INVOICE NO 0123</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-5" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="66.66666666666667%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 10px; padding-right: 10px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#44464a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">Order
                                                                                number: <span
                                                                                    style="color:#c4a07a;"><strong>00000001</strong></span>
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="paragraph_block block-2" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#44464a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                Invoice Date: Jun 18, 2018</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="33.333333333333336%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <div class="spacer_block block-1 mobile_hide"
                                                                style="height:15px;line-height:15px;font-size:1px;">&#8202;
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-6" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <div class="spacer_block block-1"
                                                                style="height:15px;line-height:15px;font-size:1px;">&#8202;
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>';
  
                            if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                                foreach ($_SESSION["cart"] as $key => $item) {
                                    $productName = $item['name'];
                                    $productPrice = $item['priceIn']; // Assuming 'priceIn' is the price key
                                    $quantity = $item['quantity'];
                                    $total = $quantity * str_replace("$", "", $productPrice);;
                                    $msg_email .= '<!-- ITEM INFO END -->
                            <table class="heading_block block-2" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px; margin: 0 auto;">
                                <tbody><tr>
                                    <td class="pad">
                                        <h1 style="margin: 0; color: #000000; direction: ltr; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 23px; font-weight: 700; letter-spacing: normal; line-height: 150%; text-align: left; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 34.5px;">
                                            <span class="tinyMce-placeholder">Order Info :</span>
                                        </h1>
                                    </td>
                                </tr>
                            </tbody></table>
                            <table class="row row-17" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px; margin: 0 auto;" width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;font-weight:700;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">Product&nbsp;</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;font-weight:700;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">Quantity</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-3" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;font-weight:700;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">Price</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-4" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;font-weight:700;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">Total</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-18" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px; margin: 0 auto;" width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;font-weight:400;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">'.$productName.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;font-weight:400;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">'.$quantity.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-3" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;font-weight:400;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">'.$productPrice.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-4" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;font-weight:400;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">'.$total.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- ITEM INFO END -->';
                                }
                            }
                            

                            $msg_email .= '<table class="heading_block block-2" border="0" cellpadding="10" cellspacing="0" role="presentation"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px; margin: 0 auto;">
                                <tr>
                                    <td class="pad">
                                        <h1
                                            style="margin: 0; color: #000000; direction: ltr; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 23px; font-weight: 700; letter-spacing: normal; line-height: 150%; text-align: left; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 34.5px;">
                                            <span class="tinyMce-placeholder">Customer Info :</span>
                                        </h1>
                                    </td>
                                </tr>
                            </table>
                            <table class="row row-7" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0"
                                                role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                Customer Name</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                '.$first_name." ".$last_name.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-8" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0"
                                                role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                Company Name</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                '.$company_name.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-9" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0"
                                                role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                Address</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                '.$street_addr." ".$apartment." ".$city."
                                                                                ".$state." ".$zipcode.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-10" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0"
                                                role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">Email
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                '.$email.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-11" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0"
                                                role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">Phone
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                '.$phone.' </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-12" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0"
                                                role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                Payment Method</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                '.$payment_method.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            ';
                            $msg_email .= '<table class="row row-13" align="center" width="100%" border="0" cellpadding="0"
                                cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0"
                                                role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">Order
                                                                                Notes</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="column column-2" width="50%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                '.$order_notes.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-14" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="divider_block block-1" width="100%" border="0"
                                                                cellpadding="0" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div class="alignment" align="center">
                                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                                role="presentation" width="100%"
                                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                                <tr>
                                                                                    <td class="divider_inner"
                                                                                        style="font-size: 1px; line-height: 1px; border-top: 1px solid #E1ECEF;">
                                                                                        <span>&#8202;</span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>';
                            if ($different_addr) {
                                $msg_email .= '<!-- SHIPPIG STARTS -->
                            <table class="heading_block block-2" border="0" cellpadding="10" cellspacing="0" role="presentation"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px; margin: 0 auto;">
                                <tbody>
                                    <tr>
                                        <td class="pad">
                                            <h1
                                                style="margin: 0; color: #000000; direction: ltr; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 23px; font-weight: 700; letter-spacing: normal; line-height: 150%; text-align: left; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 34.5px;">
                                                <span class="tinyMce-placeholder">Shipping Info :</span>
                                            </h1>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-7" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="50%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tbody><tr>
                                                                    <td class="pad">
                                                                        <div style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                Customer Name</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                        <td class="column column-2" width="50%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tbody><tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                '.$first_name2." ".$last_name2.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="column column-1" width="50%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tbody><tr>
                                                                    <td class="pad">
                                                                        <div style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                Company Name</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                        <td class="column column-2" width="50%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tbody><tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                '.$company_name2.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="column column-1" width="50%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tbody><tr>
                                                                    <td class="pad">
                                                                        <div style="color:#c4a07a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:left;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                Address</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                        <td class="column column-2" width="50%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; background-color: #f9feff; padding-bottom: 5px; padding-left: 15px; padding-right: 15px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tbody><tr>
                                                                    <td class="pad">
                                                                        <div style="color:#000000;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:120%;text-align:right;mso-line-height-alt:16.8px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                            '.$street_addr2." ".$appr2." ".$city2."
                                                                                ".$state2." ".$zipcode2.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- SHIPPIG ENDS -->';
                            }
                            $msg_email .= '<table class="row row-15" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="divider_block block-1" width="100%" border="0"
                                                                cellpadding="0" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div class="alignment" align="center">
                                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                                role="presentation" width="100%"
                                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                                <tr>
                                                                                    <td class="divider_inner"
                                                                                        style="font-size: 1px; line-height: 1px; border-top: 1px solid #E1ECEF;">
                                                                                        <span>&#8202;</span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>';
                            // TOTAL AND SHIPPING
                            $order_subtotal = number_format(calculateOrderTotal($_SESSION["cart"]), 2);
                            $msg_email .= '<table class="row row-19" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                            <tbody>
                                <tr>
                                    <td>
                                        <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1" width="66.66666666666667%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 5px; padding-right: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                        <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                            <tr>
                                                                <td class="pad">
                                                                    <div style="color:#393d47;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:120%;text-align:left;mso-line-height-alt:19.2px;">
                                                                        <p style="margin: 0; word-break: break-word;"><span><strong>Subtotal</strong></span></p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td class="column column-2" width="33.333333333333336%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 5px; padding-right: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                        <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                            <tr>
                                                                <td class="pad">
                                                                    <div style="color:#393d47;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:120%;text-align:right;mso-line-height-alt:19.2px;">
                                                                        <p style="margin: 0; word-break: break-word;"><span>$ '.$order_subtotal.'</span></p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="row row-20" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                            <tbody>
                                <tr>
                                    <td>
                                        <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                                            <tbody>
                                                <tr>
                                                    <td class="column column-1" width="66.66666666666667%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 5px; padding-right: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                        <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                            <tr>
                                                                <td class="pad">
                                                                    <div style="color:#393d47;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:120%;text-align:left;mso-line-height-alt:19.2px;">
                                                                        <p style="margin: 0; word-break: break-word;"><span><strong>Shipping</strong></span></p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td class="column column-2" width="33.333333333333336%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 5px; padding-right: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                        <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                            <tr>
                                                                <td class="pad">
                                                                    <div style="color:#393d47;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:120%;text-align:right;mso-line-height-alt:19.2px;">
                                                                        <p style="margin: 0; word-break: break-word;"><span>$ 0</span></p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>';
                        // SHIPPING AND TOTAL END
                        $msg_email .= '<table class="row row-17" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="divider_block block-1" width="100%" border="0"
                                                                cellpadding="0" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div class="alignment" align="center">
                                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                                role="presentation" width="100%"
                                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                                <tr>
                                                                                    <td class="divider_inner"
                                                                                        style="font-size: 1px; line-height: 1px; border-top: 1px solid #E1ECEF;">
                                                                                        <span>&#8202;</span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-18" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="divider_block block-1" width="100%" border="0"
                                                                cellpadding="0" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div class="alignment" align="center">
                                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                                role="presentation" width="100%"
                                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                                <tr>
                                                                                    <td class="divider_inner"
                                                                                        style="font-size: 1px; line-height: 1px; border-top: 1px solid #E1ECEF;">
                                                                                        <span>&#8202;</span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-19" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 5px; padding-right: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div
                                                                            style="color:#68a0a9;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:22px;line-height:120%;text-align:right;mso-line-height-alt:26.4px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                <span><strong><span>Total $
                                                                                            '.$order_subtotal.'</span></strong></span>
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-20" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <div class="spacer_block block-1"
                                                                style="height:40px;line-height:40px;font-size:1px;">&#8202;
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-21" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="paragraph_block block-1" width="100%" border="0"
                                                                cellpadding="0" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                                                <tr>
                                                                    <td class="pad"
                                                                        style="padding-bottom:15px;padding-left:35px;padding-right:35px;padding-top:15px;">
                                                                        <div
                                                                            style="color:#44464a;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;font-size:14px;line-height:150%;text-align:center;mso-line-height-alt:21px;">
                                                                            <p style="margin: 0; word-break: break-word;">
                                                                                Integer eget nibh vel massa gravida ullamcorper.
                                                                                Sed a viverra ante. Nullam posuere pellentesque
                                                                                lectus, nec vehicula felis rutrum ac. Maecenas
                                                                                porta facilisis turpis, eget imperdiet purus.
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-22" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="image_block block-1" width="100%" border="0"
                                                                cellpadding="25" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div class="alignment" align="center"
                                                                            style="line-height:10px">
                                                                            <div style="max-width: 136px;"><img
                                                                                    src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/1941/separator.png"
                                                                                    style="display: block; height: auto; border: 0; width: 100%;"
                                                                                    width="136" alt="Separator"
                                                                                    title="Separator"></div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="row row-23" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                                role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table class="row-content stack" align="center" border="0" cellpadding="0"
                                                cellspacing="0" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;"
                                                width="680">
                                                <tbody>
                                                    <tr>
                                                        <td class="column column-1" width="100%"
                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                            <table class="icons_block block-1" width="100%" border="0"
                                                                cellpadding="0" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                <tr>
                                                                    <td class="pad"
                                                                        style="vertical-align: middle; color: #000000; font-family: inherit; font-size: 14px; text-align: center;">
                                                                        <table class="alignment" cellpadding="0" cellspacing="0"
                                                                            role="presentation" align="center"
                                                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                            <tr>
                                                                                <td
                                                                                    style="vertical-align: middle; text-align: center; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; padding-right: 5px;">
                                                                                    <img class="icon"
                                                                                        src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/1941/logo-gris_1.png"
                                                                                        alt="Default" height="32" width="44"
                                                                                        align="center"
                                                                                        style="display: block; height: auto; margin: 0 auto; border: 0;">
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table class="social_block block-2" width="100%" border="0"
                                                                cellpadding="10" cellspacing="0" role="presentation"
                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                                <tr>
                                                                    <td class="pad">
                                                                        <div class="alignment" align="center">
                                                                            <table class="social-table" width="208px" border="0"
                                                                                cellpadding="0" cellspacing="0"
                                                                                role="presentation"
                                                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block;">
                                                                                <tr>
                                                                                    <td style="padding:0 10px 0 10px;"><a
                                                                                            href="https://www.facebook.com"
                                                                                            target="_blank"><img
                                                                                                src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-default-gray/facebook@2x.png"
                                                                                                width="32" height="32"
                                                                                                alt="Facebook" title="facebook"
                                                                                                style="display: block; height: auto; border: 0;"></a>
                                                                                    </td>
                                                                                    <td style="padding:0 10px 0 10px;"><a
                                                                                            href="https://www.twitter.com"
                                                                                            target="_blank"><img
                                                                                                src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-default-gray/twitter@2x.png"
                                                                                                width="32" height="32"
                                                                                                alt="Twitter" title="twitter"
                                                                                                style="display: block; height: auto; border: 0;"></a>
                                                                                    </td>
                                                                                    <td style="padding:0 10px 0 10px;"><a
                                                                                            href="https://www.linkedin.com"
                                                                                            target="_blank"><img
                                                                                                src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-default-gray/linkedin@2x.png"
                                                                                                width="32" height="32"
                                                                                                alt="Linkedin" title="linkedin"
                                                                                                style="display: block; height: auto; border: 0;"></a>
                                                                                    </td>
                                                                                    <td style="padding:0 10px 0 10px;"><a
                                                                                            href="https://www.instagram.com"
                                                                                            target="_blank"><img
                                                                                                src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-default-gray/instagram@2x.png"
                                                                                                width="32" height="32"
                                                                                                alt="Instagram"
                                                                                                title="instagram"
                                                                                                style="display: block; height: auto; border: 0;"></a>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table><!-- End -->
        </body>
        
        </html>';
        $mail->Body = $msg_email;
        $mail->send();
        echo json_encode(array("success" => "Email sent successfully"));
      
    } catch (Exception $e) {
        echo json_encode(array("error" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"));
        exit();
    }

    //SENDING MAIL TO USER
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'send.one.com';                         //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'sales@subserve-usa.com';                //SMTP username
        $mail->Password   = 'm5-Cv&xP`W$JwD:H';                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('sales@subserve-usa.com', 'Subserve USA');
        $mail->addAddress($email, $full_name); 

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "We've Got Your Order : ";
        $user_email_temp = '';

$user_email_temp .= '<!DOCTYPE html>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">

<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
	<style>
		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			padding: 0;
		}

		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: inherit !important;
		}

		#MessageViewBody a {
			color: inherit;
			text-decoration: none;
		}

		p {
			line-height: inherit
		}

		.desktop_hide,
		.desktop_hide table {
			mso-hide: all;
			display: none;
			max-height: 0px;
			overflow: hidden;
		}

		.image_block img+div {
			display: none;
		}

		@media (max-width:700px) {

			.desktop_hide table.icons-inner,
			.social_block.desktop_hide .social-table {
				display: inline-block !important;
			}

			.icons-inner {
				text-align: center;
			}

			.icons-inner td {
				margin: 0 auto;
			}

			.image_block div.fullWidth {
				max-width: 100% !important;
			}

			.mobile_hide {
				display: none;
			}

			.row-content {
				width: 100% !important;
			}

			.stack .column {
				width: 100%;
				display: block;
			}

			.mobile_hide {
				min-height: 0;
				max-height: 0;
				max-width: 0;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide,
			.desktop_hide table {
				display: table !important;
				max-height: none !important;
			}
		}
	</style>
</head>

<body style="background-color: #e1f0f1; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
	<table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e1f0f1;">
		<tbody>
			<tr>
				<td>
					<table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e8e2dd;">
						<tbody>
							<tr>
								<td>
									<table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
										<tbody>
											<tr>
												<td class="column column-1" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
													<div class="spacer_block block-1" style="height:35px;line-height:35px;font-size:1px;">&#8202;</div>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="row row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e8e2dd; background-image: url("https://d1oco4z2z1fhwp.cloudfront.net/templates/default/5056/bg_hero.png"); background-position: center top; background-repeat: no-repeat;">
						<tbody>
							<tr>
								<td>
									<table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
										<tbody>
											<tr>
												<td class="column column-1" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
													<div class="spacer_block block-1" style="height:35px;line-height:35px;font-size:1px;">&#8202;</div>
													<table class="icons_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
														<tr>
															<td class="pad" style="vertical-align: middle; color: #000000; font-family: inherit; font-size: 14px; text-align: center;">
																<table class="alignment" cellpadding="0" cellspacing="0" role="presentation" align="center" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
																	<tr>
																		<td style="vertical-align: middle; text-align: center; padding-top: 5px; padding-bottom: 15px; padding-left: 5px; padding-right: 5px;"><img class="icon" src="https://subserve-usa.com/assets/img/extra-img/logo.png" alt="Company Logo" width="200px"
                                                                        height="auto" align="center" style="display: block; height: auto; margin: 0 auto; border: 0;"></td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
													<table class="heading_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
														<tr>
															<td class="pad" style="padding-left:10px;padding-right:10px;text-align:center;width:100%;">
																<h1 style="margin: 0; color: #010101; direction: ltr; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 40px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 48px;"><strong>Thank you</strong></h1>
															</td>
														</tr>
													</table>
													<table class="heading_block block-4" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
														<tr>
															<td class="pad" style="padding-left:10px;padding-right:10px;text-align:center;width:100%;">
																<h1 style="margin: 0; color: #010101; direction: ltr; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 39px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 46.8px;"><strong>Your order successfully</strong></h1>
															</td>
														</tr>
													</table>
													<table class="heading_block block-5" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
														<tr>
															<td class="pad" style="padding-bottom:15px;padding-left:10px;padding-right:10px;text-align:center;width:100%;">
																<h1 style="margin: 0; color: #010101; direction: ltr; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 40px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 48px;"><strong>been placed.</strong></h1>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="row row-3" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e8e2dd;">
						<tbody>
							<tr>
								<td>
									<table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
										<tbody>
											<tr>
												<td class="column column-1" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
													<div class="spacer_block block-1" style="height:35px;line-height:35px;font-size:1px;">&#8202;</div>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="row row-4" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
						<tbody>
							<tr>
								<td>
									<table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
										<tbody>
											<tr>
												<td class="column column-1" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
													<div class="spacer_block block-1" style="height:35px;line-height:35px;font-size:1px;">&#8202;</div>
													<table class="heading_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
														<tr>
															<td class="pad" style="padding-left:10px;padding-right:10px;text-align:center;width:100%;">
																<h1 style="margin: 0; color: #010101; direction: ltr; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 34px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 40.8px;"><strong>Order Summary</strong></h1>
															</td>
														</tr>
													</table>
													<div class="spacer_block block-3" style="height:25px;line-height:25px;font-size:1px;">&#8202;</div>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="row row-5" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
						<tbody>
							<tr>
								<td>
									<table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
										<tbody>
											<tr>
												<td class="column column-1" width="41.666666666666664%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
													<table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
														<tr>
															<td class="pad">
																<div style="color:#cc835c;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:150%;text-align:left;mso-line-height-alt:24px;">
																	<p style="margin: 0; word-break: break-word;"><span>Order #90920</span></p>
																</div>
															</td>
														</tr>
													</table>
												</td>
												<td class="column column-2" width="58.333333333333336%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
													<table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
														<tr>
															<td class="pad">
																<div style="color:#cc835c;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:150%;text-align:right;mso-line-height-alt:24px;">
																	<p style="margin: 0; word-break: break-word;"><span>1.11.2021 11.15</span></p>
																</div>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>';
// PRODUCT LOOP       
if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $key => $item) {
        $productName = $item['name'];
        $productPrice = $item['priceIn']; // Assuming 'priceIn' is the price key
        $quantity = $item['quantity'];
        $img = $item['imageUrl'];
        $total = $quantity * str_replace("$", "", $productPrice);;
        $user_email_temp .= '<table class="row row-10" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-position: center top;">
        <tbody>
            <tr>
                <td>
                    <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #cfdddf; color: #000000; width: 680px; margin: 0 auto;" width="680">
                        <tbody>
                            <tr>
                                <td class="column column-2" width="61.666666666666664%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                    <div class="spacer_block block-1" style="height:30px;line-height:30px;font-size:1px;">&#8202;</div>
                                    <table class="heading_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                        <tr>
                                            <td class="pad" style="padding-bottom:10px;padding-left:15px;padding-right:10px;text-align:center;width:100%;">
                                                <h1 style="margin: 0; color: #010101; direction: ltr; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 24px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 28.799999999999997px;"><strong>'.$productName.'</strong></h1>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="heading_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
														<tr>
															<td class="pad" style="padding-bottom:10px;padding-left:15px;padding-right:10px;text-align:center;width:100%;">
																<h1 style="margin: 0; color: #010101; direction: ltr; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 12px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 19.2px;"><strong>Qty: </strong>'.$quantity.'</h1>
															</td>
														</tr>
													</table>
                                                    <table class="heading_block block-3" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                    <tr>
                                                        <td class="pad" style="padding-bottom:10px;padding-left:15px;padding-right:10px;text-align:center;width:100%;">
                                                            <h1 style="margin: 0; color: #010101; direction: ltr; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 12px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 19.2px;"><strong>Price: </strong>'.$productPrice.'</h1>
                                                        </td>
                                                    </tr>
                                                </table>   
                                </td>
                                <td class="column column-3" width="16.666666666666668%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                    <div class="spacer_block block-1" style="height:0px;line-height:0px;font-size:1px;">&#8202;</div>
                                </td>
                                <td class="column column-4" width="16.666666666666668%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                    <div class="spacer_block block-1" style="height:35px;line-height:35px;font-size:1px;">&#8202;</div>
                                    <table class="heading_block block-2" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                        <tr>
                                            <td class="pad" style="padding-bottom:15px;padding-left:10px;padding-right:10px;text-align:center;width:100%;">
                                                <h1 style="margin: 0; color: #010101; direction: ltr; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 18px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 21.599999999999998px;"><strong>'.$total.'$</strong></h1>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
        </table>';
    }
}
$user_email_temp .= '
<table class="row row-11" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
<tbody>
    <tr>
        <td>
            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <div class="spacer_block block-1" style="height:25px;line-height:25px;font-size:1px;">&#8202;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>
<table class="row row-12" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
<tbody>
    <tr>
        <td>
            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="41.666666666666664%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                <tr>
                                    <td class="pad">
                                        <div style="color:#cc835c;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:150%;text-align:left;mso-line-height-alt:24px;">
                                            <p style="margin: 0; word-break: break-word;"><strong><span>Order Summary</span></strong></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="column column-2" width="58.333333333333336%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <div class="spacer_block block-1" style="height:0px;line-height:0px;font-size:1px;">&#8202;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>
<table class="row row-13" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
<tbody>
    <tr>
        <td>
            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="41.666666666666664%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                <tr>
                                    <td class="pad">
                                        <div style="color:#010101;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:150%;text-align:left;mso-line-height-alt:24px;">
                                            <p style="margin: 0; word-break: break-word;"><span>Sub total</span></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="column column-2" width="58.333333333333336%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                <tr>
                                    <td class="pad">
                                        <div style="color:#010101;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:150%;text-align:right;mso-line-height-alt:24px;">
                                            <p style="margin: 0; word-break: break-word;"><span>'.number_format(calculateSubtotal($_SESSION["cart"]), 2).'$</span></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>
<table class="row row-16" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
<tbody>
    <tr>
        <td>
            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="divider_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tr>
                                    <td class="pad">
                                        <div class="alignment" align="center">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                <tr>
                                                    <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #BBBBBB;"><span>&#8202;</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>
<table class="row row-17" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
<tbody>
    <tr>
        <td>
            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="41.666666666666664%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                <tr>
                                    <td class="pad">
                                        <div style="color:#010101;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:150%;text-align:left;mso-line-height-alt:24px;">
                                            <p style="margin: 0; word-break: break-word;"><span>Shipping</span></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="column column-2" width="58.333333333333336%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                <tr>
                                    <td class="pad">
                                        <div style="color:#010101;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:150%;text-align:right;mso-line-height-alt:24px;">
                                            <p style="margin: 0; word-break: break-word;"><span>Free</span></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>
<table class="row row-18" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
<tbody>
    <tr>
        <td>
            <table class="row-content" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="41.666666666666664%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <div class="spacer_block block-1" style="height:0px;line-height:0px;font-size:1px;">&#8202;</div>
                        </td>
                        <td class="column column-2" width="16.666666666666668%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <div class="spacer_block block-1" style="height:0px;line-height:0px;font-size:1px;">&#8202;</div>
                        </td>
                        <td class="column column-3" width="16.666666666666668%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                <tr>
                                    <td class="pad">
                                        <div style="color:#010101;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:150%;text-align:right;mso-line-height-alt:24px;">
                                            <p style="margin: 0; word-break: break-word;"><strong><span>Total</span></strong></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="column column-4" width="25%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="paragraph_block block-1" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;">
                                <tr>
                                    <td class="pad">
                                        <div style="color:#010101;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:16px;line-height:150%;text-align:right;mso-line-height-alt:24px;">
                                            <p style="margin: 0; word-break: break-word;"><strong><span>'.number_format(calculateSubtotal($_SESSION["cart"]), 2).'$</span></strong></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>
<table class="row row-19" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
<tbody>
    <tr>
        <td>
            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <div class="spacer_block block-1" style="height:25px;line-height:25px;font-size:1px;">&#8202;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>
<table class="row row-20" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #010101;">
<tbody>
    <tr>
        <td>
            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <div class="spacer_block block-1" style="height:65px;line-height:65px;font-size:1px;">&#8202;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>
<table class="row row-21" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #010101;">
<tbody>
    <tr>
        <td>
            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="50%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="icons_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tr>
                                    <td class="pad" style="vertical-align: middle; color: #000000; font-family: inherit; font-size: 14px; padding-left: 10px; text-align: left;">
                                        <table class="alignment" cellpadding="0" cellspacing="0" role="presentation" align="left" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                            <tr>
                                                <td style="vertical-align: middle; text-align: center; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; padding-right: 5px;"><img class="icon" src="https://subserve-usa.com/assets/img/extra-img/footer-logo.png" alt="Subserve Logo" height="64" width="62" align="center" style="display: block; height: auto; margin: 0 auto; border: 0;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="column column-2" width="50%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <table class="heading_block block-1" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tr>
                                    <td class="pad" style="padding-bottom:20px;padding-left:10px;padding-right:10px;text-align:center;width:100%;">
                                        <h1 style="margin: 0; color: #ffffff; direction: ltr; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 18px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 21.599999999999998px;"><strong>Social Media</strong></h1>
                                    </td>
                                </tr>
                            </table>
                            <table class="social_block block-2" width="100%" border="0" cellpadding="10" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tr>
                                    <td class="pad">
                                        <div class="alignment" align="left">
                                            <table class="social-table" width="144px" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block;">
                                                <tr>
                                                    <td style="padding:0 4px 0 0;"><a href="https://www.facebook.com" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/facebook@2x.png" width="32" height="32" alt="Facebook" title="facebook" style="display: block; height: auto; border: 0;"></a></td>
                                                    <td style="padding:0 4px 0 0;"><a href="https://www.twitter.com" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/twitter@2x.png" width="32" height="32" alt="Twitter" title="twitter" style="display: block; height: auto; border: 0;"></a></td>
                                                    <td style="padding:0 4px 0 0;"><a href="https://www.linkedin.com" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/linkedin@2x.png" width="32" height="32" alt="Linkedin" title="linkedin" style="display: block; height: auto; border: 0;"></a></td>
                                                    <td style="padding:0 4px 0 0;"><a href="https://www.instagram.com" target="_blank"><img src="https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/instagram@2x.png" width="32" height="32" alt="Instagram" title="instagram" style="display: block; height: auto; border: 0;"></a></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>
<table class="row row-22" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #010101;">
<tbody>
    <tr>
        <td>
            <table class="row-content stack" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 680px; margin: 0 auto;" width="680">
                <tbody>
                    <tr>
                        <td class="column column-1" width="100%" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                            <div class="spacer_block block-1" style="height:65px;line-height:65px;font-size:1px;">&#8202;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table><!-- End -->
</body>

</html>';
        $mail->Body = $user_email_temp;
        $mail->send();
        echo json_encode(array("success" => "Email sent successfully"));
        unset($_SESSION['cart']);
    } catch (Exception $e) {
        echo json_encode(array("error" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"));
        exit();
    }
    
} else {
    // Handle invalid request method (not POST)
    http_response_code(400);
    echo json_encode(array("error" => "Invalid request method"));
}
?>