<?php
include('../includes/connect.php');

if(isset($_POST['update_product'])) {
    // Get form data
    $product_id = $_POST['product_id'];
    $product_title = mysqli_real_escape_string($con, $_POST['product_titile']);
    $product_description = mysqli_real_escape_string($con, $_POST['product_description']);
    $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
    $product_price = $_POST['product_price'];

    // Update product details in the database
    $update_product_query = "UPDATE product SET
                             product_description = '$product_description',
                             product_keywords = '$product_keywords',
                             product_price = '$product_price'
                             WHERE product_id = '$product_id'";

    $result = mysqli_query($con, $update_product_query);

    if($result) {
        echo "<script>alert('Product updated successfully.');</script>";
        echo "<script>window.location.href = 'index.php?view';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating product: " . mysqli_error($con) . "');</script>";
    }
}
?>
