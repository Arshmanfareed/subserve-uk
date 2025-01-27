<?php
session_start();

$response = array();

// Check if the user is already logged in
if (isset($_SESSION["user"])) {
    $response['status'] = 'already';
    $response['message'] = 'User already logged in';
} else {
    // Validate and sanitize inputs
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST["password"]);
    $confirmPassword = trim($_POST["confirmPassword"]);

    // Optional fields
    $street = isset($_POST["street"]) ? filter_var(trim($_POST["street"]), FILTER_SANITIZE_STRING) : '';
    $apartment = isset($_POST["apartment"]) ? filter_var(trim($_POST["apartment"]), FILTER_SANITIZE_STRING) : '';
    $city = isset($_POST["city"]) ? filter_var(trim($_POST["city"]), FILTER_SANITIZE_STRING) : '';
    $state = isset($_POST["state"]) ? filter_var(trim($_POST["state"]), FILTER_SANITIZE_STRING) : '';
    $zip = isset($_POST["zip"]) ? filter_var(trim($_POST["zip"]), FILTER_SANITIZE_STRING) : '';
    $phone = isset($_POST["phone"]) ? filter_var(trim($_POST["phone"]), FILTER_SANITIZE_STRING) : '';

    // Additional validation as needed
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        $response['status'] = 'error';
        $response['message'] = 'All required fields must be filled.';
    } elseif ($password !== $confirmPassword) {
        $response['status'] = 'error';
        $response['message'] = 'Passwords do not match.';
    } else {
        // Include database connection
        include "connection.php";

        // Check if the email is already registered
        $checkQuery = "SELECT user_id FROM users WHERE user_email = '" . $email . "'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult === false) {
            $response['status'] = 'error';
            $response['message'] = 'Database error: ' . $conn->error;
        } else {
            if ($checkResult->num_rows > 0) {
                $response['status'] = 'error';
                $response['message'] = 'Email is already registered.';
            } else {
                
                // Hash the password for security
                $hashedPassword = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

                
                // Insert user data into the database
                $insertQuery = "INSERT INTO users (user_fname, user_email, user_pass, user_street, user_apartment, user_city, user_state, user_zip, user_phone) 
                                VALUES ('$name', '$email', '$hashedPassword', '$street', '$apartment', '$city', '$state', '$zip', '$phone')";

         
                $insertResult = $conn->query($insertQuery);

                if ($insertResult === true) {
                    // Save user information to the session                  
                    $_SESSION["user"] = array(
                        "loggedin" => true,
                        "user_id" => $conn->insert_id, // Get the last inserted user ID
                        "useremail" => $email,
                        "fname" => $name
                    );

                    $response['status'] = 'success';
                    $response['message'] = 'Registration successful';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Registration failed. Please try again. Error: ' . $conn->error;
                }
            }
        }

        $conn->close();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
