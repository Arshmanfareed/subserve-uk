<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "subserve_co_uksubserve_beta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

