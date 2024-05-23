<?php
session_start();
include('./includes/connect.php');

// Check if the cart array is not initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add product to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    $product = array(
        'id' => $data->id,
        'title' => $data->title,
        'image' => $data->image,
        'price' => $data->price
    );

    // Check if the product is already in the cart
    if (!in_array($product, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $product;
    }
}

// ... rest of your code
?>
