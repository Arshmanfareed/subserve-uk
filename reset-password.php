<?php
include("layouts/header.php");
include('src/connection.php');

// Check if "resetCode" parameter is set
if (!isset($_GET['resetCode'])) {
    // "resetCode" parameter is not set, echo 404
    http_response_code(404);
    echo "404 Not Found";
    exit();
}

$resetCode = trim($_GET['resetCode']);

$verify_code_query = 'SELECT * FROM `users` WHERE user_code = ?';

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare($verify_code_query);
$stmt->bind_param("s", $resetCode);
$stmt->execute();

// Check for errors in the query execution
if ($stmt->error) {
    // Handle the error, you can log or display an error message
    echo "Error: " . $stmt->error;
    exit();
}

// Get the result set
$verify_code_result = $stmt->get_result();

if ($verify_code_result->num_rows > 0) {
    // If result is found
    $verify_code_row = $verify_code_result->fetch_assoc();
    ?>
    <section class="breadcrumb__area box-plr-75">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="breadcrumb__wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Login</li>
                                    </ol>
                                  </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<section class="login-area pb-100">
                <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                            <div class="basic-login">
                            <h3 class="text-center mb-60">Set Your New Password</h3>
                            <form action="#">
                                <label for="name">New Password <span>*</span></label>
                                <input id="name" type="password" placeholder="Enter password...">
                                <label for="pass">Confirm New Password <span>*</span></label>
                                <input id="pass" type="password" placeholder="Enter Confirm password...">
                                
                                <button class="t-y-btn w-100">Update Password</button>
                                
                                
                            </form>
                            </div>
                    </div>
                </div>
                </div>
            </section>
    <?php
} else {
    // If no result is found
    echo "no";
}
?>


<?php
include('layouts/footer-scripts.php');
include('layouts/footer-end.php');
?>