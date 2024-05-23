<?php
include('../includes/connect.php');

function updateProductImage($con, $product_id, $new_image) {
    $target_dir = "../admin/product_image/";
    $target_file = $target_dir . basename($new_image["name"]);

    // Validate file type
    $allowed_types = array("jpg", "jpeg", "png", "gif");
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_types)) {
        return "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    // Move the uploaded file
    if (move_uploaded_file($new_image["tmp_name"], $target_file)) {
        // Assign the result of basename to a variable
        $new_image_name = basename($new_image["name"]);

        // Update the database with the new image filename
        $update_query = "UPDATE product SET product_image1 = ? WHERE product_id = ?";
        $stmt = mysqli_prepare($con, $update_query);

        // Pass the variable to mysqli_stmt_bind_param
        mysqli_stmt_bind_param($stmt, "si", $new_image_name, $product_id);
        mysqli_stmt_execute($stmt);

        return "The image has been updated successfully.";
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'] ?? null;

    if ($product_id !== null) {
        $new_image = $_FILES["new_image"] ?? null;

        if ($new_image !== null && $new_image["error"] == 0) {
            $updateMessage = updateProductImage($con, $product_id, $new_image);

            // Display an alert using JavaScript
            echo "<script>alert('$updateMessage');</script>";

            // Fetch updated product details
            $select_product = "SELECT * FROM product WHERE product_id = '$product_id'";
            $result_product = mysqli_query($con, $select_product);

            if (mysqli_num_rows($result_product) > 0) {
                $row = mysqli_fetch_assoc($result_product);
                $product_title = $row['product_title']; // Fixed variable name
                $product_image = $row['product_image1'];
            } else {
                echo "Product not found.";
                exit;
            }
        } else {
            echo "Please select a file to upload.";
        }
    } else {
        echo "Product ID not provided.";
    }
}

// Fetch product details for display
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $select_product = "SELECT * FROM product WHERE product_id = '$product_id'";
    $result_product = mysqli_query($con, $select_product);

    if (mysqli_num_rows($result_product) > 0) {
        $row = mysqli_fetch_assoc($result_product);
        $product_title = $row['product_title']; // Fixed variable name
        $product_image = $row['product_image1'];
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    // Product ID not provided, display a list of products for editing
    $select_all_products = "SELECT * FROM product";
    $result_all_products = mysqli_query($con, $select_all_products);

    if (mysqli_num_rows($result_all_products) > 0) {
        echo "<h2>Select a product to edit:</h2>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result_all_products)) {
            echo "<li><a href='edit_image.php?id={$row['product_id']}'>{$row['product_title']}</a></li>"; // Fixed variable name
        }
        echo "</ul>";
    } else {
        echo "No products found.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product Image</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            margin-bottom: 20px;
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
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #545b62;
            border-color: #545b62;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-3 p-2">
    <h1 class="text-center">Edit Product Image</h1>

    <div class="card mb-3">
        <img src='./admin/product_image/<?php echo $product_image; ?>' class='card-img-top' alt='Product Image'>
        <div class='card-body'>
            <h5 class='card-title'><?php echo $product_title; ?></h5>

            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $product_id; ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="new_image" class="form-label">Choose New Image:</label>
                    <input type="file" class="form-control" id="new_image" name="new_image" accept="image/*" required>
                </div>
                <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                <button type="submit" class="btn btn-primary">Update Image</button>
            </form>
            <br>
            <a href='index.php?product_list' class='btn btn-secondary'>Back to View Products</a>
        </div>
    </div>
</div>

</body>
</html>
