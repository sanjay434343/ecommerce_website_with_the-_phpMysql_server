<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Add your CSS styles here -->
    <link rel="stylesheet" href="styles.css">
    
    <!-- Add your JavaScript script here -->
    <script>
        function addToCart(product_id, product_title, product_image, product_price) {
            // Create an object representing the product
            var product = {
                'id': product_id,
                'title': product_title,
                'image': product_image,
                'price': product_price
            };

            // Send the product to cart.php using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify(product));

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response if needed
                }
            };
        }
    </script>
    
    <style>
        /* Add your CSS styles here */
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

        .cart-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        /* Add other styles as needed */
    </style>
</head>
<body>
    <!-- Rest of your HTML content -->
</body>
</html>
