<?php
include('../includes/connect.php');

// Check if a brand delete request is received
if (isset($_GET['delete_brand'])) {
    $deleteBrandId = mysqli_real_escape_string($con, $_GET['delete_brand']);

    // Perform the deletion
    $deleteQuery = "DELETE FROM brands WHERE brand_id = $deleteBrandId";
    $result = mysqli_query($con, $deleteQuery);

    if ($result) {
        // Redirect to the same page after successful deletion
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error deleting brand: " . mysqli_error($con);
    }
}

// Check if a brand edit request is received
if (isset($_POST['edit_brand'])) {
    $editBrandId = mysqli_real_escape_string($con, $_POST['brand_id']);
    $newBrandTitle = mysqli_real_escape_string($con, $_POST['new_brand_title']);

    // Perform the update using prepared statement
    $updateQuery = "UPDATE brands SET brand_title = ? WHERE brand_id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "si", $newBrandTitle, $editBrandId);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Redirect to the same page after successful update
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error updating brand: " . mysqli_error($con);
    }
}

// Fetch brands from the database
$selectBrands = "SELECT * FROM brands";
$resultBrands = mysqli_query($con, $selectBrands);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Products</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .list {
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }

        .delete-btn {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .edit-form {
            display: none;
            margin-top: 10px;
        }

        /* Styles for product cards */
        .product-card {
            margin: 10px;
        }

        .product-card img {
            width: 100%;
            height: auto;
        }

        .product-card .card {
            transition: transform 0.3s;
        }

        .product-card .card:hover {
            transform: scale(1.05);
        }

        .product-card .card-body {
            text-align: center;
        }

        .product-card .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-card .card-text {
            max-height: 2em;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .product-card .btn {
            margin-right: 5px;
        }

        .edit-btn
{
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    margin-right: 5px;
}

.edit-btn
{
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 10px;
    cursor: pointer;
    margin-right: 5px;
}

.save-btn {
    background-color: green;
    color: #fff;
    border: none;
    padding: 8px 10px;
    cursor: pointer;
    margin-right: 5px;
    border-radius: 4px;
}

/* Add this to your existing styles.css or create a new CSS file */

.input {
    width: 70%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

/* Adjust the styles based on your design preferences */

    </style>
</head>
<body>
<div class="container">
    <h1>Brand Products</h1>

    <!-- Display brands as a list -->
    <ul id="brandList">
        <?php
        while ($row = mysqli_fetch_assoc($resultBrands)) {
            echo "<div class='list'>
                    <span onclick=\"getBrandProducts({$row['brand_id']})\">{$row['brand_title']}</span>
                    <button class='delete-btn' onclick=\"deleteBrand({$row['brand_id']})\">Delete</button>
                    <button class='edit-btn' onclick=\"toggleEditForm({$row['brand_id']}, '{$row['brand_title']}')\">Edit</button>
                    <div id='editForm{$row['brand_id']}' class='edit-form'>
                        <input type='text' id='newBrandTitle{$row['brand_id']}' placeholder='New Brand Title' class='input'>
                        <button onclick=\"editBrand({$row['brand_id']})\" class='save-btn'>Save</button>
                    </div>
                  </div>";
        }
        ?>
    </ul>

    <!-- Display products for the selected brand -->
    <div id="productList"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function getBrandProducts(brandId) {
        if (brandId !== "") {
            $.ajax({
                type: 'GET',
                url: 'get_brand_products.php',
                data: { brand_id: brandId },  // Send the brand_id as data
                success: function (data) {
                    $('#productList').html(data);
                },
                error: function () {
                    alert('Error loading products.');
                }
            });
        } else {
            // Clear the product list if no brand is selected
            $('#productList').html('');
        }
    }

    function deleteBrand(brandId) {
        if (confirm('Are you sure you want to delete this brand?')) {
            window.location.href = 'delete_brand.php?delete_brand=' + brandId;
        }
    }

    function toggleEditForm(brandId, currentTitle) {
        $('#editForm' + brandId).toggle();
        $('#newBrandTitle' + brandId).val(currentTitle);
    }

    function editBrand(brandId) {
        var newBrandTitle = $('#newBrandTitle' + brandId).val();
        if (newBrandTitle !== "") {
            $.ajax({
                type: 'POST',
                url: 'edit_brand_name.php',
                data: { edit_brand: true, brand_id: brandId, new_brand_title: newBrandTitle },
                success: function (response) {
                    if (response === 'success') {
                        // Refresh the page after successful edit
                        location.reload();
                    } else {
                        alert('Error updating brand: ' + response);
                    }
                },
                error: function () {
                    alert('Error updating brand.');
                }
            });
        }
    }
</script>

</body>
</html>
