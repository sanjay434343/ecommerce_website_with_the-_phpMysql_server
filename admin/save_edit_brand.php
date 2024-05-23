<?php
include('../includes/connect.php');

// Check if the request contains the necessary parameters
if (isset($_POST['productId']) && isset($_POST['newBrandId'])) {
    $productId = $_POST['productId'];
    $newBrandId = $_POST['newBrandId'];

    // Update the product's brand in the database
    $updateQuery = "UPDATE product SET brand_id = '$newBrandId' WHERE product_id = '$productId'";
    $updateResult = mysqli_query($con, $updateQuery);

    if ($updateResult) {
        // Success
        $response = array('success' => true);
    } else {
        // Error
        $response = array('success' => false);
    }
} else {
    // Invalid request
    $response = array('success' => false);
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
mysqli_close($con);
?>
