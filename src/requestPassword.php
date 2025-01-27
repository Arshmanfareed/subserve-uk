<?php 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


include ("connection.php");

// Generate a random verification code
$verification_code = bin2hex(random_bytes(16)); // Adjust the length of the random string as needed

// Sanitize the user email
$user_email = mysqli_real_escape_string($conn, $_POST['accountEmail']);

// Search for the user in the database
$search_query = "SELECT * FROM `users` WHERE user_email = '$user_email'";
$search_result = $conn->query($search_query);

if ($search_result->num_rows > 0) {
    // User found, update the user_code column with the generated verification code
    $update_query = "UPDATE `users` SET user_code = '$verification_code' WHERE user_email = '$user_email'";
    $update_result = $conn->query($update_query);

    if ($update_result) {
        
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
            $mail->addAddress($user_email); 
            $mail->addAddress('jadohere@gmail.com'); 
    
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "You've Got a Order : ";
            $mail->Body = "https://subserve-usa.com/reset-password.php?resetCode=".$verification_code;
            $mail->send();
        }
        catch (Exception $e) {
        echo json_encode(array("error" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"));
        exit();
        }
        // Verification code successfully updated
        $response = array(
            "status" => "success",
            "class" => "sucess-alert",
            "message" => "Verification code updated successfully"
        );
    } else {
        // Error updating verification code
        $response = array(
            "status" => "error",
            "class" => "error-alert",
            "message" => "Error updating verification code: " . $conn->error
        );
    }
} else {
    // User not found
    $response = array(
        "status" => "error",
        "class" => "error-alert",
        "message" => "User not found with email: $user_email"
    );
}

// Encode the response as JSON
$json_response = json_encode($response);

// Output the JSON string
echo $json_response;

?>