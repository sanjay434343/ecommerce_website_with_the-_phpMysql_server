<?php
include('../includes/connect.php');


if (isset($_GET['brand_id'])) {
    $brandId = $_GET['brand_id'];

    // Fetch current brand name
    $brandQuery = "SELECT brand_title FROM brands WHERE brand_id = '$brandId'";
    $brandResult = mysqli_query($con, $brandQuery);
    $brandRow = mysqli_fetch_assoc($brandResult);
    $currentBrandName = ($brandRow) ? $brandRow['brand_title'] : 'Unknown Brand';

    // Fetch products for the selected brand
    $query = "SELECT * FROM product WHERE brand_id = '$brandId'";
    $result = mysqli_query($con, $query);

    // Check if there are any products
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="product-container">'; // Open the container for products
        while ($row = mysqli_fetch_assoc($result)) {
            $productImage1 = $row['product_image1'];
            $productTitile = $row['product_titile'];
            $productPrice = $row['product_price'];
            $productId = $row['product_id'];

            // Add a dropdown for brand selection
            $brandDropdown = "<select id='brandSelect{$productId}'>";
            $brandDropdown .= "<option value='{$brandId}' selected>{$currentBrandName}</option>";
            // Fetch all brands from your database and populate the dropdown
            $brandsQuery = "SELECT * FROM brands";
            $brandsResult = mysqli_query($con, $brandsQuery);
            while ($brandRow = mysqli_fetch_assoc($brandsResult)) {
                $brandIdOption = $brandRow['brand_id'];
                $brandTitleOption = $brandRow['brand_title'];
                $brandDropdown .= "<option value='{$brandIdOption}'>{$brandTitleOption}</option>";
            }
            $brandDropdown .= "</select>";

            echo "
            <div class='product-card'>
                <img src='./product_image/{$productImage1}' alt='Product Image' style='width:500px; height: auto; border-radius: 30px;'>
                <h3>{$productTitile}</h3>
                <p>Price: {$productPrice}</p>
                <p>Brand: {$brandDropdown}</p>
                <button onclick='saveEdit({$productId}, \"brandSelect{$productId}\")'>Save</button>
            </div>";
        }
        echo '</div>'; // Close the container for products
    } else {
        echo "<p>No products found for this brand.</p>";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($con);
?>

<script>
    function saveEdit(productId, dropdownId) {
        var newBrandId = document.getElementById(dropdownId).value;

        // Send the productId and newBrandId to a script for processing (you need to create this script)
        // Example using fetch API:
        fetch('save_edit_brand.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'productId=' + encodeURIComponent(productId) + '&newBrandId=' + encodeURIComponent(newBrandId),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Edit saved successfully!');
                // You may want to reload the page or update the UI accordingly
            } else {
                alert('Failed to save edit.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

<style>
  .product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 20px;
  }

  .product-card {
    width: 500px;
    max-width: 1000px;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    border-radius: 30px;
  }

  .product-card:hover {
    transform: scale(1.05);
  }

  .product-card img {
    width:500px;
    border-radius: 30px;
    object-fit: contain;

  }

  .product-card .card-body {
    padding: 15px;
  }

  .product-card h5 {
    font-size: 1.2rem;
    margin-bottom: 10px;
  }

  .product-card p {
    font-size: 1rem;
    margin-bottom: 10px;
    align-items: center;
  }

  .product-card button {
    background-color: #ffc107;
    color: white;
    font-weight: bolder;
    border: none;
    padding: 8px 15px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;

    
  }

  .product-card button:hover {
    background-color: #ffca28;
  }


/* Add this to your existing CSS styles */

.product-card select {
    width: 40%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.product-card select:hover {
    border-color: #999;
}

.product-card select:focus {
    outline: none;
    border-color: #ffca28;
    box-shadow: 0 0 5px rgba(255, 202, 40, 0.8);
}




  
</style>

