<?php

include('../includes/connect.php');

if(isset($_POST['insert_brand'])){
    $brand_title = $_POST['brand_title']; // Change $post to $_POST

    $select_query = "SELECT * FROM brands WHERE brand_title='$brand_title'"; // Corrected SELECT statement
    $result_select = mysqli_query($con, $select_query);
    $number = mysqli_num_rows($result_select);

    if($number > 0){
        echo "<script>alert('THIS BRAND IS ALREADY PRESENT IN THE DATABASE')</script>"; // Corrected the alert message
    } else {
        $insert_query = "INSERT INTO brands (brand_title) VALUES ('$brand_title')"; // Remove quotes around table name and use uppercase INSERT INTO
        $result = mysqli_query($con, $insert_query); // Correct the function name

        if($result){
            echo "<script>alert('BRAND HAS BEEN INSERTED SUCCESSFULLY')</script>"; // Corrected the spelling of 'successfully'
         }
    }
}
?>


<h2 class="text-center p-3">Insert Your New Brands</h2>
<form action="" method="post" class="mb2">

<div class="input-group w-90  mb-3">
    <span class="input-group-text bg-info " id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
    <input type="text" class="form-control" name="brand_title" placeholder="Insert brands" aria-label="brands" aria-describedby="basic-addon1">
        
</div>

<div class="input-group w-10  mb-1 m-auto">
<input type="submit" class="bg-info text-light border-0 p-2 mr-3"  name="insert_brand" value="Insert brand">
            
</div>


</form>