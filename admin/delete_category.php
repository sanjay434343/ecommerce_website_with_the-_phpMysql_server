<?php
include('../includes/connect.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_GET['delete_category'])) {
    $deleteCategoryId = mysqli_real_escape_string($con, $_GET['delete_category']);

    // Perform the deletion
    $deleteQuery = "DELETE FROM categories WHERE category_id = $deleteCategoryId";
    $result = mysqli_query($con, $deleteQuery);

    if ($result) {
        // Redirect back to the page where the deletion was triggered
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        echo "Error deleting category: " . mysqli_error($con);
    }
} else {
    // Redirect to the home page or any other fallback page if delete_category is not set
    header("Location: index.php?display_category");
    exit();
}
?>
