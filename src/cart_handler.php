<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {
    if ($_POST["action"] === "add_to_cart" && isset($_POST["item"])) {
        $item = $_POST["item"];

        // Initialize the cart if it doesn't exist
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        // Add the item to the cart
        $_SESSION["cart"][] = $item;

        // Return a response to indicate success and provide cart details
        echo json_encode(["message" => "Item added to cart successfully", "cart_count" => count($_SESSION["cart"])]);
    } elseif ($_POST["action"] === "remove_from_cart" && isset($_POST["productId"])) {
        $productId = $_POST["productId"];

        // Check if the product exists in the cart based on the product ID
        if (isset($_SESSION["cart"][$productId])) {
            // Remove the product from the cart
            unset($_SESSION["cart"][$productId]);

            // Return a response to indicate success and provide updated cart details
            echo json_encode(["message" => "Product removed from cart successfully"]);
        } else {
            // Handle the case where the product was not found in the cart
            echo json_encode(["message" => "Product not found in cart"]);
        }
    } elseif ($_POST["action"] === "update_quantity" && isset($_POST["productId"]) && isset($_POST["quantity"])) {
        $productId = $_POST["productId"];
        $newQuantity = $_POST["quantity"];

        // Check if the product exists in the cart based on the product ID
        if (isset($_SESSION["cart"][$productId])) {
            // Update the quantity for the product in the cart
            $_SESSION["cart"][$productId]['quantity'] = $newQuantity;

            // Return a response to indicate success
            echo json_encode(["message" => "Quantity updated successfully"]);
        } else {
            // Handle the case where the product was not found in the cart
            echo json_encode(["message" => "Product not found in cart"]);
        }
    }

}
?>
