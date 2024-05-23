<?php
include('../includes/connect.php');

// Fetch products from the database
$query = "SELECT * FROM product";
$result = mysqli_query($con, $query);

// Check if there are any products
if (mysqli_num_rows($result) > 0) {
    // Output product data as JSON (you can modify this based on your needs)
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    echo json_encode(['success' => true, 'products' => $products]);
} else {
    echo json_encode(['success' => false, 'message' => 'No products found.']);
}

// Close the database connection
mysqli_close($con);
?>
