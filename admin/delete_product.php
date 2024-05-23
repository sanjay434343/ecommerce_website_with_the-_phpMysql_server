<?php
include('../includes/connect.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete the product record
    $delete_product = "DELETE FROM products WHERE product_id = '$product_id'";
    $result_query = mysqli_query($con, $delete_product);

    if (!$result_query) {
        die("Query Failed: " . mysqli_error($con));
    } else {
        echo "<script>alert('Product deleted successfully.');</script>";
        echo "<script>window.location.href = document.referrer;</script>";
        // Alternatively, you can use history.back() to go back one page:
        // echo "<script>window.history.back();</script>";
    }
} else {
    echo "Invalid request.";
}
?>
