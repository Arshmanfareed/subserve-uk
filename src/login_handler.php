<?php
session_start();

$response = array();

// Check if the user is logged in
if (!isset($_SESSION["user"]["loggedin"]) || $_SESSION["user"]["loggedin"] !== true) {
    include "connection.php";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email =  trim($_POST["email"]);
        $password =  trim($_POST["password"]);

        // Perform SQL query (use prepared statements for security)
        $query = "SELECT user_id, user_fname, user_pass FROM users WHERE user_email = ?";
        $stmt = $conn->prepare($query);

        // Check if the query preparation was successful
        if (!$stmt) {
            $response['status'] = 'error';
            $response['message'] = 'Error during query preparation: ' . $conn->error;
        } else {
            $stmt->bind_param("s", $email);

            // Check if the binding was successful
            if (!$stmt->execute()) {
                $response['status'] = 'error';
                $response['message'] = 'Error during query execution: ' . $stmt->error;
            } else {
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // User found, fetch hashed password
                    $stmt->bind_result($user_id, $user_fname, $user_pass);
                    $stmt->fetch();



                    // Debugging: Directly compare the stored hash with the entered password (with trim to remove hidden characters)
                    if (password_verify($password, $user_pass)) {

                        // Save user information to the session                  
                        $_SESSION["user"] = array(
                            "loggedin" => true,
                            "user_id" => $user_id,
                            "useremail" => $email,
                            "fname" => $user_fname
                        );

                        $response['status'] = 'success';
                        $response['message'] = 'Login successful';
                    } else {

                        $response['status'] = 'error';
                        $response['message'] = 'Invalid email or password';
                    }
                } else {
                    // User not found, invalid login
                    $response['status'] = 'error';
                    $response['message'] = 'Invalid email or password';
                }

            }




            $stmt->close();
        }
    }
} else {
    $response['status'] = 'already';
    $response['message'] = 'User already logged in';
}

// Output the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>