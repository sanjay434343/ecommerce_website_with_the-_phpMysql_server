<?php
include('../includes/connect.php');

// Check if a category delete request is received
if (isset($_GET['delete_category'])) {
    $deleteCategoryId = mysqli_real_escape_string($con, $_GET['delete_category']);
    
    // Perform the deletion
    $deleteQuery = "DELETE FROM categories WHERE category_id = $deleteCategoryId";
    $result = mysqli_query($con, $deleteQuery);

    if ($result) {
        // Redirect to the same page after successful deletion
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error deleting category: " . mysqli_error($con);
    }
}

// Fetch categories from the database
$selectCategories = "SELECT * FROM categories";
$resultCategories = mysqli_query($con, $selectCategories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Products</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Your existing styles */
        .list {
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
            border: 1px solid #ddd;
            margin-bottom: 5px;
            list-style: none; /* Remove list symbol */
        }

        .delete-btn, .edit-btn, .rename-btn {
            margin-left: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Category Products</h1>

    <!-- Display categories as a list -->
    <ul id="categoryList">
        <?php
    
        // ... your existing PHP/HTML code
        
        while ($row = mysqli_fetch_assoc($resultCategories)) {
            echo "<div class='list'>
                    <span onclick=\"getCategoryProducts({$row['category_id']})\">{$row['category_title']}</span>
                    <button class='delete-btn' onclick=\"deleteCategory({$row['category_id']})\">Delete</button>
                    <button class='edit-btn' onclick=\"toggleEditForm({$row['category_id']}, '{$row['category_title']}')\">Edit</button>
                    <div id='editForm{$row['category_id']}' class='edit-form' style='display:none;'>
                        <input type='text' id='newCategoryTitle{$row['category_id']}' placeholder='New Category Title' class='input'>
                        <button onclick=\"editCategory({$row['category_id']})\" class='save-btn'>Save</button>
                    </div>
                  </div>";
        }
        ?>
        
    </ul>

    <!-- Display products for the selected category -->
    <div id="productList"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Function to handle renaming the category
    function renameCategory(categoryId) {
        var newName = prompt("Enter the new category name:");

        if (newName !== null && newName !== "") {
            $.ajax({
                type: 'POST',
                url: 'rename_category.php',
                data: {
                    category_id: categoryId,
                    new_name: newName
                },
                success: function (data) {
                    alert(data);
                    // Reload the page to reflect changes
                    location.reload();
                },
                error: function () {
                    alert('Error renaming category.');
                }
            });
        }
    }

    // Function to handle editing the category (you can implement the edit functionality)
    function editCategory(categoryId) {
        // Implement the code for editing the category as needed
        alert('Edit category function to be implemented.');
    }

    // Your existing JavaScript code
    function getCategoryProducts(categoryId) {
        // ... (unchanged)
    }

    function deleteCategory(categoryId) {
        // ... (unchanged)
    }

    function toggleEditForm(categoryId, currentTitle) {
    $('#editForm' + categoryId).toggle();
    $('#newCategoryTitle' + categoryId).val(currentTitle);
    $('.save-btn').hide(); // Hide all Save buttons
    $('.edit-btn').show(); // Show all Edit buttons
    $('#editForm' + categoryId + ' button').show(); // Show all buttons in the current category's edit form
}

function editCategory(categoryId) {
    var newCategoryTitle = $('#newCategoryTitle' + categoryId).val();
    if (newCategoryTitle !== "") {
        $.ajax({
            type: 'POST',
            url: 'edit_category_name.php',
            data: { edit_category: true, category_id: categoryId, new_category_title: newCategoryTitle },
            success: function (response) {
                if (response === 'success') {
                    // Refresh the page after successful edit
                    location.reload();
                } else {
                    alert('Error updating category: ' + response);
                }
            },
            error: function () {
                alert('Error updating category.');
            }
        });
    }
}

</script>
</body>
</html>

<style>
       .list {
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px;
    border: 1px solid #ddd;
    margin-bottom: 5px;
    list-style: none; /* Remove list symbol */
}

.delete-btn {
    background-color: #ff0000;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

       /* Add this to your existing styles.css or create a new CSS file */

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

.input {
    width: 70%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

/* Adjust the styles based on your design preferences */
 
        /* Add this to your existing styles.css or create a new CSS file */

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

        /* Add more styling as needed based on your specific requirements */
    </style>