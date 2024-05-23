<?php
include('../includes/connect.php');

// Fetch all products from the database, ordered by product_id in descending order
$select_products = "SELECT * FROM products ORDER BY product_id DESC";
$result_products = mysqli_query($con, $select_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container mt-3 p-2">
    <h1 class="text-center">View Products</h1>

    <?php
    if(mysqli_num_rows($result_products) > 0) {
        while ($row = mysqli_fetch_assoc($result_products)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_titile'];
            $product_description = $row['product_description'];
            $product_keywords = $row['product_keywords'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            $product_image = $row['product_image1'];
            $product_price = $row['product_price'];

            // Fetch category title
            $select_category = "SELECT category_title FROM categories WHERE category_id = '$category_id'";
            $result_category = mysqli_query($con, $select_category);
            $category_row = mysqli_fetch_assoc($result_category);
            $category_title = $category_row['category_title'];

            // Fetch brand title
            $select_brand = "SELECT brand_title FROM brands WHERE brand_id = '$brand_id'";
            $result_brand = mysqli_query($con, $select_brand);
            $brand_row = mysqli_fetch_assoc($result_brand);
            $brand_title = $brand_row['brand_title'];

            // Display product details with edit and delete buttons
            echo "
            <div class='card mb-3'>
                <div class='row g-0'>
                    <div class='col-md-4'>
                        <img src='./product_image/$product_image' class='img-fluid rounded-start' alt='Product Image'>
                    </div>
                    <div class='col-md-8'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'><strong>Description:</strong> $product_description</p>
                            <p class='card-text'><strong>Keywords:</strong> $product_keywords</p>
                            <p class='card-text'><strong>Category:</strong> $category_title</p>
                            <p class='card-text'><strong>Brand:</strong> $brand_title</p>
                            <p class='card-text'><strong>Price:</strong> $product_price</p>
                            <div class='d-flex justify-content-between'>
                             
                                <a href='delete_product.php?id=$product_id' class='btn btn-danger'>Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
        }
    } else {
        echo "<p class='text-center'>No products found.</p>";
    }
    ?>
</div>

</body>
</html>
