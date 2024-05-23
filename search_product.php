<?php
include('./includes/connect.php');

include('common_function.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Clone</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Reset default margin and padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Basic styles */
body {
    font-family: Arial, sans-serif;
    background-color: #fafafa;
}

.instagram-wrapper {
    max-width: 400px;
    margin: 0 auto;
}

/* Header styles */
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #ddd;
    background-color: #fff;
}

.logo img {
    max-width: 100px;
}

.search-bar input {
    width: 100px;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.icons img {    
    width: 30px;
    margin-left: 1rem;
}

/* Main Content styles */
.main-content {
    padding: 1rem;
}

.posts {
    display: grid;  
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.post img {
    max-width: 100%; /* Ensure the image doesn't exceed its container */
    height: auto; /* Maintain aspect ratio */
    border-radius: 10px;
}


.footer {
    display: flex;
    justify-content: space-around; /* Center the icons horizontally */
    align-items: center;
    padding: .3rem 1rem; /* Adjust padding as needed */
    margin-left: -25px;
    background-color: #fff;
    position: fixed;
    bottom: 0;
    width: 100%;
    border-top: 1px solid #ddd;
}




.footer img {
    width: 30px;
}


.posts {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 60px; /* Adjust this value as needed */
}

    </style>
</head>
<body>
    <div class="instagram-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <img src="logo.png" alt="Logo">
            </div>
            <form class="d-flex ms-4" action="search_product.php" method="get">
            <input type="text" id="searchInput" name="search_data_product" placeholder="Search..." class="form-control me-">

    </form>
            <div class="icons">
               <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABdklEQVR4nO2YvUrEQBRGjyhbWNhoLfb6Altrr2ApvoOwiNgpEjeCvoC2Yilir53F9mLrD+5aaePv7gpXFqaQIYqZTJwbmANfE7jhfMxkEgKRSCSihW3gHRCTZ+ACWKQCDBlh+SEJFSCxVsBOnYoxBhx/K7BPBan/siKh8gFs/bXAKPCpQFqsvORZhSsFwmLlMk+BIwXCYuUwT4FVBcJipZGnwJwCYbEym6fAuAJhsTJBTu4USIvJLQ6cKhAXkxOXApsKxMVkw6XAggJxMZl3KTClQFxMJl0/tx8VyD8ZFyfOFRQ4owB7CgrsFimwrKDAUpECMwoKTBcpMAy8BpR/A0YoSCtggRaefr2EKpD4KDB4oXUDyHddX2BZNAIUWMEz60D/H8T7wBolMThWD4AboOdRugdcm3sXOjYjVaIG7AAdoA2k5lpZc95JM/ZyWuKcdzoZIg8lznmnnSFyX+Kcd7K2QrPEOe/UjEzb4SFOHeYikUgEHXwBuF1wkXezgGIAAAAASUVORK5CYII=">
            </div>
        </header>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Posts -->
            <div class="posts" id="posts">
                <div class='row'>
                    <div class='col md-10'>
                       <div class='row'>
            
                  <?php
                      // Call the getcategories function to populate the dropdown
                      searchProduct();
                    ?>  
            </div>
        </main>
        <!-- Footer -->
        <footer class="footer">
          <a href="index.php">
            <img width="24" height="24" src="https://img.icons8.com/material-sharp/24/home.png" alt="home"/>
            </a>
            
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABdklEQVR4nO2YvUrEQBRGjyhbWNhoLfb6Altrr2ApvoOwiNgpEjeCvoC2Yilir53F9mLrD+5aaePv7gpXFqaQIYqZTJwbmANfE7jhfMxkEgKRSCSihW3gHRCTZ+ACWKQCDBlh+SEJFSCxVsBOnYoxBhx/K7BPBan/siKh8gFs/bXAKPCpQFqsvORZhSsFwmLlMk+BIwXCYuUwT4FVBcJipZGnwJwCYbEym6fAuAJhsTJBTu4USIvJLQ6cKhAXkxOXApsKxMVkw6XAggJxMZl3KTClQFxMJl0/tx8VyD8ZFyfOFRQ4owB7CgrsFimwrKDAUpECMwoKTBcpMAy8BpR/A0YoSCtggRaefr2EKpD4KDB4oXUDyHddX2BZNAIUWMEz60D/H8T7wBolMThWD4AboOdRugdcm3sXOjYjVaIG7AAdoA2k5lpZc95JM/ZyWuKcdzoZIg8lznmnnSFyX+Kcd7K2QrPEOe/UjEzb4SFOHeYikUgEHXwBuF1wkXezgGIAAAAASUVORK5CYII=">
          
              <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAACvklEQVR4nO2Zz2oUQRCHP1eNK6gYDx4SNSfx4BvIigeVHA3RJORkEhWPgoJo8gJq8gCCtxiSk0nwASTgQaLo0Y3GKKhnd3UVRYkrDdXLOMyfnpme7QnsBwXLTHVv/Xaqq6tnocPWoQsYAeaBNeC72JpcGxafQnIe2ACaMfYOGKRAbAdmDAL32zRQogDMpAhe290ipE0zow24Cr5L8jmrgPeuFvaIheC1DbkQsGBRwJwLAW8tClD7RNtpWBTQ2OoCvroQ8MaigKoLAfMWBTx0IWDYooALLgTsBNYtBL/hskMdtCDgHI6ZzhD8HQpACbiXshMtRDutGTBcE+tFSJuohT0kvU1VNruGfJ6TaqN8OnRoEweACWA54C3HEjAOdFNAdgNT0uQ1Y6wOTMqYSI4DK8Aviy2Ett/AKfmeQ8DLFHO8AHrDgj8G/MghcG3XPMF/jvA7AVQi7n8KE/E4x+BXgW2SAnG/vCbuSZTJeHj5CfR5xvfJtSDfs+IzZTCvJs7vVsvTcECQzXrGz4b4vPZUG5MFqzFZ2P9Vp80UAtSYw2KbMc3chOGcGhPfsZY38CWFADVmh1jY+NMy/3IOAha9Ap6mEKCOnHHHz6MJz9eaxK9qbqcQMOoZPxris0fuf/OVyrRUPPOoOVsclC3cNPg/vkXULdf8fnsDBKgg0nIyTIDiegIBTwImXwnwUxtkXilU9QdQSvAqRYn1cyPA74zcW8pBwKOwf2NU6fsbM7jfk0L7ZCO7FPEHx3gOAi4SgToSfkiQUlHHS72R1S0KqAH7iUEdDa8Azw2eSFjPctlzsJ+0KOAmCVEpchW4DzyTp1OTyerSYaq95IEE7e2TNGURlVXAalAz1y56pSUOC67iK5V++wj04Jge+RWTpuQr4AgFoSwtscnCrknO76KAqFI8JvuE/z3TopTK2GrTAcf8A1ndmG9FusqYAAAAAElFTkSuQmCC">
        </footer>
    </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Get the search input field
    var searchInput = document.getElementById("searchInput");

    // Function to perform search
    function performSearch() {
        var searchQuery = searchInput.value.trim(); // Trim leading and trailing whitespace
        // Perform search operation with the searchQuery
        // You can use AJAX to send the search query to the server and update the search results dynamically
        console.log("Searching for:", searchQuery);
    }

    // Event listener to detect user input in the search field
    searchInput.addEventListener("input", function() {
        // Delay the search operation by 300 milliseconds after the user stops typing
        clearTimeout(this.timer);
        this.timer = setTimeout(performSearch, 300);
    });
});

  </script>
</body>
</html>
