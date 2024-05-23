<?php
include('../includes/connect.php');

if (isset($_POST['product_id']) && isset($_POST['new_category_id'])) {
    $productId = $_POST['product_id'];
    $newCategoryId = $_POST['new_category_id'];

    // Update the category of the product in the database
    $updateQuery = "UPDATE product SET category_id = '$newCategoryId' WHERE product_id = '$productId'";
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        echo "Category updated successfully!";
    } else {
        echo "Error updating category: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($con);
?>
