<?php

include('./includes/connect.php');

// Function to redirect to index.php
echo "<script>
        function redirectToIndex() {
            window.location.href = 'index.php';
        }
        
        function showAllProducts() {
            window.location.href = 'index.php';
        }

        function toggleDescription(productId, event) {
            event.preventDefault(); // Prevent the default behavior

            var descriptionElement = document.getElementById('description_' + productId);
            var toggleButton = document.getElementById('toggleButton_' + productId);
            
            if (descriptionElement.style.maxHeight === 'none' || descriptionElement.style.maxHeight === '') {
                descriptionElement.style.maxHeight = '2em'; // Show only the first two lines
                toggleButton.innerHTML = 'View More';
            } else {
                descriptionElement.style.maxHeight = 'none'; // Show complete description
                toggleButton.innerHTML = 'View Less';
            }
        }
      </script>";

// Function to get products based on category or brand
function getproducts(){
    global $con;

    // Check if category or brand is set in the URL
    if(isset($_GET['category'])){
        $category_id = $_GET['category'];
        $select_query = "SELECT * FROM product WHERE category_id = $category_id ORDER BY RAND()";
    } elseif(isset($_GET['brand'])){
        $brand_id = $_GET['brand'];
        $select_query = "SELECT * FROM product WHERE brand_id = $brand_id ORDER BY RAND()";
    } else {
        // If neither category nor brand is set, display all products in random order
        $select_query = "SELECT * FROM products ORDER BY RAND()";
    }

    $result_query = mysqli_query($con, $select_query);
    $num_of_rows = mysqli_num_rows($result_query);

    if ($num_of_rows === 0) {
        echo "<h2>No products found</h2>";
    }

    while($row = mysqli_fetch_assoc($result_query)) {
        $product_id = $row['product_id'];
        $product_titile = $row['product_titile'];
        $product_description = $row['product_description'];
        $product_keywords = $row['product_keywords'];
        $brand_id = $row['brand_id'];
        $product_image1 = $row['product_image1'];
        $product_price = $row['product_price'];

        echo "<div class='col-md-4'>
                <div class='card' style='aspect-ratio: 1/1;'>
                <img src='./admin/product_image/$product_image1' class='card-img-top' alt='...' style='object-fit: contain; max-width: 220%; max-height: 200%;'>

                    <div class='card-body'>
                        <h5 class='card-title'>$product_titile</h5>
                        <p class='card-text' id='description_$product_id' style='max-height: 2em; overflow: hidden;'>$product_description</p>
                        <a href='#' class='btn btn-primary'>Add To Cart</a>
                        <a href='#' class='btn btn-primary' id='toggleButton_$product_id' onclick='toggleDescription($product_id, event)'>View More</a>
                    </div>
                </div>
            </div>";
    }
}




// Function to get unique categories and display products
function get_unique_categories(){
    global $con;

    if(isset($_GET['category'])){
        $category_id = $_GET['category'];

        $select_query = "SELECT * FROM product WHERE category_id = $category_id";
        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);

        if($num_of_rows == 0){
            echo "<h2>No products in this category</h2>";
            echo "<div><button onclick='redirectToIndex()' class='btn btn-primary'>Go to Home</button></div>";
        }

        while ($row = mysqli_fetch_assoc($result_query)) {
            $product_id = $row['product_id'];
            $product_titile = $row['product_titile'];
            $product_description = $row['product_description'];
            $product_keywords = $row['product_keywords'];
            $brand_id = $row['brand_id'];
            $product_image1 = $row['product_image1'];
            $product_price = $row['product_price'];

            echo "<div class='col-md-4 mb-2 ms-2'>
                    <div class='card'>
                    <img src='./admin/product_image/$product_image1' class='card-img-top' alt='...' style='object-fit: contain; max-width: 220%; max-height: 200%;'>

                        <div class='card-body'>
                            <h5 class='card-title'>$product_titile</h5>
                            <p class='card-text' id='description_$product_id'  overflow: hidden;'>$product_description</p>
                            <a href='#' class='btn btn-primary'>Add To Cart</a>
                            <a href='#' class='btn btn-primary' id='toggleButton_$product_id' onclick='toggleDescription($product_id, event)'>View More</a>
                        </div>
                    </div>
                </div>";
        }
    }
}


