<?php
include('../includes/connect.php');

if(isset($_POST['edit_brand'])) {
    $editBrandId = mysqli_real_escape_string($con, $_POST['brand_id']);
    $newBrandTitle = mysqli_real_escape_string($con, $_POST['new_brand_title']);

    // Perform the update
    $updateQuery = "UPDATE brands SET brand_title = '$newBrandTitle' WHERE brand_id = $editBrandId";
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        echo 'success';
        exit();
    } else {
        echo "Error updating brand: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}
?>
