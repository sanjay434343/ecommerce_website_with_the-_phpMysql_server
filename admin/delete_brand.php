<?php
include('../includes/connect.php');

// Check if a brand delete request is received
if (isset($_GET['delete_brand'])) {
    $deleteBrandId = mysqli_real_escape_string($con, $_GET['delete_brand']);

    // Perform the deletion
    $deleteQuery = "DELETE FROM brands WHERE brand_id = $deleteBrandId";
    $result = mysqli_query($con, $deleteQuery);

    if ($result) {
        // Redirect to the same page after successful deletion
        header("Location:index.php");
        exit();
    } else {
        echo "Error deleting brand: " . mysqli_error($con);
    }
}
?>
