<?php
include('../includes/connect.php');

// Fetch product count by brand
$select_brand_count = "SELECT brands.brand_title, COUNT(products.product_id) AS count FROM brands
                        LEFT JOIN products ON brands.brand_id = products.brand_id
                        GROUP BY brands.brand_id";
$result_brand_count = mysqli_query($con, $select_brand_count);
$brand_data = array();
while ($row = mysqli_fetch_assoc($result_brand_count)) {
    $brand_data[$row['brand_title']] = $row['count'];
}

// Fetch product count by category
$select_category_count = "SELECT categories.category_title, COUNT(products.product_id) AS count FROM categories
                            LEFT JOIN products ON categories.category_id = products.category_id
                            GROUP BY categories.category_id";
$result_category_count = mysqli_query($con, $select_category_count);
$category_data = array();
while ($row = mysqli_fetch_assoc($result_category_count)) {
    $category_data[$row['category_title']] = $row['count'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Statistics</title>
    <style> body {
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

.empty-container {
    max-width: 600px;
    margin: 0px; /* Adjust the margin as needed */
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
}

/* Add other styles as needed */

</style>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="empty-container" id="myEmptyContainer">
<div class="container mt-3 p-2">
    <h1 class="text-center">Product Statistics</h1>

    <!-- Brand Pie Chart -->
    <div class="row">
        <div class="col-md-6">
            <h2 class="text-center">By Brand</h2>
            <canvas id="brandChart" width="400" height="400"></canvas>
        </div>

        <!-- Category Pie Chart -->
        <div class="col-md-6">
            <h2 class="text-center">By Category</h2>
            <canvas id="categoryChart" width="400" height="400"></canvas>
        </div>
    </div>
</div>

        <!-- You can add content or manipulate this container using JavaScript -->
    </div>
<script>
// JavaScript to create pie charts using Chart.js
document.addEventListener('DOMContentLoaded', function () {
    // Brand Pie Chart
    var brandData = <?php echo json_encode($brand_data); ?>;
    var brandChartCanvas = document.getElementById('brandChart').getContext('2d');
    var brandChart = new Chart(brandChartCanvas, {
        type: 'pie',
        data: {
            labels: Object.keys(brandData),
            datasets: [{
                data: Object.values(brandData),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF5733'],
            }],
        },
    });

    // Category Pie Chart
    var categoryData = <?php echo json_encode($category_data); ?>;
    var categoryChartCanvas = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(categoryChartCanvas, {
        type: 'pie',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                data: Object.values(categoryData),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF5733'],
            }],
        },
    });
});
</script>

</body>
</html>
