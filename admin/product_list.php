<?php
include('../includes/connect.php');

// Fetch all products from the database
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
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-img-top {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            height: 300px;
            object-fit: contain;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-3 p-2">
    <h1 class="text-center">View Products</h1>

    <?php
    if(mysqli_num_rows($result_products) > 0) {
        while ($row = mysqli_fetch_assoc($result_products)) {
            $product_titile = $row['product_titile'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            $product_image = $row['product_image1'];
            $product_id = $row['product_id'];

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

            // Display product details with a single button
            echo "
            <div class='card mb-3'>
                <img src='./product_image/$product_image' class='card-img-top' alt='Product Image'>
                <div class='card-body'>
                    <h5 class='card-title'>$product_titile</h5>
                    <p class='card-text'><strong>Category:</strong> $category_title</p>
                    <p class='card-text'><strong>Brand:</strong> $brand_title</p>
                    <a href='edit_image.php?id=$product_id' class='btn btn-secondary'>Update Image</a>
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