// ... (other functions)

// Function to get brands and display products
function getbrands(){
    global $con;

    $select_brands = "SELECT * FROM brands";
    $result_brands = mysqli_query($con, $select_brands);

    echo "<li class='nav-item'>
            <br><button onclick='showAllProducts()' class='btn btn-primary my-6'>Show All Products</button>
          </li>";

    while ($row_data = mysqli_fetch_assoc($result_brands)) {
        $brand_title = $row_data['brand_title'];
        $brand_id = $row_data['brand_id'];

        echo "<li class='nav-item'>
                <a href='index.php?brand=$brand_id' class='nav-link text-light'>$brand_title</a>
            </li>";
    }
}

// Function to get categories and display products
function getcategories(){
    global $con;
    $select_categories = "SELECT * FROM categories";
    $result_categories = mysqli_query($con, $select_categories);

    

    while ($row_data = mysqli_fetch_assoc($result_categories)) {
        $category_title = $row_data['category_title'];
        $category_id = $row_data['category_id'];

        echo "<li class='nav-item'>
                <a href='index.php?category=$category_id' class='nav-link text-light'>$category_title</a>
            </li>";
    }
}

// Function to search for products
// Function to search for products
function searchProduct()
{
    global $con;

    if (isset($_GET['search_data_product'])) {
        $searchDataProduct = mysqli_real_escape_string($con, $_GET['search_data_product']);
        $searchQuery = "SELECT * FROM products WHERE product_keywords LIKE '%$searchDataProduct%'";
        $resultQuery = mysqli_query($con, $searchQuery);

        if ($resultQuery) {
            if(mysqli_num_rows($resultQuery) > 0) {
                while ($row = mysqli_fetch_assoc($resultQuery)) {
                    $product_id = $row['product_id'];
                    $product_titile = $row['product_titile'];
                    $product_description = $row['product_description'];
                    $product_image1 = $row['product_image1'];

                    // Display the search results
                    echo "<div class='col-md-4 mb-2 ms-2'>
                        <div class='card'>
                        <img src='./admin/product_image/$product_image1' class='card-img-top' alt='...' style='object-fit: contain; max-width: 220%; max-height: 200%;'>

                            <div class='card-body'>
                                <h5 class='card-title'>$product_titile</h5>
                                <p class='card-text' id='description_$product_id' style='max-height: 2em; overflow: hidden;'>$product_description</p>
                                <a href='#' class='btn btn-primary'>Add To Cart</a>
                                <a href='#' class='btn btn-primary' id='toggleButton_$product_id' onclick='toggleDescription($product_id, event)'>View More</a>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No products found for '$searchDataProduct'</p>";
            }
        } else {
            // Handle the case where the query failed
            echo "Error in query: " . mysqli_error($con);
        }
    }
}


?>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #555;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 1px;
            margin: 0 10px;
            display: inline-block;
        }

        nav a:hover {
            background-color: #777;
        }

        .search-container {
            text-align: center;
            margin: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        input[type="text"] {
            padding: 10px;
            width: 200px;
            margin-right: 10px; /* Add margin to create some space between input and button */
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            width: 100px; /* Set a fixed width */
            height: 300px; /* Set a fixed height */
        }

        /* Styles for the dropdown */
        .dropdown {
            display: inline-block;
            margin-right: 20px;
        }

        .dropdown select {
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
        }

        .dropdown select:hover {
            background-color: #2980b9;
        }

        /* Custom styles for the dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
            margin-top: 30px;
        }

        .dropdown button {
            color: #fff;
            text-decoration: none;
            color: white;
            border: none;
            padding: 10px;
            margin: 0 10px;
            display: inline-block;
            color: #000000;
        }

        .dropdowns {
            display: none;
            position: absolute;
            color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-menu a {
            color: 0080ff;
            text-decoration: none;
            color: white;
            padding: 10px;
        }

        .dropdown:hover .dropdowns {
            display: block;
        }

        .dropdowns {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #000000;
        }

        .card-img-top {
    max-width: 900px;
    max-height: 900px;
    width: auto;
    height: auto;
    object-fit: contain;
}

    </style>
