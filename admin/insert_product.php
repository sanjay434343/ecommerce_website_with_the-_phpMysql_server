<?php
include('../includes/connect.php');

if (isset($_POST['insert_product'])) {
    $product_titile = $_POST['product_titile'];
    $description = $_POST['description'];
    $product_keywords = $_POST['product_keywords'];
    $product_categories = $_POST['product_categories'];
    $product_brands = $_POST['product_brands'];
    $product_price = $_POST['product_price'];
    $product_status = 'true';

    $product_image1 = $_FILES['product_image1']['name'];
    $temp_image1 = $_FILES['product_image1']['tmp_name'];

    if ($product_titile == '' or $description == '' or $product_keywords == '' or $product_categories == '' or $product_brands == '' or $product_price == '' or $product_image1 == '') {
        echo "<script>alert('Fill All The Fields')</script>";
        exit();
    } else {
        move_uploaded_file($temp_image1, "product_image/$product_image1");
        $insert_product = "INSERT INTO products (product_titile, product_description, product_keywords, category_id, brand_id, product_image1, product_price, date, status) 
        VALUES ('$product_titile', '$description', '$product_keywords', '$product_categories', '$product_brands', '$product_image1', '$product_price', NOW(), '$product_status')";

        $result_query = mysqli_query($con, $insert_product);

        if (!$result_query) {
            die("Query Failed: " . mysqli_error($con));
        } else {
            echo "<script>alert('Success')</script>";
            
            // Redirect to index.php
            header("Location: index.php?insert_product");
            exit();
        }
    }
}
?>







	



    <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
 
    <style>
       
       #description {
            height: 100px;
          
        }
      


h1 {
    color: #333;
}



label {
    font-weight: bold;
    display: block;
}

input[type="text"],
input[type="number"],
input[type="file"],
select {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
} 

input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
    
  </head>
  <body class="bg-light">
  <div style="max-width: 1000px; ">
    <h1>Insert Product</h1>

    <form action="insert_product.php" method="post" enctype="multipart/form-data">

        <div style="margin-bottom: 20px;">
            <label for="product_titile">Product Title:</label><br>
            <input type="text" name="product_titile" id="product_titile" placeholder="Enter Product Title" required="required">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="description">Product Description:</label><br>
            <input type="text" name="description" id="description" placeholder="(1.Brand Name , 2.Product name and description , 3.Warranty)" required="required">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="product_keywords">Product keyword:</label><br>
            <input type="text" name="product_keywords" id="product_keywords" placeholder="Enter Product keyword" required="required">
        </div>

        <!-- Categories -->
        <div style="margin-bottom: 20px;">
            <label for="product_categories">Select Categories:</label><br>
            <select name="product_categories" id="product_categories">
                <option value="">Select Categories</option>
                <?php
                $select_query = "SELECT * FROM categories";
                $result_query = mysqli_query($con, $select_query);

                while ($row = mysqli_fetch_assoc($result_query)) {
                    $category_id = $row['category_id'];
                    $category_title = $row['category_title'];
                    echo "<option value='$category_id'>$category_title</option>";
                }
                ?>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="product_brands">Select brand:</label><br>
            <select name="product_brands" id="product_brands">
                <option value="">Select brand</option>
                <?php
                $select_query = "SELECT * FROM brands";
                $result_query = mysqli_query($con, $select_query);

                while ($row = mysqli_fetch_assoc($result_query)) {
                    $brand_id = $row['brand_id'];
                    $brand_title = $row['brand_title'];
                    echo "<option value='$brand_id'>$brand_title</option>";
                }
                ?>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="product_image1">Uploaded Product Image:</label><br>
            <input type="file" name="product_image1" id="product_image1" required="required">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="product_price">Product Price:</label><br>
            <input type="number" name="product_price" id="product_price" placeholder="Enter Product Price" required="required">
        </div>

        <div style="margin-bottom: 20px;">
            <input type="submit"   name="insert_product" id="insert_product" value="Submit">
        </div>
    </form>
</div>

  </body>
  </html>