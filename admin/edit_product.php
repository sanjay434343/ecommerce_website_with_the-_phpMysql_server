<?php
include('../includes/connect.php');

if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details for the given ID
    $select_product = "SELECT * FROM product WHERE product_id = '$product_id'";
    $result_product = mysqli_query($con, $select_product);

    if($result_product && mysqli_num_rows($result_product) == 1) {
        $row = mysqli_fetch_assoc($result_product);

        // Display the form for editing
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Product</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        </head>
        <body class="bg-light">

        <div class="container mt-3 p-2">
            <h1 class="text-center">Edit Product</h1>

            <form action="update_product.php" method="post">

                <!-- Display the existing details for editing -->
                <input type="hidden" name="product_id" value="<?php echo $row['product_id'] ?? ''; ?>">

                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_titile" class="form-label">Product title</label>
                    <input type="text" name="product_titile" id="product_titile" class="form-control"
                           value="<?php echo $row['product_titile'] ?? ''; ?>" autocomplete="off" required="required">
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_description" class="form-label">Product Description</label>
                    <input type="text" name="product_description" id="product_description" class="form-control"
                           value="<?php echo $row['product_description'] ?? ''; ?>" autocomplete="off" required="required">
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_keywords" class="form-label">Product Keywords</label>
                    <input type="text" name="product_keywords" id="product_keywords" class="form-control"
                           value="<?php echo $row['product_keywords'] ?? ''; ?>" autocomplete="off" required="required">
                </div>

                <!-- Price -->
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_price" class="form-label">Product Price</label>
                    <input type="text" name="product_price" id="product_price" class="form-control"
                           value="<?php echo $row['product_price'] ?? ''; ?>" autocomplete="off" required="required">
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <input type="submit" name="update_product" id="update_product"
                           class="btn bg-info mb-3 px-3 text-light w-100" value="Update">
                </div>
            </form>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid request.";
}
?>
