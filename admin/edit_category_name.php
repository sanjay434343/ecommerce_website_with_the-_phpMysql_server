<?php
include('../includes/connect.php');

if(isset($_POST['edit_category'])) {
    $editCategoryId = mysqli_real_escape_string($con, $_POST['category_id']);
    $newCategoryTitle = mysqli_real_escape_string($con, $_POST['new_category_title']);

    // Perform the update
    $updateQuery = "UPDATE categories SET category_title = '$newCategoryTitle' WHERE category_id = $editCategoryId";
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        echo 'success';
        exit();
    } else {
        echo "Error updating category: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}
?>
